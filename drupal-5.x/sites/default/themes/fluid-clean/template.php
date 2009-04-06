<?php
// $Id: template.php,v 1.1.2.6 2008/09/12 21:50:37 psynaptic Exp $

/**
 * Intercept template variables
 *
 * @param $hook
 *   The name of the theme function being executed
 * @param $vars
 *   A sequential array of variables passed to the theme function.
 */
function _phptemplate_variables($hook, $vars = array()) {
  global $user;
  $path = base_path() . path_to_theme() .'/';
  $path_theme = path_to_theme() .'/';

  // Global vars
  $vars['path'] = $path;
  $vars['user'] = $user;

  switch ($hook) {

    case 'page':
      drupal_add_css($path_theme .'layout.css', 'theme', 'all');
      drupal_add_css($path_theme .'color.css', 'theme', 'all');
      drupal_add_css($path_theme .'navigation.css', 'theme', 'all');
      drupal_add_css($path_theme .'fancy-dates.css', 'theme', 'all');
      drupal_add_css($path_theme .'custom.css', 'theme', 'all');
      $new_css = drupal_add_css();
      $vars['styles'] = drupal_get_css($new_css);

      if ($vars['sidebar_left'] != '') {
        $vars['left'] = '<div class="left sidebar">'. $vars['sidebar_left'] .'</div>';
      }
      if ($vars['sidebar_right'] != '') {
        $vars['right'] = '<div class="right sidebar">'. $vars['sidebar_right'] .'</div>';
      }
      break;

    case 'node':
      $node = $vars['node'];
      switch ($node->type) {
        case 'blog':
          $vars['blog_date'] = clean_blog_date($node);
          break;
      }
      break;

    case 'comment':
      $comment = $vars['comment'];
      $vars['comment_date'] = clean_comment_date($comment);
      $vars['comment_classes'] = 'comment';
      $vars['comment_classes'] .= ($comment->new) ? ' comment-new' : '';
      $vars['comment_classes'] .= ($comment->status == COMMENT_NOT_PUBLISHED) ? ' comment-unpublished' : '';
      $vars['comment_classes'] .= ' '. $vars['zebra'];
      $vars['comment_classes'] .= ' clear-block';
      break;
  }
  return $vars;
}

/**
 * Override, make sure Drupal doesn't return empty <p>
 *
 * Return a themed help message.
 *
 * @return a string containing the helptext for the current page.
 */
function phptemplate_help() {
  $help = menu_get_active_help();
  // Drupal sometimes returns empty <p></p> so strip tags to check if empty
  if (strlen(strip_tags($help)) > 1) {
    return '<div class="help">'. $help .'</div>';
  }
}

/**
 * Override, use a better default breadcrumb separator.
 *
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function phptemplate_breadcrumb($breadcrumb) {
  if (count($breadcrumb) > 1) {
    $breadcrumb[] = drupal_get_title();
    if ($breadcrumb) {
      return '<div class="breadcrumb">'. implode(' &rsaquo; ', $breadcrumb) ."</div>\n";
    }
  }
}

/**
 * Formats calendar style dates for blog posts.
 *
 * @param $node
 *   The node object from which to extract submitted date information.
 * @return themed date.
 */
function clean_blog_date($node) {
  $day = format_date($node->created, 'custom', "j");
  $month = format_date($node->created, 'custom', "M");
  $year = format_date($node->created, 'custom', "Y");
  $output = '<span class="day">'. $day .'</span>';
  $output .= '<span class="month">'. $month .'</span>';
  $output .= '<span class="year">'. $year .'</span>';
  return $output;
}

/**
 * Formats calendar style dates for comments.
 *
 * @param $comment
 *   The comment object from which to extract submitted date information.
 * @return themed date.
 */
function clean_comment_date($comment) {
  $day = format_date($comment->timestamp, 'custom', 'd M');
  $time = format_date($comment->timestamp, 'custom', 'H:i');
  $output = '<span class="day">'. $day .'</span>';
  $output .= '<span class="time">'. $time .'</span>';
  return $output;
}
/*
function phptemplate_maintenance_page($content, $messages = TRUE, $partial = FALSE) {
drupal_goto('offline.html');
}
*/
if ((arg(0) == 'node') && (arg(1) == 'add') && (arg(2) == 'uidp-serial-form')){
    function phptemplate_node_form($form) {
        return _phptemplate_callback('uidp-serial-form', array('user' => $user, 'form' => $form));
    }
   
    function phptemplate_filter_tips($tips, $long = FALSE, $extra = '') {
        return '';
    }
    
    function phptemplate_filter_tips_more_info () {
        return '';
    }
}


if ((arg(0) == 'node') && (arg(1) == 'add') && (arg(2) == 'uidp')){
    function phptemplate_node_form($form) {
        return _phptemplate_callback('uidp', array('user' => $user, 'form' => $form));
    }

    function phptemplate_filter_tips($tips, $long = FALSE, $extra = '') {
        return '';
    }

    function phptemplate_filter_tips_more_info () {
        return '';
    }
}



// Add Form End.................
// Edit Form Start...........Dublin Drupaller..
if ((arg(0) == 'node') && (arg(2) == 'edit')){
    $node = node_load(array('nid' => arg(1)));
    if ($node->type == 'uidp_serial_form') {
	function phptemplate_node_form($form) {
 	    return _phptemplate_callback('uidp-serial-form', array('user' => $user, 'form' => $form));
        }
    } 
    else if ($node->type == 'uidp') {
	function phptemplate_node_form($form) {
	    return _phptemplate_callback('uidp', array('user' => $user, 'form' => $form));
        }

    }
}

function theme_imagecache_field($namespace, $field, $attrs = NULL) {
  return theme_imagecache($namespace, $field['filepath'], $field['alt'],$field['title'], $attrs);
};
