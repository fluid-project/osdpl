<?php
// $Id: oaliquidpluginhelper.php,v 1.1.2.1 2007/11/28 02:01:41 oyoaha Exp $











//-------------------------------------------------------------------
// NODE: General options (page vs teaser and link display)
//-------------------------------------------------------------------

function oaliquid_general_plugin_options(&$o)
{
  $o['teaser'] = 'teaser';
  $o['page'] = false;
  $o['links'] = true;
}

function oaliquid_general_plugin_form($o, &$form) 
{
	$bool = ($o['teaser']=='teaser' && !$o['page'] && $o['links'])? true : false;
	$block = _getBlockNode($form, $bool);
	
	$form[$block]['block_general'] = array(
      '#type' => 'fieldset',
      '#title' => t('Basic node options'),
      '#collapsible' => TRUE,
      '#collapsed' => $bool,
      '#tree' => FALSE,
    ); 
	
	$form[$block]['block_general']['teaser'] = array(
	  '#type' => 'select',
      '#title' => t('Teaser category'),
      '#default_value' => $o['teaser'],
      '#options' => array('body'=>'body', 'teaser'=>'teaser'),
	);
	
	$form[$block]['block_general']['page'] = array(
      '#type' => 'checkbox',
      '#title' => t('Page'),
      '#default_value' => $o['page'],
    );
    
    $form[$block]['block_general']['links'] = array(
      '#type' => 'checkbox',
      '#title' => t('Links'),
      '#default_value' => $o['links'],
    );
    
    $form[$block]['block_general']['general_enable'] = array('#type' => 'value', '#value' => 'true');
}

function oaliquid_general_plugin_submit($form_id, $form_values, &$o)
{
	if($form_values['general_enable'])
	{
		$o['teaser'] = $form_values['teaser'];
	  	$o['page'] = $form_values['page'];
	  	$o['links'] = $form_values['links'];
	}
}

//-------------------------------------------------------------------
// VIEW: Information
//-------------------------------------------------------------------

function oaliquid_information_plugin_options(&$o)
{
		
}

function oaliquid_information_plugin_form($o, &$form)
{
	$block = _getBlockView($form, true);
	
	$form[$block]['information'] = array(
	      '#type' => 'fieldset',
	      '#title' => t('Information'),
	      '#collapsible' => TRUE,
	      '#collapsed' => TRUE,
	      '#tree' => FALSE,
	    );
	    
	$form[$block]['information']['general'] = array(
	      '#type' => 'fieldset',
	      '#collapsible' => FALSE,
	      '#tree' => FALSE,
	    );
	
	$form[$block]['information']['general']['id'] = array('#type' => 'markup', '#value' => 'id: '.$o['id']);
}

function oaliquid_information_plugin_submit($form_id, $form_values, &$o)
{
	
}

//-------------------------------------------------------------------
// VIEW: CSS and JS injection
//-------------------------------------------------------------------

function oaliquid_injection_plugin_options(&$o)
{
	$o['injectcss'] = '';
	$o['injectcsspreprocess'] = '';
	$o['injectjs'] = '';
	$o['injectjsheader'] = 'footer';
	$o['injectjsdefer'] = false;
	$o['injectjscache'] = true;
}

function oaliquid_injection_plugin_form($o, &$form)
{
	if(module_exists('oainjection'))
    {
    	$bool = !$o['injectcss'] && !$o['injectjs'];
    	$block = _getBlockView($form, $bool);
    	
		$form[$block]['block_oainjection'] = array(
	      '#type' => 'fieldset',
	      '#title' => t('Inject css/js'),
	      '#collapsible' => TRUE,
	      '#collapsed' => $bool,
	      '#tree' => FALSE,
	    );

	    $form[$block]['block_oainjection']['injectcss'] = array(
	      '#type' => 'textarea',
	      '#title' => t('ccs'),
	      '#default_value' => $o['injectcss'],
	    );

	    /* @param $preprocess
 		 *   (optional) Should this CSS file be aggregated and compressed if this
 		 *   feature has been turned on under the performance section?
 		 */
 		
	    //$preprocess = TRUE
	    
	    $form[$block]['block_oainjection']['injectcsspreprocess'] = array(
	      '#type' => 'checkbox',
	      '#title' => t('Let drupal aggregated and compressed this css file'),
	      '#default_value' => $o['injectcsspreprocess'],
	    );
	    
	    $form[$block]['block_oainjection']['injectjs'] = array(
	      '#type' => 'textarea',
	      '#title' => t('js'),
	      '#default_value' => $o['injectjs'],
	    );
	    
	    /*@param $scope
		 *   (optional) The location in which you want to place the script. Possible
		 *   values are 'header' and 'footer' by default. If your theme implements
		 *   different locations, however, you can also use these.
		 * @param $defer
		 *   (optional) If set to TRUE, the defer attribute is set on the <script> tag.
		 *   Defaults to FALSE. This parameter is not used with $type == 'setting'.
		 * @param $cache
		 *   (optional) If set to FALSE, the JavaScript file is loaded anew on every page
		 *   call, that means, it is not cached. Defaults to TRUE. Used only when $type
		 *   references a JavaScript file.
		 */
	    
	    //$scope = 'header', $defer = FALSE, $cache = TRUE)

	    $form[$block]['block_oainjection']['injectjsheader'] = array(
	      '#type' => 'select',
	      '#title' => t('Script location'),
	      '#default_value' => $o['injectjsheader'],
	      '#options' => array('footer'=>'footer', 'header'=>'header'),
	    );
	    
	    $form[$block]['block_oainjection']['injectjsdefer'] = array(
	      '#type' => 'checkbox',
	      '#title' => t('Defer loading of this script'),
	      '#default_value' => $o['injectjsdefer'],
	    );
	    
	    $form[$block]['block_oainjection']['injectjscache'] = array(
	      '#type' => 'checkbox',
	      '#title' => t('Let drupal cache this javascript file'),
	      '#default_value' => $o['injectjscache'],
	    );
		
	    $form[$block]['block_oainjection']['oainjection_cssname'] = array('#type' => 'value', '#value' => oainjection_cssKey($o['id'], 'module', 'all', $o['injectcsspreprocess']));
    	$form[$block]['block_oainjection']['oainjection_jsname'] = array('#type' => 'value', '#value' => oainjection_jsKey($o['id'], 'module', $o['injectjsheader'], $o['injectjsdefer'], $o['injectjscache']));
	    
	    $form[$block]['block_oainjection']['oainjection_enable'] = array('#type' => 'value', '#value' => 'true');
    }
}

function oaliquid_injection_plugin_submit($form_id, $form_values, &$o)
{
  	if($form_values['oainjection_enable'])
	{
		$o['injectcss'] = $form_values['injectcss'];
		$o['injectcsspreprocess'] = $form_values['injectcsspreprocess'];
		$o['injectjs'] = $form_values['injectjs'];
		$o['injectjsheader'] = $form_values['injectjsheader'];
		$o['injectjsdefer'] = $form_values['injectjsdefer'];
		$o['injectjscache'] = $form_values['injectjscache'];

		//clear old cache
		oainjection_cssDelete($form_values['oainjection_cssname']);
		oainjection_jsDelete($form_values['oainjection_jsname']);
		
		//just in case clear the new file
		oainjection_cssDelete(oainjection_cssKey($form_values['id'], 'module', 'all', $o['injectcsspreprocess']));
		oainjection_jsDelete(oainjection_jsKey($form_values['id'], 'module', $o['injectjsheader'], $o['injectjsdefer'], $o['injectjscache']));
	}
}

//-------------------------------------------------------------------
// VIEW: Google Web Toolkit Widget
//-------------------------------------------------------------------

function oaliquid_gwt_plugin_options(&$o)
{
	$o['gwtwidget'] = '0';
}

function oaliquid_gwt_plugin_form($o, &$form)
{
	if(module_exists('gwt'))
    {
    	$bool = true;
    	$block = _getBlockView($form, $bool);
    	
		$form[$block]['block_gwt'] = array(
	      '#type' => 'fieldset',
	      '#title' => t('GWT widget'),
	      '#collapsible' => TRUE,
	      '#collapsed' => $bool,
	      '#tree' => FALSE,
	    );

	    //'#options' => array('body'=>'body', 'teaser'=>'teaser'),
	    
	    $widgets = _gwt_get_widgets();
	    $widgets['0'] = 'none';
	    
	    $form[$block]['block_gwt']['gwtwidget'] = array(
	      '#type' => 'select',
	      '#title' => t('GWT Widget'),
	      '#default_value' => $o['gwtwidget'],
	      '#options' => $widgets,
	    );
	    
	    $form[$block]['block_gwt']['gwt_enable'] = array('#type' => 'value', '#value' => 'true');
    }
}

function oaliquid_gwt_plugin_submit($form_id, $form_values, &$o)
{
	if($form_values['gwt_enable'])
	{
		$o['gwtwidget'] = $form_values['gwtwidget'];
	}
}

//-------------------------------------------------------------------
// NODE: Link the node
//-------------------------------------------------------------------

function oaliquid_link_plugin_options(&$o)
{
	$o['link'] = false;
	$o['link_to'] = '';
	$o['link_style'] = '';
	$o['link_istyle'] = '';
}

function oaliquid_link_plugin_form($o, &$form)
{
	$bool = (!$o['link'] && !$o['link_to'] && !$o['link_style']&& !$o['link_istyle'])? true : false;
	$block = _getBlockNode($form, $bool);
	
	$form[$block]['block_link'] = array(
      '#type' => 'fieldset',
      '#title' => t('Link options'),
      '#collapsible' => TRUE,
      '#collapsed' => $bool,
      '#tree' => FALSE,
    ); 
	
	$form[$block]['block_link']['link'] = array(
      '#type' => 'checkbox',
      '#title' => t('Enable link'),
      '#default_value' => $o['link'],
    );
    
    $form[$block]['block_link']['link_to'] = array(
      '#type' => 'textfield',
      '#title' => t('Custom link'),
      '#default_value' => $o['link_to'],
      '#description' => t('Leave this field blank to link to the Node'),
    );
    
    $form[$block]['block_link']['link_style'] = array(
      '#type' => 'textfield',
      '#title' => t('Link style class'),
      '#default_value' => $o['link_style'],
    );
	
	$form[$block]['block_link']['link_istyle'] = array(
      '#type' => 'textarea',
      '#title' => t('Inline link style'),
      '#default_value' => $o['link_istyle'],
    );
    
    $form[$block]['block_link']['link_enable'] = array('#type' => 'value', '#value' => 'true');
}

function oaliquid_link_plugin_submit($form_id, $form_values, &$o)
{
  	if($form_values['link_enable'])
  	{
  		$o['link'] = $form_values['link'];
  		$o['link_to'] = $form_values['link_to'];
  		$o['link_style'] = $form_values['link_style'];
  		$o['link_istyle'] = $form_values['link_istyle'];
  	}
}

//-------------------------------------------------------------------
// FIELD: Fields option (only for Liquid List)
//-------------------------------------------------------------------

function oaliquid_field_plugin_options(&$o)
{
	$o['separate_field'] = false;
}

function oaliquid_field_plugin_form($o, &$form)
{
	$bool = (!$o['separate_field'])? true : false;
	$block = _getBlockField($form, $bool);
	
	$form[$block]['block_field'] = array(
      '#type' => 'fieldset',
      '#title' => t('Field options'),
      '#collapsible' => TRUE,
      '#collapsed' => $bool,
      '#tree' => FALSE,
    ); 
	
	$form[$block]['block_field']['separate_field'] = array(
      '#type' => 'checkbox',
      '#title' => t('Separate field'),
      '#default_value' => $o['separate_field'],
    );
    
    $form[$block]['block_field']['field_enable'] = array('#type' => 'value', '#value' => 'true');
}

function oaliquid_field_plugin_submit($form_id, $form_values, &$o)
{
  	if($form_values['field_enable'])
  	{
  		$o['separate_field'] = $form_values['separate_field'];
  	}
}

//-------------------------------------------------------------------
// VIEW: view template
//-------------------------------------------------------------------

function oaliquid_viewtemplate_plugin_options(&$o)
{
  	$o['viewtemplate'] = '<?php $output = \'\'; foreach ($items as $item) { print \'<div>\'.$item.\'</div>\'; } ?>';
}

function oaliquid_viewtemplate_plugin_form($o, &$form) 
{
	$bool = empty($o['viewtemplate']);
	$block = _getBlockView($form, $bool);
	
	$form[$block]['block_viewtemplate'] = array(
      '#type' => 'fieldset',
      '#title' => t('Custom view template'),
      '#collapsible' => TRUE,
      '#collapsed' => $bool,
      '#tree' => FALSE,
    ); 
	
	$form[$block]['block_viewtemplate']['viewtemplate'] = array(
      '#type' => 'textarea',
      '#title' => t('View Template'),
      '#default_value' => $o['viewtemplate'],
      '#description' => t('Controle the view display php code must be enclosed inside <?php ?> use print/echo/print_r to output form the php block this template support plain html'),
    );
    
    $form[$block]['block_viewtemplate']['viewtemplate_enable'] = array('#type' => 'value', '#value' => 'true');
}

function oaliquid_viewtemplate_plugin_submit($form_id, $form_values, &$o)
{
  	if($form_values['viewtemplate_enable'])
  	{
  		$o['viewtemplate'] = $form_values['viewtemplate'];
  	}
}

//-------------------------------------------------------------------
// NODE: Node template (only for Liquid)
//-------------------------------------------------------------------

function oaliquid_template_plugin_options(&$o)
{
	if(module_exists('contemplate'))
    {
  		$o['template'] = '';
  		$o['discard_node_template'] = false;
    }
}

function oaliquid_template_plugin_form($o, &$form)
{
	if(module_exists('contemplate'))
    {
    	$bool = empty($o['template']) && !$o['discard_node_template'];
    	$block = _getBlockNode($form, $bool);
    	
    	$form[$block]['block_template'] = array(
	      '#type' => 'fieldset',
	      '#title' => t('Custom template'),
	      '#collapsible' => TRUE,
	      '#collapsed' => $bool,
	      '#tree' => FALSE,
	    ); 
    	
    	$form[$block]['block_template']['template'] = array(
	      '#type' => 'textarea',
	      '#title' => t('Node Template'),
	      '#default_value' => $o['template'],
	      '#description' => t('Controle the node display this is only applicable for the Liquid layout'),
	    );
	    
	    $form[$block]['block_template']['discard_node_template'] = array(
	      '#type' => 'checkbox',
	      '#title' => t('Discard node template'),
	      '#default_value' => $o['discard_node_template'],
	    );
	    
	    $form[$block]['block_template']['template_enable'] = array('#type' => 'value', '#value' => 'true');
    }
}

function oaliquid_template_plugin_submit($form_id, $form_values, &$o)
{
  	if($form_values['template_enable'])
  	{
  		$o['template'] = $form_values['template'];
  		$o['discard_node_template'] = $form_values['discard_node_template'];
  	}
}

//-------------------------------------------------------------------
// General form submit
//-------------------------------------------------------------------

function oaliquid_view_options(&$o, $displayviewform = false)
{
	oaliquid_information_plugin_options($o);
	oaliquid_injection_plugin_options($o);

	if($displayviewform)
	oaliquid_viewtemplate_plugin_options($o);
	oaliquid_gwt_plugin_options($o);
}

function oaliquid_node_options(&$o)
{
	oaliquid_general_plugin_options($o);
	oaliquid_link_plugin_options($o);
	oaliquid_template_plugin_options($o);
}

function oaliquid_field_options(&$o)
{
	oaliquid_field_plugin_options($o);
	//TODO field_template???
}

function oaliquid_view_form($o, &$form, $displayviewform = false)
{
	oaliquid_information_plugin_form($o, $form);
	oaliquid_injection_plugin_form($o, $form);

	if($displayviewform)
	oaliquid_viewtemplate_plugin_form($o, $form);
	oaliquid_gwt_plugin_form($o, $form);
}

function oaliquid_node_form($o, &$form)
{
	oaliquid_general_plugin_form($o, $form);
	oaliquid_link_plugin_form($o, $form);
    oaliquid_template_plugin_form($o, $form);
}

function oaliquid_field_form($o, &$form)
{
	oaliquid_field_plugin_form($o, $form);
	//TODO field_template???
}

function oaliquid_plugin_submit_helper($form_id, $form_values, &$o)
{
	//VIEW
	oaliquid_information_plugin_submit($form_id, $form_values, $o);
	oaliquid_injection_plugin_submit($form_id, $form_values, $o);
	oaliquid_viewtemplate_plugin_submit($form_id, $form_values, $o);
	oaliquid_gwt_plugin_submit($form_id, $form_values, $o);

	//NODE
	oaliquid_general_plugin_submit($form_id, $form_values, $o);
	oaliquid_link_plugin_submit($form_id, $form_values, $o);
	oaliquid_template_plugin_submit($form_id, $form_values, $o);
	
	//FIELD
	oaliquid_field_plugin_submit($form_id, $form_values, $o);
	//TODO field_template???
}

//-------------------------------------------------------------------
// other helper function...
//-------------------------------------------------------------------

/**
 * get the view content as a list of node
 */
function oaliquid_plugin_view($view, $nodes, $type, $o) 
{
  $items = array();

  foreach ($nodes as $count => $n) 
  {
	$items[] = oaliquid_plugin_node_view(node_load($n->nid), $o);
  }
  
  return $items;
}

/**
 * get the view content as a list of field
 */
function oaliquid_plugin_view_list($view, $nodes, $type, $o) 
{
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
	      	$item = '';
	      	$r =  views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
	      	
	      	if($r)
	      	{
		      	if ($field['label'])
	        	$item .= "<div class='view-label ". views_css_safe('view-label-'. $field['queryname']) ."'>" . $field['label'] . "</div>";
	
	        	$item .= "<div class='view-field ". views_css_safe('view-data-'. $field['queryname']) ."'>" . $r . "</div>";
	      	}
	      
	      	$items[] = $item;
	      }
	    }
	}
  }
  else
  {
	foreach ($nodes as $node) 
	{
		$item = '';
		
    	foreach ($view->field as $field) 
	    {
	      if ($fields[$field['id']]['visible'] !== FALSE) 
	      {
	      	$r = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
	      	
	      	if($r)
	      	{
	      		if ($field['label']) 
        		$item .= "<div class='view-label ". views_css_safe('view-label-'. $field['queryname']) ."'>" . $field['label'] . "</div>";

        		$item .= "<div class='view-field ". views_css_safe('view-data-'. $field['queryname']) ."'>" . $r . "</div>";
	      	}
	      }
	    }
	    
	    $items[] = $item;
	}
  }

  return $items;
}

/**
* control the display of an individual node
*/
function oaliquid_plugin_node_view_view($view, $items, $o)
{
	if($o['viewtemplate'])
	{
		ob_start(); 
		print eval('?>'. $o['viewtemplate']); 
		$output = ob_get_contents(); 
		ob_end_clean(); 
		return $output; 
	}
}

/**
* control the display of an individual node
*/
function oaliquid_plugin_node_view($node, $o)
{
  if(!$o['template'] || !module_exists('contemplate'))
  {
  	return view_oaliquid_plugin_node_decorate(node_view($node, $o['teaser'], $o['page'], $o['links']), $node, $o);
  }

  $node = (object)$node;

  $node = node_build_content($node, $o['teaser'], $o['page']);

  if ($o['links']) {
    $node->links = module_invoke_all('link', 'node', $node, !$o['page']);

    foreach (module_implements('link_alter') AS $module) {
      $function = $module .'_link_alter';
      $function($node, $node->links);
    }
  }

  // Set the proper node part, then unset unused $node part so that a bad
  // theme can not open a security hole.
  $content = drupal_render($node->content);
  
  if ($o['teaser']) 
  {
    $node->teaser = $content;
    unset($node->body);
  }
  else 
  {
    $node->body = $content;
    unset($node->teaser);
  }

  // Allow modules to modify the fully-built node.
  node_invoke_nodeapi($node, 'alter', $o['teaser'], $o['page']);

  if($o['teaser'])
  {
  	$node->teaser = view_oaliquid_plugin_node_decorate(contemplate_eval($o['template'], $node), $node, $o);
  }
  else
  {
  	$node->body = view_oaliquid_plugin_node_decorate(contemplate_eval($o['template'], $node), $node, $o);
  }
  
  if($o['discard_node_template'])
  {
  	//inject custom template
  	if($o['teaser'])
  	return $node->teaser;
  	
  	return $node->body;
  	//end oainjection
  }

  return theme('node', $node, $o['teaser'], $o['page']);
}

/**
* Liquid only decorate a node with a link
*/
function view_oaliquid_plugin_view_decorate($content, $view, $o)
{
  if($o['injectcss'])
  {
  	oainjection_css($o['id'], $o['injectcss'], 'module', 'all', $o['injectcsspreprocess']);
  }
	
  if($o['injectjs'])
  {
	oainjection_js($o['id'], $o['injectjs'], 'module', $o['injectjsheader'], $o['injectjsdefer'], $o['injectjscache']);
  }
  
  return $content;
}

/**
* Liquid only decorate a node with a link
*/
function view_oaliquid_plugin_node_decorate($content, $node, $o)
{
  if($o['link'])
  {
  	if(!$o['page'] && (!$o['template'] || !module_exists('contemplate')))
  	return $content;
  	
  	$a = array();
  	
  	if($o['link_style'])
  	$a['class'] = $o['link_style'];
  	
  	if($o['link_istyle'])
  	$a['style'] = $o['link_istyle'];
  	
  	$link = ($o['link_to'])? $o['link_to'] : 'node/'.$node->nid;

  	if(!(strpos($content, '<div')===0))
  	$content = '<div>'.$content.'</div>';

	return l($content, $link, $a, NULL, NULL, FALSE, true);
  }
  
  return $content;
}

//------------------------------------------------------------------------------------------------------

function _getBlockNode(&$form, $bool) 
{
	if(isset($form['blocknode']))
	{
		if(!$bool)
		$form['blocknode']['#collapsed'] = FALSE;
	}
	else
	{
		$form['blocknode'] = array(
	      '#type' => 'fieldset',
	      '#title' => t('Node options'),
	      '#description' => t('Options only apply if the "Liquid Node List" layout is selected in the View'),
	      '#collapsible' => TRUE,
	      '#collapsed' => $bool,
	      '#tree' => FALSE,
	    );
	}
	
	return 'blocknode';
}

function _getBlockField(&$form, $bool) 
{
	if(isset($form['blockfield']))
	{
		if(!$bool)
		$form['blockfield']['#collapsed'] = FALSE;
	}
	else
	{
		$form['blockfield'] = array(
	      '#type' => 'fieldset',
	      '#title' => t('Field options'),
	      '#description' => t('Options only apply if the "Liquid Field List" layout is selected in the View'),
	      '#collapsible' => TRUE,
	      '#collapsed' => $bool,
	      '#tree' => FALSE,
	    );
	}
	
	return 'blockfield';
}

function _getBlockView(&$form, $bool) 
{
	if(isset($form['blockview']))
	{
		if(!$bool)
		$form['blockview']['#collapsed'] = FALSE;
	}
	else
	{
		$form['blockview'] = array(
	      '#type' => 'fieldset',
	      '#title' => t('View options'),
	      '#description' => t('General View options'),
	      '#collapsible' => TRUE,
	      '#collapsed' => $bool,
	      '#tree' => FALSE,
	    );
	}
	
	return 'blockview';
}