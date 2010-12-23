<?php

	class User extends KK_Controller {
		
		
		
		/**
		 *	用户资料页, 当前用户充值,修改资料界面
		 */
		function index() {
			
			$data = array();
			kk_show_view('user/index_view', $data);
		}
		
		
		
		/**
		 *	用户查看页, 用于查看别的用户的资料
		 */
		function lookup( $user_id ) {
			
			
			kk_show_view('user/lookup_view', $data );
		}
		
	}
