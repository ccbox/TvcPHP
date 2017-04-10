<?php
// +----------------------------------------------------------------------
// | TvcPHP PHP微型框架，一个用于快速构建交互DEMO系统的微型框架。
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.ccbox.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: 达达 <ccbox_net@163.com> <http://www.ccbox.net>
// +----------------------------------------------------------------------
// | Date Time: 16:21 2017-03-20
// | Title: 核心驱动文件
// | 	
// | 	用于演示DEMO用的简单的核心驱动
// | 	URL不支持rewrite
// | 
// +----------------------------------------------------------------------

// 系统配置【通用】
date_default_timezone_set("PRC");
header("Content-Type: text/html; charset=utf-8");
@session_start();

// =================================================================================================
// 载入配置文件：数据库、url路由等等
require(CORE.'config.php');		// 系统配置
require(APP.'config.php');		// APP配置
// 定义默认常量 合成定义
foreach($cfg_defualt as $key=>$val){
	if(is_array($val)){
		foreach($val as $k=>$v){
			if(empty($cfg[$key][$k])) $cfg[$key][$k] = $v;
		}
	}else{
		if(empty($cfg[$key])) $cfg[$key] = $val;
	}
}
// 批量定义常量
foreach($cfg['core'] as $key=>$val){
	if(!defined($key)) define($key, $val); 
}

// =================================================================================================
require(CORE.'util.php');		// 系统周边函数库
require(CORE.'core.fun.php');	// 系统核心函数库
if(is_file(APP.'app.php')) {
	require(APP.'app.php');		// APP前置函数库
}

// =================================================================================================
// 去除Magic_Quotes
if(get_magic_quotes_gpc()) // Maybe would be removed in php6
{
	function stripslashes_deep($value)
	{
		$value = is_array($value) ? array_map('stripslashes_deep', $value) : (isset($value) ? stripslashes($value) : null);
		return $value;
	}
	$_POST = stripslashes_deep($_POST);
	$_GET = stripslashes_deep($_GET);
	$_COOKIE = stripslashes_deep($_COOKIE);
}

// =================================================================================================
// 启动
function start()
{
	global $cfg;
	$c = get_url_data(CTL_NAME, DEFUALT_CTL);
	$a = get_url_data(ACT_NAME, DEFUALT_ACT);
	define('NOW_CTL', $c);
	define('NOW_ACT', $a);
	// 是否有执行函数
	if(is_file(APP.FOLDER_CTL.$c.'.php')) {
		require(APP.FOLDER_CTL.$c.'.php');
	}else{
		//ERROR_404('控制器文件不存在','控制器不存在。');
	}
	$act = $a.ACT_FIX;
	if(function_exists($act)){
		$act();
	}elseif(function_exists('error_404')){
		error_404();
	}else{
		// 没有的话直接显示错误模板
		$error_404_fun = ERROR_404;
		$error_404_fun('未定义的操作','未定义的操作');
		//ERROR_404('控制器不存在','控制器不存在。');
	}
}
