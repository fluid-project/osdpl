<?php
// $Id: content_access_test_help.php,v 1.1.2.1 2008/10/28 12:54:01 fago Exp $

/**
 * @file
 * Helper class with auxiliary functions for content access module tests
 */

class ContentAccessTestCase extends DrupalTestCase {

  var $test_user;
  var $admin_user;
  var $content_type_name;
  var $url_content_type_name;
  var $node1;
  var $node2;
  
  /**
   * Preparation work that is done before each test.
   * Test users, content types, nodes etc. are created.
   */
  function setUp() {
    parent::setUp();
    // Create test user with seperate role
    $this->test_user = $this->drupalCreateUserRolePerm();
    
    // Create admin user
    $this->admin_user = $this->drupalCreateUserRolePerm(array('administer content types', 'grant content access', 'grant own content access', 'administer nodes'));
    $this->drupalLoginUser($this->admin_user);
    
    // Create test content type
    $this->content_type_name = strtolower($this->randomName(5));
    $edit = array(
      'name' => $this->content_type_name,
      'type' => $this->content_type_name,
    );
    $this->drupalPostRequest('admin/content/types/add', $edit, 'op');
    $this->assertWantedRaw(t('The content type %type has been added.', array ('%type' => $this->content_type_name)), 'Test content type was added successfully');
    $this->url_content_type_name = str_replace('_', '-', $this->content_type_name);
  }
  
  /**
   * Clear up work that is done after each test.
   * Users get deleted automatically, so we just have to delete the content type.
   * (nodes get deleted automatically, too)
   */
  function tearDown() {
    // Login admin and delete test content type
    $this->drupalGet(url('logout'));
    $this->drupalLoginUser($this->admin_user);
    $this->drupalPostRequest('admin/content/types/'. $this->url_content_type_name .'/delete', array(), 'op');
    parent::tearDown();
  }
  
  /**
   * Creates a node for testing purposes
   * @return the node object
   */
  function createNode() {
    $title = $this->randomName(10);
    $edit = array(
      'title' => $title,
      'body' => $this->randomName(20),
    );
    $this->drupalPostRequest('node/add/'. $this->url_content_type_name, $edit, 'Submit');
    $this->assertWantedRaw(t('Your %content has been created.', array ('%content' => $this->content_type_name)), 'Test node was added successfully');
    return node_load(array('title' => $title, 'type' => $this->content_type_name));
  }
  
  /**
   * Change access permissions for a content type
   */
  function changeAccessContentType($access_settings) {
    $this->drupalPostRequest('admin/content/types/'. $this->url_content_type_name .'/access', $access_settings, 'Submit');
    $this->assertText(t('Your changes have been saved.'), 'access rules of content type were updated successfully');
  }
  
  /**
   * Change access permissions for a content type by a given keyword (view, update or delete)
   * for the role of the user
   */
  function changeAccessContentTypeKeyword($keyword, $access = TRUE) {
    $user = $this->test_user;
    $roles = $user->roles;
    end($roles);
    $access_settings = array(
      $keyword .'['. key($roles) .']' => $access,
    );
    $this->changeAccessContentType($access_settings);
  }
  
  /**
   * Change access permission for a node
   */
  function changeAccessNode($node, $access_settings) {
    $this->drupalPostRequest('node/'. $node->nid .'/access', $access_settings, 'Submit');
    $this->assertText(t('Your changes have been saved.'), 'access rules of node were updated successfully');
  }
  
  /**
   * Change access permissions for a node by a given keyword (view, update or delete)
   */
  function changeAccessNodeKeyword($node, $keyword, $access = TRUE) {
    $user = $this->test_user;
    $roles = $user->roles;
    end($roles);
    $access_settings = array(
      $keyword .'['. key($roles) .']' => $access,
    );
    $this->changeAccessNode($node, $access_settings);
  }
  
  /**
   * Change the per node access setting for a content type
   */
  function changeAccessPerNode($access = TRUE) {
    $access_permissions = array(
      'per_node' => $access,
    );
    $this->changeAccessContentType($access_permissions);
  }
  
  /**
   * Replacement for drupalPostRequest() if we don't want to reload a path
   */
  function postToCurrentPage($edit = array(), $submit) {
    foreach ($edit as $field_name => $field_value) {
      $ret = $this->_browser->setFieldByName($field_name, $field_value)
          || $this->_browser->setFieldById("edit-$field_name", $field_value);
      $this->assertTrue($ret, " [browser] Setting $field_name=\"$field_value\"");
    }
    
    $ret = $this->_browser->clickSubmit(t($submit))  || $this->_browser->clickSubmitById($submit) || $this->_browser->clickSubmitByName($submit) || $this->_browser->clickImageByName($submit);
    $this->assertTrue($ret, ' [browser] POST by click on ' . t($submit));
    $this->_content = $this->_browser->getContent();
  }
  
  /**
   * Stores the current page in the files directory, so it can be viewed by the developer.
   * Useful for debugging code.
   */
  function debugCurrentPage() {
    static $count = 0;
     
    $count++;
    $path = 'tests';
    if (!file_check_directory($path, FILE_CREATE_DIRECTORY)) {
      return FALSE; //unable to create directory
    }
    $filepath = file_create_filename("page-$count.htm", $path);
    file_put_contents($filepath, $this->drupalGetContent());
    echo '<a href="'. $filepath .'">created debug file '. $count .'</a><br/>';
    //echo l("created debug file $count", $filepath);
  }
}
