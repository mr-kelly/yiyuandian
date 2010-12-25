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


/**
 *	获取静态文件~ 
 */
function static_url( $file ) {
	$ci =& get_instance();
	return $ci->config->item('static_url') . $file;
}

function import_js() {

}

function import_css($file) {

}
