<?php

//if (in_array('administrator', array_values($user->roles))) {

$form['group_information']['#title'] = '1. '.$form['group_information']['#title'];
$form['group_problem']['#title']= '2. '.$form['group_problem']['#title'];
$form['group_examples']['#title']= '4. '.$form['group_examples']['#title'];
$form['group_solution']['#title']= '3. '.$form['group_solution']['#title'];
$form['group_accessibility']['#title']='5. '.$form['group_accessibility']['#title'];
$form['group_relationships']['#title']='6. '.$form['group_relationships']['#title'];

$form['group_information']['title']=$form['title'];
$form['title']=array();

// remove unwanted items from the form.
$form['options']['promote'] = array();
$form['options']['sticky'] = array();
$form['options']['revision'] = array();
$form['menu'] = array();
$form['author'] = array();
$form['comment_settings'] = array();
$form['attachments']= array();
$form['path']=array();
$form['log']=array();
$form['body_filter']=array();

// Change certain elements not to collapsible.
$form['group_examples']['field_fluid_implementations']['#collapsible']='';
$form['group_solution']['field_solution_image']['#collapsible']='';
$form['group_relationships']['field_this_pattern_in_other_col']['#collapsible']='';
$form['group_relationships']['field_related_fluid_component_l']['#collapsible']='';
$form['options']['#collapsible']='';

// More element modifications.
$form['options']['#type']=''; // remove fieldset so no border appears for Publish.
$form['group_solution']['field_solution_image']['#title'].=' <font class="form-required">*</font>';

// duplicate elements to the Finish group.
$form['group_finish']['options']=$form['options'];
$form['group_finish']['status']=$form['field_pattern_status'];
$form['group_finish']['delete']=$form['delete'];
$form['group_finish']['submit']=$form['submit'];
$form['group_finish']['preview']=$form['preview'];

// remove elements that we have duplicated.
$form['field_pattern_status']=array();
$form['options']=array();
$form['submit']=array();
$form['preview']=array();
$form['delete']=array();

// modify some text.
$form['group_finish']['options']['status']['#title']='Viewable by Everyone';
$form['group_finish']['options']['status']['#description']='Allows everyone to view, comment, and interact with this pattern regardless of the Pattern Status.';

// lay out the elements inside the Finish group.
$form['group_finish']['status']['#weight']='-2';
$form['group_finish']['options']['#weight']='-1';
$form['group_finish']['delete']['#weight']='0';
$form['group_finish']['preview']['#weight']='1';
$form['group_finish']['submit']['#weight']='2';

$form['group_finish']['#weight']='7';
$form['group_finish']['#type']='fieldset';
$form['group_finish']['#title']='7. Publishing Actions';
$form['group_finish']['#description']='Submitting this pattern will make it viewable by everyone. Only registered users will be able to give feedback on your pattern.';

// TODO
// Next and prev tab links.


print drupal_render($form);
//}
//else {
//print drupal_render($form);
//}

if (in_array('administrator', array_values($user->roles))) {
/*    print '<fieldset class="collapsible"><legend>Form Code (Administrator)</legend><div><pre>';
    print '== FORM START ==';
    print_r(array_values($form));
    print '== FORM END ==';
    print '</pre></div></fieldset>';*/
}
?>

