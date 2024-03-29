<?php

class GradesController extends AppController {

    var $name = 'Grades';

    function index() {
        
    }
  function index3() {
        
    }
    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");

        $this->set('grades', $this->Grade->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->Grade->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid grade', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Grade->recursive = 2;
        $this->set('grade', $this->Grade->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->Grade->create();
            $this->autoRender = false;
            if ($this->Grade->save($this->data)) {
                $ids = $this->Grade->getLastInsertId();
                $this->loadModel('Step');
                $this->Step->recursive = -1;
                $stp = $this->Step->find('all');

                for ($i = 0; $i < count($stp); $i++) {
                    $dt['Scale'] = array("grade_id" => $ids, "step_id" => $stp[$i]['Step']['id'], "salary" => 0);
                    $this->Grade->Scale->create();
                    $this->Grade->Scale->save($dt);
                }
                $this->Session->setFlash(__('The grade has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The grade could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid grade', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Grade->save($this->data)) {
                $this->Session->setFlash(__('The grade has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The grade could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('grade', $this->Grade->read(null, $id));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for grade', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Grade->delete($i);
                }
                $this->Session->setFlash(__('Grade deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Grade was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Grade->delete($id)) {
                $this->Session->setFlash(__('Grade deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Grade was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

?>