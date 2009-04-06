$Id: README.txt,v 1.2 2008/01/30 01:44:53 derhasi Exp $ README.txt,v 0.1 2008/01/28 17:00:00 derhasi Exp $

------------------The CCK Validation Field Module----------------------------

CCK Validation adds a content field, that lets you add custom validation to
your content types. With the included Widget 'Textarea PHP Code' you can add
the first custom validation rules.

-------------------------Usage--------------------------------------------------

---------- General -----------------------------------

Before you can use CCK Validation Field, you'll need to get CCK and enable (at the
very least) the 'content' module. 

To add a validation field to a content type, go to administer > content >
content types, select the content type you want to add to, and click on the
'add field' tab. One of the field types available should be 'Validation', and it
should have one bullet point under it, labelled 'Textarea PHP Code'. If you select
this, give your field a name, and submit the form, you will get to the
configuration page for your new computed field.


--------Configuration ---------------------------------------

WIDGET: Textarea PHP Code
-------------------------

With the included widget 'Textarea PHP Code' you are able to create a custom
validation code. You will execute it via form_set_error() call.

*	Process validation -- Select this option process validation on the node field's
  widget values or the node field's field values.
  
  Example:
  ========
  Field value of date selection field
  	[field_date] => Array ( [0] => Array ( [value] => 2005-01-01T02:04:00 )
  Widget value of date selection field
		[field_date] => Array ( [0] => Array ( [value] => Array ( [mday] => 1 [mon] => 1 [year] => 2005 [hours] => 2 [minutes] => 4 ) )
  

* Validation Code -- This is the code that process PHP code validate the node's
  values and when needed, execute form_set_error() for Validation error messages.


------------- Adding Widgets ----------------------------------

Module developers can add new widgets to CCK Validation.

Therefore you must ... :
	* set 'field types' => array('cck_validation') in hook_widget_info() of your module.
	* add a string-value or string-selection of a validation function
		to hook_widget_settings' $form['validation_function']:
	
		$form['validation_function'] = array(
		  	'#type' => 'value',
		  	'#value' => '_cck_validation_run_code',
		);
		
		The function called has to look like
			function function_name($node, $field, $node_field) {...
		
		and has to return form_set_error for creating validaton error messages.
			
		 
To add process selection (field or widget) you also have to add form
validation_process to your hook_widget_settings()
If validation_process is not set, default is WIDGET validation.

		$form['validation_process'] = array(
		  	'#type' => 'radios',
		  	'#title' => t('Process validation'),
		  	'#required,' => TRUE,
		  	'#options' => array('field'=>'field',0=>'widget'),
		  	'#default_value' => $widget['validation_process'],
		  );

--------Code Examples------------------------------------------

Test minimum length of a textfield (e.g. 4 chars)
-------------------------------------------------

- Validiation Code:
if (strlen($node->field_text[0]['value'])<4){
  form_set_error('field_text','text has to have a minimum of 4 chars!');
}

- Process validation
  can be set to both (field or widget)
  
Test date's year
----------------

- Validiation Code:
if ($node->field_date[0]['value']['year'] >= 2000){
  form_set_error('field_date','Date has to be before year 2000');
}

- Process validation
  WIDGET - 	for this code it has to be set to widget, because in field-validation
  				 	date-array isn't present anymore.



