<?php
/*
 * implementation hook oaliquid_plugin_xxx_defaults
 */
function oaliquid_plugin_freeform_defaults()
{
  $o = array();
  
  oaliquid_view_options($o, true);
  oaliquid_node_options($o);
  oaliquid_field_options($o);
  
  return $o;
}

/*
 * implementation hook oaliquid_plugin_xxx_form
 */
function oaliquid_plugin_freeform_form($vid, $name, $type, $layout, $preset) 
{
	$o = oaliquid_get_options($vid, $name, $type, $layout, $preset, 'oaliquid_plugin_freeform_defaults');

	$form['help'] = array('#type' => 'markup', '#value' => t('description of the freeform plugin'));

	oaliquid_view_form($o, $form, true);
	oaliquid_node_form($o, $form);
	oaliquid_field_form($o, $form);
    
	oaliquid_submit_plugin_form($o, $vid, $name, $type, $layout, $preset, $form);

	return $form;
}

function oaliquid_plugin_freeform_form_submit($form_id, $form_values) 
{
	$o = array();
	
	return oaliquid_plugin_submit($form_id, $form_values, $o);
}

/*
 * implementation hook oaliquid_plugin_xxx_view
 */
function oaliquid_plugin_freeform_view($view, $nodes, $type, $o) 
{
  return view_oaliquid_plugin_view_decorate(oaliquid_plugin_node_view_view($view, oaliquid_plugin_view($view, $nodes, $type, $o), $o), $view, $o);
}

/*
 * implementation hook oaliquid_plugin_xxx_view_list
 */
function oaliquid_plugin_freeform_view_list($view, $nodes, $type, $o) 
{
  return view_oaliquid_plugin_view_decorate(oaliquid_plugin_node_view_view($view, oaliquid_plugin_view_list($view, $nodes, $type, $o), $o), $view, $o);
}

//------------------------------------------------------------------------

function _oaliquid_plugin_freeform_view($items, $o)
{
  ob_start(); 
  print eval('?>'. $o['viewtemplate']); 
  $output = ob_get_contents(); 
  ob_end_clean(); 
  return $output; 
}