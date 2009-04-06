<?php


$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['#title'] = '1. '.$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['#title'];
$form['fieldgroup_tabs']['group_problem']['#title']= '2. '.$form['fieldgroup_tabs']['group_problem']['#title'];
$form['fieldgroup_tabs']['group_examples']['#title']= '4. '.$form['fieldgroup_tabs']['group_examples']['#title'];
$form['fieldgroup_tabs']['group_solution']['#title']= '3. '.$form['fieldgroup_tabs']['group_solution']['#title'];
$form['fieldgroup_tabs']['group_accessibility']['#title']='5. '.$form['fieldgroup_tabs']['group_accessibility']['#title'];
$form['fieldgroup_tabs']['group_relationships']['#title']='6. '.$form['fieldgroup_tabs']['group_relationships']['#title'];


// Add "Required" text to sections.
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['title']['#title'].= ' (required)';
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['field_category']['tids']['#title'] .= ' (required)';
$form['fieldgroup_tabs']['group_problem']['field_design_problem']['0']['value']['#title'] .= ' (required for Publishing)';
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['group_solution_description']['field_solution']['0']['value']['#title'] .= ' (required for Publishing)';
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['group_how']['field_how']['0']['value']['#title'] .= ' (required for Publishing)';
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['group_rationale']['field_why']['0']['value']['#title'] .= ' (required for Publishing)';
$form['fieldgroup_tabs']['group_solution']['field_solution_image']['#title'].= ' (required for Publishing)';


// remove unwanted items from the form.
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['options']['promote'] = array();
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['options']['sticky'] = array();
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['options']['revision'] = array();
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['menu'] = array();
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['author'] = array();
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['comment_settings'] = array();
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['attachments']= array();
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['path']=array();
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['log']=array();
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['body_filter']=array();

// Change certain elements not to collapsible.
$form['fieldgroup_tabs']['group_examples']['field_fluid_implementations']['#collapsible']='';
$form['fieldgroup_tabs']['group_solution']['field_solution_image']['#collapsible']='';
$form['fieldgroup_tabs']['group_relationships']['field_this_pattern_in_other_col']['#collapsible']='';
$form['fieldgroup_tabs']['group_relationships']['field_related_fluid_component_l']['#collapsible']='';
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['options']['#collapsible']='';

// Relabel the Upload button for images.
$form['fieldgroup_tabs']['group_solution']['field_solution_image']['new']['upload']['#value'] = 'Upload Image';

// More element modifications.
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['options']['#type']=''; // remove fieldset so no border appears for Publish.
//$form['fieldgroup_tabs']['group_solution']['field_solution_image']['#title'].=' <font class="form-required">*</font>';

// BEGIN Solutions section layout modification. This is done so we
// can have Fieldgroups of Title-Description-Field-Example groupings,
// all grouped under a larger "Solution" container.

// Duplicate the Solution related fieldgroups.
$form['fieldgroup_tabs']['group_solution']['0']=$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['group_solution_description'];
$form['fieldgroup_tabs']['group_solution']['1']=$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['group_use_when'];
$form['fieldgroup_tabs']['group_solution']['2']=$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['group_how'];
$form['fieldgroup_tabs']['group_solution']['3']=$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['group_rationale'];

// ensure that the weights are in the appropriate order.
$form['fieldgroup_tabs']['group_solution']['0']['#weight']='0'; // Sol'n desc.
$form['fieldgroup_tabs']['group_solution']['field_solution_image']['#weight']='1'; // Solution image upload
$form['fieldgroup_tabs']['group_solution']['field_solution_image_attributio']['#weight']='2'; // Solution image attribution

$form['fieldgroup_tabs']['group_solution']['1']['#weight']='3'; // Use when
$form['fieldgroup_tabs']['group_solution']['2']['#weight']='4'; // How
$form['fieldgroup_tabs']['group_solution']['3']['#weight']='5'; // Rationale

// remove the original fieldgroups duplicated.
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['group_solution_description']=array();
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['group_use_when']=array();
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['group_how']=array();
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['group_rationale']=array();
// END Solutions section layout modification.


// duplicate elements to the Submit tab.
//$form['fieldgroup_tabs']['group_submit']['options']=$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['options'];


/*
$form['fieldgroup_tabs']['group_submit']['delete']=$form['delete'];
$form['fieldgroup_tabs']['group_submit']['submit']=$form['submit'];
$form['fieldgroup_tabs']['group_submit']['preview']=$form['preview'];
*/

$form['form_buttons']['group_submit']['delete']=$form['delete'];
$form['form_buttons']['group_submit']['submit']=$form['submit'];
$form['form_buttons']['group_submit']['preview']=$form['preview'];

// remove elements that we have duplicated.

$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['options']=array();

$form['submit']=array();
$form['preview']=array();
$form['delete']=array();



// lay out the elements inside the Finish group.
/*
$form['fieldgroup_tabs']['group_submit']['status']['#weight']='-2';
$form['fieldgroup_tabs']['group_submit']['options']['#weight']='-1';
$form['fieldgroup_tabs']['group_submit']['delete']['#weight']='3';
$form['fieldgroup_tabs']['group_submit']['preview']['#weight']='1';
$form['fieldgroup_tabs']['group_submit']['submit']['#weight']='2';
*/

//$form['fieldgroup_tabs']['group_submit']['#title']='7. '.$form['fieldgroup_tabs']['group_submit']['#title'];



$form['form_buttons']['group_submit']['#weight']='9';
$form['fieldgroup_tabs']['group_examples']['submit']=$form['form_buttons']['group_submit'];
$form['fieldgroup_tabs']['group_solution']['submit']=$form['form_buttons']['group_submit'];
$form['fieldgroup_tabs']['group_problem']['submit']=$form['form_buttons']['group_submit'];
$form['fieldgroup_tabs']['group_accessibility']['submit']=$form['form_buttons']['group_submit'];
$form['fieldgroup_tabs']['group_relationships']['submit']=$form['form_buttons']['group_submit'];
$form['fieldgroup_tabs']['fieldgroup_tabs_basic']['submit']=$form['form_buttons']['group_submit'];


/*
<li><strong>Submit</strong> will save changes made to this entire pattern. </li>
<li><strong>Preview</strong> will show you the pattern, with current changes, as it will appear on the site. You will have the option of continue editing or submitting.</li>
<li><strong>Delete</strong>, if available, will delete this entire pattern from the OSDPL. Use with caution.</li>
*/

$form['form_buttons']['group_submit']=array();

print drupal_render($form);
/*
if (in_array('administrator', array_values($user->roles))) {
    print '<fieldset class="collapsible"><legend>Form Code (Administrator)</legend><div><pre>';
    print '== FORM START ==';
    print_r(array_values($form));
    print '== FORM END ==';
    print '</pre></div></fieldset>';
}
*/
?>

