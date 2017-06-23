<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * DX Auth Class
 *
 * Authentication library for Code Igniter.
 *
 * @author		Dexcell
 * @version		1.0.0
 * @based on	CL Auth by Jason Ashdown (http://http://www.jasonashdown.co.uk/)
 * @link			http://dexcell.shinsengumiteam.com/dx_auth
 * @license		MIT License Copyright (c) 2008 Erick Hartanto
 * @credits		lizd11
 */
class DX_Auth_system {

    // Private
    var $_banned;
    var $_ban_reason;
    var $_auth_error; // Contain user error when login
    var $_captcha_image;

    function DX_Auth_system() {
        $this->ci = & get_instance();

        log_message('debug', 'DX Auth Initialized');

        // Load required library
        $this->ci->load->library('Session');
        $this->ci->load->database();

        // Load DX Auth config
        $this->ci->load->config('dx_auth');

        // Load DX Auth language		
        $this->ci->lang->load('dx_auth');

        // Load DX Auth event
        $this->ci->load->library('DX_Auth_Event');

        // Initialize
        $this->_init();
    }

    /* Private function */

    function _init() {
        // When we load this library, auto Login any returning users
       
    }

   

    /*
     * Function: _encode
     * Modified for DX_Auth
     * Original Author: FreakAuth_light 1.1
     */
 
 function _array_in_array($needle, $haystack) {
        // Make sure $needle is an array for foreach
        if (!is_array($needle)) {
            $needle = array($needle);
        }

        // For each value in $needle, return TRUE if in $haystack
        foreach ($needle as $pin) {
            if (in_array($pin, $haystack))
                return TRUE;
        }
        // Return FALSE if none of the values from $needle are found in $haystack
        return FALSE;
    }

    // Get role data from database by id, used in _set_session() function
    // $parent_roles_id, $parent_roles_name is an array.
    function _get_role_data($role_id) {
        // Load models
        $this->ci->load->model('dx_auth/roles', 'roles');
        $this->ci->load->model('dx_auth/permissions', 'permissions');

        // Clear return value
        $role_name = '';
        $parent_roles_id = array();
        $parent_roles_name = array();
        $permission = array();
        $parent_permissions = array();

        /* Get role_name, parent_roles_id and parent_roles_name */
       
        // Get role query from role id
        $query = $this->ci->roles->get_role_by_id($role_id);

        // Check if role exist
        if ($query->num_rows() > 0) {
            // Get row
            $role = $query->row();

            // Get role name
            $role_name = $role->name;

            /*
              Code below will search if user role_id have parent_id > 0 (which mean role_id have parent role_id)
              and do it recursively until parent_id reach 0 (no parent) or parent_id not found.

              If anyone have better approach than this code, please let me know.
             */

            // Check if role has parent id
            if ($role->parent_id > 0) {
                // Add to result array
                $parent_roles_id[] = $role->parent_id;

                // Set variable used in looping
                $finished = FALSE;
                $parent_id = $role->parent_id;

                // Get all parent id
                while ($finished == FALSE) {
                    $i_query = $this->ci->roles->get_role_by_id($parent_id);

                    // If role exist
                    if ($i_query->num_rows() > 0) {
                        // Get row
                        $i_role = $i_query->row();

                        // Check if role doesn't have parent
                        if ($i_role->parent_id == 0) {
                            // Get latest parent name
                            $parent_roles_name[] = $i_role->name;
                            // Stop looping
                            $finished = TRUE;
                        } else {
                            // Change parent id for next looping
                            $parent_id = $i_role->parent_id;

                            // Add to result array
                            $parent_roles_id[] = $parent_id;
                            $parent_roles_name[] = $i_role->name;
                        }
                    } else {
                        // Remove latest parent_roles_id since parent_id not found
                        array_pop($parent_roles_id);
                        // Stop looping
                        $finished = TRUE;
                    }
                }
            }
        }

        /* End of Get role_name, parent_roles_id and parent_roles_name */

        /* Get user and parents permission */

        // Get user role permission
        $permission = $this->ci->permissions->get_permission_data($role_id);

        // Get user role parent permissions
        if (!empty($parent_roles_id)) {
            $parent_permissions = $this->ci->permissions->get_permissions_data($parent_roles_id);
        }

        /* End of Get user and parents permission */

        // Set return value
        $data['role_name'] = $role_name;
        $data['parent_roles_id'] = $parent_roles_id;
        $data['parent_roles_name'] = $parent_roles_name;
        $data['permission'] = $permission;
        $data['parent_permissions'] = $parent_permissions;
      //  print_r($data);
        return $data;
    }
  
 /// lizd11 chick controller for system 
    function check_controller_permissions($controller,$role_id,$allow = TRUE) {
        // First check if user already logged in or not
       
            // If user is not admin
            if ( $controller) {
                // Get variable from current URI
                $controller = '/' . $controller . '/';
                $action = $controller . 'index/';
                // Get URI permissions from role and all parents
                // Note: URI permissions is saved in 'uri' key
                $roles_allowed_uris = $this->get_permissions_value('uri',$role_id);

                // Variable to determine if URI found
                $have_access = !$allow;

                // Loop each roles URI permissions
                foreach ($roles_allowed_uris as $allowed_uris) {
                    if ($allowed_uris != NULL) {
                        // Check if user allowed to access URI
                        if ($this->_array_in_array(array('/', $controller, $action), $allowed_uris)) {
                            $have_access = $allow;
                            return TRUE;
                            // Stop loop
                            break;
                        }
                    }
                }

                // Trigger event
             //   $this->ci->dx_auth_event->checked_uri_permissions($this->get_user_id(), $have_access);
               
                if (!$have_access) {
                    // User didn't have previlege to access current URI, so we show user 403 forbidden access
                     return FALSE;
                }
            } else {
                return FALSE;
            }
        
    }

    /* End of Auto login related function */

    /* Helper function */

    function check_uri_permissions($allow = TRUE) {
        // First check if user already logged in or not
        if ($this->is_logged_in()) {
            // If user is not admin
            if (!$this->is_admin()) {
                // Get variable from current URI
                $controller = '/' . $this->ci->uri->rsegment(1) . '/';
                if ($this->ci->uri->rsegment(2) != '') {
                    $action = $controller . $this->ci->uri->rsegment(2) . '/';
                } else {
                    $action = $controller . 'index/';
                }

                // Get URI permissions from role and all parents
                // Note: URI permissions is saved in 'uri' key
                $roles_allowed_uris = $this->get_permissions_value('uri');

                // Variable to determine if URI found
                $have_access = !$allow;

                // Loop each roles URI permissions
                foreach ($roles_allowed_uris as $allowed_uris) {
                    if ($allowed_uris != NULL) {
                        // Check if user allowed to access URI
                        if ($this->_array_in_array(array('/', $controller, $action), $allowed_uris)) {
                            $have_access = $allow;
                          //  echo $have_access;
                          //  echo '///';
                            // Stop loop
                            break;
                        }
                    }
                }

                // Trigger event
                $this->ci->dx_auth_event->checked_uri_permissions($this->get_user_id(), $have_access);
             //   echo $have_access;
                if (!$have_access) {
                    // User didn't have previlege to access current URI, so we show user 403 forbidden access
                    $this->deny_access();
                }
            }
        } else {
            // User haven't logged in, so just redirect user to login page
            //echo '////';
            $this->deny_access('login');
        }
    }

    /*
      Get permission value from specified key.
      Call this function only when user is logged in already.
      $key is permission array key (Note: permissions is saved as array in table).
      If $check_parent is TRUE means if permission value not found in user role, it will try to get permission value from parent role.
      Returning value if permission found, otherwise returning NULL
     */

    function get_permission_value($key,$role_id, $check_parent = TRUE) {
        // Default return value
        $result = NULL;

        // Get current user permission
        $rolerow = $this->_get_role_data($role_id);
        //echo $role_id;
      //  print_r($rolerow);
        $permission = $rolerow['permission'];//$this->ci->session->userdata('DX_permission');
       // print_r($permission);
        // Check if key is in user permission array
        if (array_key_exists($key, $permission)) {
            $result = $permission[$key];
        }
        // Key not found
        else {
            if ($check_parent) {
                // Get current user parent permissions
                $parent_permissions = $rolerow['parent_permissions']; // $this->ci->session->userdata('DX_parent_permissions');

                // Check parent permissions array				
                foreach ($parent_permissions as $permission) {
                    if (array_key_exists($key, $permission)) {
                        $result = $permission[$key];
                        break;
                    }
                }
            }
        }

        // Trigger event
       // $this->ci->dx_auth_event->got_permission_value_system($this->get_user_id(), $key);

        return $result;
    }

    /*
      Get permissions value from specified key.
      Call this function only when user is logged in already.
      This will get user permission, and it's parents permissions.

      $array_key = 'default'. Array ordered using 0, 1, 2 as array key.
      $array_key = 'role_id'. Array ordered using role_id as array key.
      $array_key = 'role_name'. Array ordered using role_name as array key.

      Returning array of value if permission found, otherwise returning NULL.
     */
 
    // lizd11 
   function get_permissions_value($key,$role_id, $array_key = 'default') {
        $result = array();
        $rolerow = $this->_get_role_data($role_id);
         
        $role_id = $role_id;
        $role_name = $rolerow['role_name'];

        $parent_roles_id = $rolerow['parent_roles_id'];
        $parent_roles_name =$rolerow['parent_roles_name'];
        /*$role_id = $this->ci->session->userdata('DX_role_id');
        $role_name = $this->ci->session->userdata('DX_role_name');

        $parent_roles_id = $this->ci->session->userdata('DX_parent_roles_id');
        $parent_roles_name = $this->ci->session->userdata('DX_parent_roles_name');
*/
        // Get current user permission
        $value = $this->get_permission_value($key, FALSE);

        if ($array_key == 'role_id') {
            $result[$role_id] = $value;
        } elseif ($array_key == 'role_name') {
            $result[$role_name] = $value;
        } else {
            array_push($result, $value);
        }

        // Get current user parent permissions
        $parent_permissions =  $rolerow['parent_permissions'];

        $i = 0;
        foreach ($parent_permissions as $permission) {
            if (array_key_exists($key, $permission)) {
                $value = $permission[$key];
            }

            if ($array_key == 'role_id') {
                // It's safe to use $parents_roles_id[$i] because array order is same with permission array
                $result[$parent_roles_id[$i]] = $value;
            } elseif ($array_key == 'role_name') {
                // It's safe to use $parents_roles_name[$i] because array order is same with permission array
                $result[$parent_roles_name[$i]] = $value;
            } else {
                array_push($result, $value);
            }

            $i++;
        }

        // Trigger event
       // $this->ci->dx_auth_event->got_permissions_value($this->get_user_id(), $key);

        return $result;
    }
    
   // Get rose_data lizd11
    function get_role_data($role_id) { 
        return $this->_get_role_data($role_id);
    }
   
    
 

    /* End of Recaptcha function */
}

?>