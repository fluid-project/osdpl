<?php
/*
 * implementation hook oaliquid_plugin_xxx_defaults
 */
function oaliquid_plugin_liquid_defaults()
{
  $o = array();
  $o['align'] = 'left';
  $o['style'] = '';
  $o['istyle'] = 'width:120px; margin:4px; padding:4px; border:1px solid gray;';
  
  oaliquid_view_options($o);
  oaliquid_node_options($o);
  oaliquid_field_options($o);
  
  return $o;
}

/*
 * implementation hook oaliquid_plugin_xxx_form
 */
function oaliquid_plugin_liquid_form($vid, $name, $type, $layout, $preset) 
{
	$o = oaliquid_get_options($vid, $name, $type, $layout, $preset, 'oaliquid_plugin_liquid_defaults');

    $form['help'] = array('#type' => 'markup', '#value' => t('description of the liquid plugin'));

	$form['align'] = array(
	  '#type' => 'select',
      '#title' => t('Alignment'),
      '#default_value' => $o['align'],
      '#options' => array('left'=>'left', 'right'=>'right'),
	);
	
	$form['style'] = array(
      '#type' => 'textfield',
      '#title' => t('Cell style class'),
      '#default_value' => $o['style'],
    );
	
	$form['istyle'] = array(
      '#type' => 'textarea',
      '#title' => t('Cell style inline'),
      '#default_value' => $o['istyle'],
    );
    
	oaliquid_view_form($o, $form);
	oaliquid_node_form($o, $form);
	oaliquid_field_form($o, $form);
    
	oaliquid_submit_plugin_form($o, $vid, $name, $type, $layout, $preset, $form);

	return $form;
}

function oaliquid_plugin_liquid_form_submit($form_id, $form_values) 
{
	$o = array();
	$o['align'] = $form_values['align'];
	$o['style'] = $form_values['style'];
	$o['istyle'] = $form_values['istyle'];
	
	return oaliquid_plugin_submit($form_id, $form_values, $o);
}

/*
 * implementation hook oaliquid_plugin_xxx_view
 */
function oaliquid_plugin_liquid_view($view, $nodes, $type, $o) 
{
  return view_oaliquid_plugin_view_decorate(_oaliquid_plugin_liquid_view(oaliquid_plugin_view($view, $nodes, $type, $o), $o), $view, $o);
}

/*
 * implementation hook oaliquid_plugin_xxx_view_list
 */
function oaliquid_plugin_liquid_view_list($view, $nodes, $type, $o) 
{
  return view_oaliquid_plugin_view_decorate(_oaliquid_plugin_liquid_view(oaliquid_plugin_view_list($view, $nodes, $type, $o), $o), $view, $o);
}

//------------------------------------------------------------------------

function _oaliquid_plugin_liquid_view($items, $o)
{
  $output = '<div class="clear-block clear">';
  
  $div  = '<div ' .
  $div .= ($o['style'])? 'class="'.$o['style'].'" ' : '';
  $div .= 'style="float:' . $o['align'];
  $div .= ($o['istyle'])? '; '.$o['istyle'].'">' : ';">';
  
  foreach ($items as $item)
  {
	$output .= $div.$item.'</div>';
  }
  
  $output .= '</div>';
  
  return $output;
}