<?php
class CashStoresController extends AppController {

	var $name = 'CashStores';
	
	function index() {
		$employees = $this->CashStore->Employee->find('all');
		$this->set(compact('employees'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
		if($id)
			$employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($employee_id != -1) {
            $conditions['CashStore.employee_id'] = $employee_id;
        }
		
		$this->set('cash_stores', $this->CashStore->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->CashStore->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid cash store', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->CashStore->recursive = 2;
		$this->set('cashStore', $this->CashStore->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->CashStore->create();
			$this->autoRender = false;
			if ($this->CashStore->save($this->data)) {
				$this->Session->setFlash(__('The cash store has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The cash store could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$employees = $this->CashStore->Employee->find('list');
		$budget_years = $this->CashStore->BudgetYear->find('list');
		$this->set(compact('employees', 'budget_years'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid cash store', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->CashStore->save($this->data)) {
				$this->Session->setFlash(__('The cash store has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The cash store could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('cash_store', $this->CashStore->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$employees = $this->CashStore->Employee->find('list');
		$budget_years = $this->CashStore->BudgetYear->find('list');
		$this->set(compact('employees', 'budget_years'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for cash store', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->CashStore->delete($i);
                }
				$this->Session->setFlash(__('Cash store deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Cash store was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->CashStore->delete($id)) {
				$this->Session->setFlash(__('Cash store deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Cash store was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>