var currentlyToggled = '';
var toggleHandler = function(btn, pressed){
	var clickedButton = btn.getText();
	currentlyToggled = clickedButton;
}





function validateInput(operation, field, value) {
	if(operation == '' || field == '' || value == '')
		return 0;
	return 1;
}
function AddTextBoxValues(){
  
  if(Ext.getCmp('FCY_AMOUNT_L').getValue()!=''){
  	FCY_AMOUNT_L=Ext.getCmp('FCY_AMOUNT_L').getValue();
   AddParameter("<=",'FCY_AMOUNT',Ext.getCmp('FCY_AMOUNT_L').getValue());
  }if(Ext.getCmp('FCY_AMOUNT_G').getValue()!=''){
  	FCY_AMOUNT_G=Ext.getCmp('FCY_AMOUNT_G').getValue();
  	AddParameter(">=","FCY_AMOUNT",Ext.getCmp('FCY_AMOUNT_G').getValue());
  }if(Ext.getCmp('name_of_exporter').getValue()!=''){
  	name_of_exporter=Ext.getCmp('name_of_exporter').getValue();
  	AddParameter("LIKE","IbdOdbp.name_of_exporter",Ext.getCmp('name_of_exporter').getValue());
  }


}

function AddParameter(currentlyToggled,field, value){

	if(!validateInput(currentlyToggled,field,value)){
		Ext.Msg.alert('Invalid Input','Your Input is Invalid');
		return;
	}
	
	if(currentlyToggled == "LIKE"){
		row = [[field, '\'' + field + ' LIKE\' => \'%' + value + '%\'']];
	}
	else if(currentlyToggled == "="){
		row = [[field, '\'' + field + '\' => \'' + value + '\'']];
	}
	else if(currentlyToggled == ">="){
        row = [[field, '\'' + field + ' >= \' => \'' + value + '\'']];
	}
	else if(currentlyToggled == "<="){
        row = [[field, '\'' + field + ' <= \' => \'' + value + '\'']];
	}
	else
		row = [[ field , "'" + field + ' ' + currentlyToggled + '\' => ' + InsertQuotations(value) ]];
	ParamStore.loadData(row,true);
	//ParamStore.reload();

	//Ext.getCmp('param_view').doLayout();
}

function InsertQuotations(value) {
	var quotedString = '';
	var values = value.split(',');
	for( i = 0; i < values.length; i++){
		if(i > 0)
			quotedString += ', ';
		quotedString += "'" + values[i].trim() + "'";
	}
	return quotedString;
}

function RemoveParameters(records){
		ParamStore.remove(records);
		ParamStore.reload();
}


function finalGrouping(records){
	var conditionsParameter = '';
	for(i = 0; i < records.length; i++){
			if(conditionsParameter == ''){
				conditionsParameter += 'array( ' + records[i].get('text') + ' )';
			}
			else
				conditionsParameter += ', array( ' + records[i].get('text') + ' )';
	}
	return conditionsParameter;
}


var SearchValue = new Ext.form.TextField({
	id: 'Search_Value',
	fieldLabel: '<?php __('Value'); ?>',
	anchor: '100%'
});

var ibdPurchaseOrderSearchForm = new Ext.form.FormPanel({
	 labelWidth: 100, // label settings here cascade unless overridden
        url:'save-form.php',
        
        bodyStyle:'padding:5px 5px 0',
        width: 350,
        autoHeight:true,
        defaults: {width: 230},

        items: [{
        	    id:'from_date',
                fieldLabel: 'From Date',
                value: from_date,
                xtype:'datefield',
                name: 'date',
                allowBlank: true, 
                listeners: {
			    	select: function(obj,d){
			    		
			    		from_date=(d.getMonth()+1)+'/'+ d.getDate()+'/'+d.getFullYear();
			    		AddParameter(">=",obj.name,d.getFullYear()+"-"+ (d.getMonth()+1) +"-"+d.getDate());
			    	}
			    }
            },{
            	id:'to_date',
            	value: to_date,
                fieldLabel: 'To Date',
                xtype:'datefield',
                name: 'date',
                allowBlank: true, 
                listeners: {
			    	select: function(obj,d){
			    		to_date=(d.getMonth()+1)+'/'+ d.getDate()+'/'+d.getFullYear();
			    		AddParameter("<=",obj.name,d.getFullYear()+"-"+(d.getMonth()+1) +"-"+d.getDate());
			    	}
			    }
            },{
                id: 'name_of_exporter',
                fieldLabel:'Name of Exporter',
                xtype:'textfield',
                value:name_of_exporter,
                allowBlank: true, 
                name: 'fct'
            },{
                id: 'FCY_AMOUNT_G',
                fieldLabel:'Fcy Amount(>=)',
                xtype:'textfield',
                value:FCY_AMOUNT_G,
                allowBlank: true, 
                name: 'fct'
            },{
            	id: 'FCY_AMOUNT_L',
            	value: FCY_AMOUNT_L,
                fieldLabel:'Fcy Amount(<=)',
                name: 'fct',
                allowBlank: true, 
                xtype:'textfield'
            },{
            	  store: new Ext.data.ArrayStore({ 
				    	id: 0, fields: [ 'id', 'name' ], 
					data: [ <?php $st = false;  foreach ($po as $k => $v) {
                    if ($st)
                        echo ',';
                    echo '[\'' . $k . '\', \'' . $v . '\']';
                    $st = true;
                    } ?> ]}), 
                fieldLabel:'REF No',
                name: 'ref_no',
                 id: 'ref_no',
                 value: ref_no,
                xtype:'combo',
             	typeAhead: true, 
			    emptyText: 'Select One', 
			    editable: true, 
			    forceSelection: true, 
			    triggerAction: 'all', 
			    lazyRender: true, 
			    mode: 'local', 
			    valueField: 'id', 
			    displayField: 'name', 
			    allowBlank: true, 
			    anchor: '100%',
			    listeners: {
			    	select: function(obj,r,i){
			    		ref_no=r.data.id;
			    		AddParameter("=",obj.name,r.data.id);
			    	}
			    }

            },
{
            	  store: new Ext.data.ArrayStore({ 
				    	id: 0, fields: [ 'id', 'name' ], 
					data: [ <?php $st = false;  foreach ($NBE_Ref_nos as $k => $v) {
                    if ($st)
                        echo ',';
                    echo '[\'' . $k . '\', \'' . $v . '\']';
                    $st = true;
                    } ?> ]}), 
                fieldLabel:'NBE Ref no',
                name: 'NBE_Ref_no',
                 id: 'NBE_Ref_no',
                 value: NBE_Ref_no,
                xtype:'combo',
             	typeAhead: true, 
			    emptyText: 'Select One', 
			    editable: true, 
			    forceSelection: true, 
			    triggerAction: 'all', 
			    lazyRender: true, 
			    mode: 'local', 
			    valueField: 'id', 
			    displayField: 'name', 
			    allowBlank: true, 
			    anchor: '100%',
			    listeners: {
			    	select: function(obj,r,i){
			    		NBE_Ref_no=r.data.id;
			    		AddParameter("=",obj.name,r.data.id);
			    	}
			    }

            },
            {
            	  store: new Ext.data.ArrayStore({ 
				    	id: 0, fields: [ 'id', 'name' ], 
					data: [ <?php $st = false;  foreach ($permit_nos as $k => $v) {
                    if ($st)
                        echo ',';
                    echo '[\'' . $k . '\', \'' . $v . '\']';
                    $st = true;
                    } ?> ]}), 
                fieldLabel:'Permit No',
                name: 'permit_no',
                 id: 'permit_no',
                 value: permit_no,
                xtype:'combo',
             	typeAhead: true, 
			    emptyText: 'Select One', 
			    editable: true, 
			    forceSelection: true, 
			    triggerAction: 'all', 
			    lazyRender: true, 
			    mode: 'local', 
			    valueField: 'id', 
			    displayField: 'name', 
			    allowBlank: true, 
			    anchor: '100%',
			    listeners: {
			    	select: function(obj,r,i){
			    		permit_no=r.data.id;
			    		AddParameter("=",obj.name,r.data.id);
			    	}
			    }

            }
            ,{
            	store: new Ext.data.ArrayStore({ 
		    	id: 0, fields: [ 'id', 'name' ], 
				data: [ <?php $st = false;  foreach ($currencies as $k => $v) {
                if ($st)
                    echo ',';
                echo '[\'' . $k . '\', \'' . $v . '\']';
                $st = true;
                } ?> ]}), 
                fieldLabel:'Currency Id',
                name: 'currency_id',
                id: 'currency_id',
                value: currency_id,
                xtype:'combo',
            	typeAhead: true, 
			    emptyText: 'Select One', 
			    editable: true, 
			    forceSelection: true, 
			    triggerAction: 'all', 
			    lazyRender: true, 
			    mode: 'local', 
			    valueField: 'id', 
			    displayField: 'name', 
			    allowBlank: true, 
			    anchor: '100%',
			     listeners: {
			    	select: function(obj,r,i){
			    		currency_id=r.data.id;
			    		AddParameter("=",obj.name,r.data.id);
			    	}
			    }

            }
            
            
        ],

        buttons: [
        {
            xtype: 'button',
			text: '<?php __('Search'); ?>',
			handler: function(){
				console.log(ParamStore.getRange(0,ParamStore.getCount()));
				AddTextBoxValues();
				if(ParamStore.getCount() == 0)
					Ext.Msg.alert('<?php __('Invalid Input'); ?>','<?php __('Please input at least one search parameter'); ?>');
				else{
					export_all=false;
					SearchLocalWindow.close();
					var conditions = finalGrouping(ParamStore.getRange());
					store_ibdOdbps.reload({
						  params: {
								start: 0,
								limit: list_size,
								conditions: conditions
						   }
					});
				}
			}
		},
		{
            text: 'Reset',
            handler: function(){
            		
            	  permit_no='';
         		  currency_id=null;
         		  FCY_AMOUNT_G="";
                  FCY_AMOUNT_L="";
                  from_date=null;
                  to_date=null;
                  NBE_Ref_no=null;
                  ref_no=null;
                  name_of_exporter=null;

                  Ext.getCmp('FCY_AMOUNT_G').setValue('');
				  Ext.getCmp('FCY_AMOUNT_L').setValue('');
                  Ext.getCmp('currency_id').setValue('');
                  Ext.getCmp('permit_no').setValue('');
                  Ext.getCmp('NBE_Ref_no').setValue('');
                  Ext.getCmp('from_date').setValue('');
                  Ext.getCmp('to_date').setValue('');
                    Ext.getCmp('ref_no').setValue('');
                      Ext.getCmp('name_of_exporter').setValue('');
                  ParamStore.removeAll();
            }
        }
        ,{
            text: 'Cancel',
            handler: function(){
            	SearchLocalWindow.close();
            }
        }]
});

var SearchLocalWindow = new Ext.Window({
	title: '<?php __('Search IbdPurchaseOrder'); ?>',
	modal: true,
	items: ibdPurchaseOrderSearchForm,
	resizable: false,
	width: 400,
	autoHeight: true,
	bodyStyle: 'padding: 5px;',
	layout: 'fit',
	plain: true
});