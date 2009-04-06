<?php
/*
http://drupal.org/node/115139

Description

I learned that outputting JSON is not always straightforward: For example, 
when devel.module is enabled, it could add a query log to the request, 
even if you exit right after your print drupal_to_js(...). 
Moshe told me that changing the Content-type in the HTTP header 
to text/javascript solves the problem.

Another issue with JSON output is that hook_exit is not called when 
you exit right in the menu callback function. Therefore I introduced 
a new return constant in the menu system: MENU_NO_THEME. Return this 
value whenever you take care of the page content yourself and don’t 
want Drupal to add the theme.

The new drupal_json($var = NULL) takes care of both issues: simply 
return drupal_json($json) in your menu callback and you’re done. 
It sets the header appropriately, converts the variable to JSON 
and returns MENU_NO_THEME.

(note that autocomplete is currently broken in 6-dev due to the menu patch)
*/

/*
 * implementation hook oaliquid_plugin_xxx_form
 */
function oaliquid_plugin_json_form($vid, $name, $type, $layout, $preset) 
{
	$o = oaliquid_get_options($vid, $name, $type, $layout, $preset, 'oaliquid_plugin_json_defaults');

    $form['php'] = array(
      '#type' => 'textarea',
      '#title' => t('php'),
      '#default_value' => $o['php'],
      '#description' => t('define a function to return the value for each field. Arugment passed to this function depend of the type of layout, for liquid: ($node, $o) for liquid_list: ($field, $fields, $value, $o) where $o contient options define for the json plugin'),
    );
    
    $bool = ($o['json_output'] && !$o['first_node'])? true : false;
	
	$form['block_debug'] = array(
      '#type' => 'fieldset',
      '#title' => t('Debug options'),
      '#collapsible' => TRUE,
      '#collapsed' => $bool,
      '#tree' => FALSE,
    ); 
    
    $form['block_debug']['json_output'] = array(
      '#type' => 'checkbox',
      '#title' => t('JSON output'),
      '#default_value' => $o['json_output'],
    );
    
    //debug
    $form['block_debug']['first_node'] = array(
      '#type' => 'checkbox',
      '#title' => t('Process only the first node'),
      '#default_value' => $o['first_node'],
    );
    
    //TODO $o['theme_views_view']?
    
	oaliquid_general_plugin_form($o, $form);
	oaliquid_link_plugin_form($o, $form);
	oaliquid_field_plugin_form($o, $form);
    oaliquid_template_plugin_form($o, $form);
	oaliquid_submit_plugin_form($o, $vid, $name, $type, $layout, $preset, $form);
	
	return $form;
}

/*
 * implementation hook oaliquid_plugin_xxx_defaults
 */
function oaliquid_plugin_json_defaults()
{
  $o = array();
  $o['json_output'] = true;
  $o['first_node'] = false;
  $o['php'] = ''; 
  
  //Example of some php code
  //'return array($node->title, $node->body, $node->field_test_image);';
  //'return $node->field_test_image;';
  //'$a1 = $node->field_test_image; if($a1){$a2 =$a1[0];$o = array();foreach($a1 as $a)$o[] = $a['filepath'];return $o;}return null;return $o;';

  oaliquid_general_plugin_options($o);
  oaliquid_link_plugin_options($o);
  oaliquid_field_plugin_options($o);
  oaliquid_template_plugin_options($o);

  return $o;
}

/*
 * implementation hook oaliquid_plugin_xxx_init_defaults
 */
function oaliquid_plugin_json_init_defaults(&$o)
{
	if(!$o['theme_views_view'])
	$o['theme_views_view'] = 'return _oaliquid_theme_view_clean($view, $type, $nodes, $level, $args);';
}
/*
 * implementation hook oaliquid_plugin_xxx_view
 */
function oaliquid_plugin_json_view($view, $nodes, $type, $o) 
{
  $func = $o['php']? create_function('$node, $o', $o['php']) : false;
	
  if(!$func)
  return _oaliquid_plugin_json_view(oaliquid_plugin_view($view, $nodes, $type, $o), $o);

  $items = array();

  foreach ($nodes as $count => $n) 
  {
	$items[] = $func(node_load($n->nid), $o);
  }
  
  return _oaliquid_plugin_json_view($items, $o);
}

/*
 * implementation hook oaliquid_plugin_xxx_view_list
 */
function oaliquid_plugin_json_view_list($view, $nodes, $type, $o) 
{
	//$field, $fields, $value, $o
	
  $func = $o['php']? create_function('$field, $fields, $value, $o', $o['php']) : false;
	
  if(!$func)
  return _oaliquid_plugin_json_view(oaliquid_plugin_view_list($view, $nodes, $type, $o), $o);
  
  $items = array();
  $fields = _views_get_fields();

  if($o['separate_field'])
  {
	foreach ($nodes as $node) 
	{
    	foreach ($view->field as $field) 
	    {
	      if ($fields[$field['id']]['visible'] !== FALSE) 
	      {
	      	$items[] = $func($field, $fields, views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view), $o);
	      }
	    }
	}
  }
  else
  {
	foreach ($nodes as $node) 
	{
		$item = array();
		
    	foreach ($view->field as $field) 
	    {
	      $item[] = $func($field, $fields, views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view), $o);
	    }
	    
	    $items[] = $item;
	}
  }

  return _oaliquid_plugin_json_view($items, $o);
}

//------------------------------------------------------------------------

function oaliquid_plugin_json_form_submit($form_id, $form_values) {
	
	$o = array();
  	$o['json_output'] = $form_values['json_output'];
  	$o['first_node'] = $form_values['first_node'];
  	$o['php'] = trim($form_values['php']);
	
	return oaliquid_plugin_submit($form_id, $form_values, $o);
}

function _oaliquid_plugin_json_view($items, $o)
{
  if($o['first_node'] && count($items)>0)
  $items = array($items[0]);

  if($o['json_output'])
  return drupal_to_js($items);
  
  ob_start();
  htmlentities(print_r($items));
  $pre = '<div style="display:block"><pre>'.ob_get_contents().'</pre></div>';
  ob_end_clean();
  
  return $pre;
}