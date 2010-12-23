<?php

/**
 *	KK输出视图函数，压缩了HTML
 */
function kk_show_view( $view, $data=array() ) {
	$ci =& get_instance();
	$ci->load->plugin('compress_html');
	//$ci->load->plugin('spaceless');
	
	$html = $ci->load->view($view, $data, true);

	// 输出压缩过的html
	echo compress_html( $html );
	//echo $html;
}
