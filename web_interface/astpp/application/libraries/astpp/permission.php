<?php
// ##############################################################################
// ASTPP - Open Source VoIP Billing Solution
//
// Copyright (C) 2016 iNextrix Technologies Pvt. Ltd.
// Samir Doshi <samir.doshi@inextrix.com>
// ASTPP Version 3.0 and above
// License https://www.gnu.org/licenses/agpl-3.0.html
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program. If not, see <http://www.gnu.org/licenses/>.
// ##############################################################################
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Permission {
	function __construct($library_name = '') {
		$this->CI = & get_instance ();
		$this->CI->load->model ( "db_model" );
		$this->CI->load->library ( 'session' );
	}
	function get_module_access($user_type) {
		$where = array (
				"userlevelid" => $user_type 
		);
		$modules_arr = $this->CI->db_model->getSelect ( "module_permissions", "userlevels", $where );
		if ($modules_arr->num_rows () > 0) {
			$modules_arr = $modules_arr->result_array ();
			$modules_arr = $modules_arr [0] ['module_permissions'];
			
			$menu_arr = $this->CI->db_model->select ( "*", "menu_modules", "id IN ($modules_arr)", "priority", "asc", "", "", "" );
			$menu_list = array ();
			$permited_modules = array ();
			$modules_seq_arr = array ();
			$modules_seq_arr = explode ( ",", $modules_arr );
			$label_arr = array ();
			foreach ( $menu_arr->result_array () as $menu_key => $menu_value ) {
				if (! isset ( $label_arr [$menu_value ['menu_label']] ) && $menu_value ['menu_label'] != 'Configuration') {
					$label_arr [$menu_value ['menu_label']] = $menu_value ['menu_label'];
					$menu_value ["menu_image"] = ($menu_value ["menu_image"] == "") ? "Home.png" : $menu_value ["menu_image"];
					$menu_list [$menu_value ["menu_title"]] [$menu_value ["menu_subtitle"]] [] = array (
							"menu_label" => trim ( $menu_value ["menu_label"] ),
							"module_url" => trim ( $menu_value ["module_url"] ),
							"module" => trim ( $menu_value ["module_name"] ),
							"menu_image" => trim ( $menu_value ["menu_image"] ) 
					);
				}
				$permited_modules [] = trim ( $menu_value ["module_name"] );
			}
			$this->CI->session->set_userdata ( 'permited_modules', serialize ( $permited_modules ) );
			$this->CI->session->set_userdata ( 'menuinfo', serialize ( $menu_list ) );
			return true;
		}
	}
}
?> 
