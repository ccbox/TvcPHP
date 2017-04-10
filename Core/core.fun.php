<?php
// +----------------------------------------------------------------------
// | TvcPHP PHP微型框架，一个用于快速构建交互DEMO系统的微型框架。
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.ccbox.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: 达达 <ccbox_net@163.com> <http://www.ccbox.net>
// +----------------------------------------------------------------------
// | Date Time: 16:21 2017-03-20
// | Title: 核心函数文件
// +----------------------------------------------------------------------


/* ============ 函数 ============================================================================ */

// =================================================================================================
// 系统默认的404错误页面
function core_error_404($title='',$info=''){
	$v['title'] = empty($title) ? '页面没找到' : $title;
	$v['info'] = empty($info) ? '非常的抱歉，你访问的页面没找到。' : $info;
	show('error_404',$v);
}

// =================================================================================================
/**
 * 模板内容替换
 * @param string $content 模板内容
 * @return string
 */
function templateContentReplace($content) {
	// 系统默认的特殊变量替换
	global $cfg;
	foreach($cfg['view'] as $key=>$val){
		$replace['{'.$key.'}'] = $val;
	}
	$replace['{APP}'] = APP;
	$replace['{NOW_CTL}'] = NOW_CTL;
	$replace['{NOW_ACT}'] = NOW_ACT;
	$content = str_replace(array_keys($replace),array_values($replace),$content);
	return $content;
}

// =================================================================================================
/**
 * 解析和获取模板内容 用于输出
 * @param string $templateFile 模板文件名
 * @param string $charset 模板输出字符集
 * @param string $contentType 输出类型
 * @return string
 */
function show($template = '', $param = array(), $temp_fix = '.html', $charset = '', $contentType = '')
{
	if(!empty($param))extract($param);
	$temp_fix = defined(VIEW_FIX) ? VIEW_FIX : $temp_fix ;
	
	if(empty($template)){
		$templateFile = '';
	}else{
		$templateFile = APP.FOLDER_VIEW.NOW_CTL.DS.$template.$temp_fix;
	}
	
	// 模板文件不存在直接返回
	if (!is_file($templateFile)){
		$templateFileDefualt = CORE.'v/'.$template.$temp_fix;
		if (!is_file($templateFileDefualt)){
			if(DEBUG){
				exit('模板不存在：'.$templateFile);
			}else{
				exit('系统错误。');
				// 友好显示404错误
				// $templateFile = CORE.'v/error404_html'.$temp_fix;
			}
		}else{
			$templateFile = $templateFileDefualt;
		}
	}
	// 页面缓存
	ob_start();
	ob_implicit_flush(0);
	// 直接载入PHP模板 // 使用PHP原生模板
	include $templateFile;
	// 获取并清空缓存
	$content = ob_get_clean();
	// 内容过滤标签
	//Hook::listen('view_filter', $content);
	$content = templateContentReplace($content);
	
	// 输出内容文本
	if (empty($charset)) $charset = 'utf-8';
	if (empty($contentType)) $contentType = 'text/html';
	// 网页字符编码
	header('Content-Type:' . $contentType . '; charset=' . $charset);
	header('Cache-control: private'); // 页面缓存控制
	header('X-Powered-By:CCBox');
	
	// 输出模板文件
	echo $content;
}

// =================================================================================================
// 获取URL参数【GET】
function get_url_data($str, $default=null){
	$val = !empty($_GET[$str]) ? $_GET[$str] : $default;
	return $val;
}
// =================================================================================================
// 删除URL（GET）中的某个参数
function set_get_data($key, $val=null){
	if(isset($_GET[$key]) && $val){
		$_GET[$key] = $val;
	}else{
		unset($_GET[$key]);
	}
}
// =================================================================================================
// 生成拼装的URL地址
function U($param='',$c='',$a='',$script_name=''){
	$script_name = empty($script_name) ? $_SERVER['SCRIPT_NAME'] : $script_name;
	$query_str = make_query_string($param,$c,$a);
	return $script_name.'?'.$query_str;
}
// =================================================================================================
// 生成URL的QUERY_STRING字符串
// $param 传入参数值，格式：
// 			['a'=>'aaa','b'=>'bbb']
// 			['a=aaa','b=bbb']
// 			’a=aaa|b=bbb'
function make_query_string($param='',$c='',$a=''){
	$cell_arr = array();
	$return_arr = array();
	if(is_array($param)){
		foreach($param as $key=>$val){
			$val_arr = explode('=',$val);
			if(count($val_arr)==2){
				$cell_arr[$val_arr[0]] = $val_arr[1];
			}elseif(!is_int($key)){
				$cell_arr[$key] = $val; 
			}
		}
	}elseif(is_string($param)){
		$param_arr = explode('|',$param);
		if(count($param_arr)>0){
			foreach($param_arr as $key=>$val){
				$val_arr = explode('=',$val);
				if(count($val_arr)==2){
					$cell_arr[$val_arr[0]] = $val_arr[1];
				}
			}
		}
	}
	$c = empty($c) ? NOW_CTL : $c;
	$a = empty($a) ? NOW_ACT : $a;
	$cell_arr[CTL_NAME] = array_key_exists(CTL_NAME,$cell_arr) ? $cell_arr[CTL_NAME] : $c;
	$cell_arr[ACT_NAME] = array_key_exists(ACT_NAME,$cell_arr) ? $cell_arr[ACT_NAME] : $a;
	foreach($cell_arr as $key=>$val){
		$return_arr[] = $key.'='.$val;
	}
	return implode('&',$return_arr);
}

// =================================================================================================
// =================================================================================================
// =================================================================================================

