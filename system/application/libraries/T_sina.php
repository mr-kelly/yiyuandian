<?php

/**
 *	CodeIgniter T_sina 新浪微博库 by Mrkelly
 	
 	version: 0.3 [101225] - 完善了authorize_url()
 	
 	将新浪微博的Oauth验证和http验证绑定在这一个库上.
 	
 	
 	PHP服务器需要curl支持
 	
 	** 记得修改WB_AKEY & WB_SKEY
 
 */

	require_once('t_sina_oauth/weibooauth.php');
	require_once('t_sina_http/weibo.class.php');

	define( 'WB_AKEY', '885182410');
	define( 'WB_SKEY', '3a8cdf2ba319dd2813c1fbd3ea6323ec');
	
	
	
	/**
	 *	1. getAuthorizeURL
	 *  2. getAccessToken
	 *  3. 写入accesstoken to session
	 *  4. ok
	 */
	class T_sina {

		function __construct() {

			$this->weibo = new WeiboOAuth( WB_AKEY, WB_SKEY );
		}
		
		function getOfficialWeibo() {
			
		}

		
		function getWeibo() {
			$ci =& get_instance();
			$last_key = $ci->session->userdata('last_key');
			
			$c = new WeiboClient( WB_AKEY, WB_SKEY, $last_key['oauth_token'], $last_key['oauth_token_secret'] );
			
			return $c;
		}
		
		
		/**
		 *	判断当前用户是否已经成功oauth登录~
		 		登录了,返回t_sina_id
		 */
		function is_logined() {
			$weibo = $this->getWeibo();
			$me = $weibo->verify_credentials();
			
			if ( isset( $me['error_code'] ) ) {
				return false;
			} else {
				// 登录过了, 返回t_sina_id
				
				//************登录了, 还没填profile?? redirect!!
				
				
				
				return $me['id'];
			}
		}
		
		/** 
		 *	获取RequestToken  (deprecated)
		 */
		function getRequestToken() {
			return $this->weibo->getRequestToken(); // $keys
		}
		
		
		/**
		 *	获取授权地址,该地址转到新浪的网页，让用户进行授权
		 
		 			需提供$callback 返回网址
		 
		 	(常用)Example:
		 	
		 	action authorize_link():
		 		$authorize_url = $this->t_sina->getAuthorizeURL( 'http://' . $_SERVER["HTTP_HOST"] . site_url('oauth') );
		 		redirect( $authorize_url );
		 		
		 		
		 	一般建议把这个授权地址放到一个controller action里，因为新浪提供的oauth_token是有限时的，
		 	若用户进入页面后一定时间按，token会失效，这时再按，就会出错！
			这非常重要
		 */
		function getAuthorizeURL( $callback_url ) {
			
			// RequestToken 写入 session
			
			$keys = $this->getRequestToken();
			$ci =& get_instance();
			$ci->session->set_userdata('keys', $keys);
			
			return $this->weibo->getAuthorizeURL( $keys['oauth_token'], false, $callback_url );
		}
		
		
		function getAccessToken() {
			$ci =& get_instance();
			$session_keys = $ci->session->userdata('keys');
			$o = new WeiboOAuth( WB_AKEY, WB_SKEY,  $session_keys['oauth_token'], $session_keys['oauth_token_secret'] );
			
			
			if ( ! isset( $_REQUEST['oauth_verifier'] ) ) {
				// 没GET值, 无返回成功码~
				return false;
			}
			
			
			
			$last_key = $o->getAccessToken( $_REQUEST['oauth_verifier'] );
			
			
			return $last_key;
			
			//$ci->session->set_userdata( 'last_key' ) = $last_key;
			
		}
		
		/**
		 *	登录过微博?  获取自己的信息
		 */
		function getSelf() {
			$weibo = $this->getWeibo();
			$me = $weibo->verify_credentials();
			
			return $me;
			
		}
		
		
		/**
		 *	获取指定uid的用户信息
		 */
		function getUser( $uid_or_name) {
			$weibo = $this->getWeibo();
			
			return $weibo->show_user( $uid_or_name );
		}
		
		/**
		 *  用官方微博帐号~
		 
		 *	评论 用户的最后一条或最后第二条微博~  以起提醒作用
		 */
		function reply_last_wb( $user_t_sina_id, $text ) {
			$weibo = new weibo('885182410');
			$weibo->setUser('chepy.v@gmail.com', '709394');
			
			$user_wbs = $weibo->user_timeline( $user_t_sina_id );
			
			
			
			if ( isset( $user_wbs[1] ) ) {
				// 存在第二条微博～那么回复第二条， 第一条太显眼不好～
				$last_wb = $user_wbs[1];
			} elseif ( isset( $user_wbs[0]) ) {
				$last_wb = $user_wbs[0];
				
			} else {
				$last_wb = null;
			}
			
			$weibo->send_comment( $last_wb['id'], $text);
		}
		
	}