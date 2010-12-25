<?php

//函数名: compress_html
//参数: $string
//返回值: 压缩后的$string
function compress_html_old($string) {
    $string = str_replace("\r\n", '', $string); //清除换行符
    $string = str_replace("\n", '', $string); //清除换行符
    $string = str_replace("\t", '', $string); //清除制表符
    $pattern = array (
                    "'<!--[/!]*?[^<>]*?>'si", //去掉注释标记
                    "'  '",
                    );
    $replace = array (
                    "",
                    "",
                    );
    return preg_replace($pattern, $replace, $string);
} 


/**
 *	来自 Haanga Spaceless Class 修改过
 */	
function compress_html($string) {

   // will remove tabs, line breaks and extra white spaces
   $r = preg_replace(array('/>[ \t\r\n]+</sU','/^[ \t\r\n]+</sU','/>[ \t\r\n]+$/sU'), array('><', '<', '>'), $string);
   //$r = preg_replace('/\s\s+/',' ',$r);
   
   return $r;
}
