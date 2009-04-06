<?php
/*
 * implementation hook oaliquid_plugin_xxx_form
 */
function oaliquid_plugin_grid_form($vid, $name, $type, $layout, $preset) 
{
	$o = oaliquid_get_options($vid, $name, $type, $layout, $preset, 'oaliquid_plugin_grid_defaults');

    $form['help'] = array('#type' => 'markup', '#value' => t('description of the grid plugin'));

	$form['cols'] = array(
      '#type' => 'textfield',
      '#title' => t('Number of colunm'),
      '#default_value' => $o['cols'],
    );
	
	$form['add_empty_col_begin'] = array(
      '#type' => 'checkbox',
      '#title' => t('Add an empty collumn at the begin of the table'),
      '#default_value' => $o['add_empty_col_begin'],
    );
    
    $form['add_empty_col_end'] = array(
      '#type' => 'checkbox',
      '#title' => t('Add an empty collumn at the end of the table'),
      '#default_value' => $o['add_empty_col_end'],
    );
    
	$form['table_style'] = array(
      '#type' => 'textfield',
      '#title' => t('Table style class'),
      '#default_value' => $o['table_style'],
    );
	
	$form['table_istyle'] = array(
      '#type' => 'textarea',
      '#title' => t('Table style Inline'),
      '#default_value' => $o['table_istyle'],
    );

    $form['style'] = array(
      '#type' => 'textfield',
      '#title' => t('Cell style class'),
      '#default_value' => $o['style'],
    );
    
    $form['istyle'] = array(
      '#type' => 'textarea',
      '#title' => t('Cell style Inline'),
      '#default_value' => $o['istyle'],
    );
	
	oaliquid_general_plugin_form($o, $form);
	oaliquid_injection_plugin_form($o, $form);
	oaliquid_gwt_plugin_form($o, $form);
	oaliquid_link_plugin_form($o, $form);
	oaliquid_field_plugin_form($o, $form);
    oaliquid_template_plugin_form($o, $form);
	oaliquid_submit_plugin_form($o, $vid, $name, $type, $layout, $preset, $form);
	
	return $form;
}

/*
 * implementation hook oaliquid_plugin_xxx_defaults
 */
function oaliquid_plugin_grid_defaults()
{
  $o = array();
  $o['cols'] = 3;
  $o['add_empty_col_begin'] = false;
  $o['add_empty_col_end'] = true;
  $o['table_style'] = '';
  $o['table_istyle'] = 'margin:4px; padding:4px;';
  $o['style'] = '';
  $o['istyle'] = 'width:120px; border:1px solid gray;';

  oaliquid_general_plugin_options($o);
  oaliquid_injection_plugin_options($o);
  oaliquid_gwt_plugin_options($o);
  oaliquid_link_plugin_options($o);
  oaliquid_field_plugin_options($o);
  oaliquid_template_plugin_options($o);
  
  return $o;
}

/*
 * implementation hook oaliquid_plugin_xxx_view
 */
function oaliquid_plugin_grid_view($view, $nodes, $type, $o) 
{
  return view_oaliquid_plugin_view_decorate(_oaliquid_plugin_grid_view(oaliquid_plugin_view($view, $nodes, $type, $o), $o), $view, $o);
}

/*
 * implementation hook oaliquid_plugin_xxx_view_list
 */
function oaliquid_plugin_grid_view_list($view, $nodes, $type, $o) 
{
  return view_oaliquid_plugin_view_decorate(_oaliquid_plugin_grid_view(oaliquid_plugin_view_list($view, $nodes, $type, $o), $o), $view, $o);
}

//------------------------------------------------------------------------

function oaliquid_plugin_grid_form_submit($form_id, $form_values) 
{
	$o = array();
	$o['table_style'] = $form_values['table_style'];
	$o['table_istyle'] = $form_values['table_istyle'];
	$o['style'] = $form_values['style'];
	$o['istyle'] = $form_values['istyle'];
	$o['cols'] = (is_numeric($form_values['cols']))? $form_values['cols'] : 3;
	$o['add_empty_col_begin'] = $form_values['add_empty_col_begin'];
	$o['add_empty_col_end'] = $form_values['add_empty_col_end'];

	return oaliquid_plugin_submit($form_id, $form_values, $o);
}

function _oaliquid_plugin_grid_view($items, $o)
{
  $output = '<table border="0" cellspacing="0"';

  if($o['table_style'])
  $output .= ' class="'.$o['table_style'].'"';

  if($o['table_istyle'])
  $output .= ' style="'.$o['table_istyle'].'"';
  
  $output .= '>';

  //---

  $TD = '<td';
  
  if($o['style'])
  $TD .= ' class="'.$o['style'].'"';
  
  if($o['istyle'])
  $TD .= ' style="'.$o['istyle'].'"';
  
  $TD .= '>';
  
  //---
  
  $OPEN_ROW = ($o['add_empty_col_begin'])? '<tr><td> </td>' : '<tr>';
  $CLOSE_ROW = ($o['add_empty_col_end'])? '<td> </td></tr>' : '</tr>';
  $cols = $o['cols']-1;

  if($cols<1)
  {
  	foreach ($items as $item)
    {
		$output .= $OPEN_ROW;
	    $output .= $TD;
	    $output .= $item;
	    $output .= '</td>';
	    $output .= $CLOSE_ROW;
    }
  }
  else
  {
  	  $c = $cols;

	  for ($i=0;$i<count($items);$i++)
	  {
	  	$item = $items[$i];
	    $c = $i%($cols+1);
	    
	    switch ($c) 
	    {
	      case 0:
	        $output .= $OPEN_ROW;
	        $output .= $TD;
	        $output .= $item;
	        $output .= '</td>';
	        break;
	      case $cols:
	        $output .= $TD;
	        $output .= $item;
	        $output .= '</td>';
	        $output .= $CLOSE_ROW;
	        break;
	      default:
	        $output .= $TD;
	        $output .= $item;
	        $output .= '</td>';
	        break;
	    }
	  }
	  
	  while($c<$cols)
	  {
	  	$output .= '<td> </td>';
	  	$c++;
	  	
	  	if($c==$cols)
	  	$output .= $CLOSE_ROW;
	  }
  }
  
  $output .= '</table>';
  
  return $output;
}