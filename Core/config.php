<?php
// +----------------------------------------------------------------------
// | TvcPHP PHP微型框架，一个用于快速构建交互DEMO系统的微型框架。
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.ccbox.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: 达达 <ccbox_net@163.com> <http://www.ccbox.net>
// +----------------------------------------------------------------------
// | Date Time: 16:21 2017-03-20
// | Title: 核心配置文件
// +----------------------------------------------------------------------

// 系统核心配置，一般不用动，具体的APP配置在APP的配置里面搞定
// error_reporting(E_ERROR);
// define('BASE', 'http://'.$_SERVER['SERVER_NAME'].'/');
// define('HOST', 'http://'.$_SERVER['SERVER_NAME']);

// 

$cfg_defualt['core']['ROOT'] = dirname(rtrim($_SERVER['SCRIPT_FILENAME'],'/')).'/';	// 定义文件根目录
$cfg_defualt['core']['SITE'] = dirname(rtrim($_SERVER['SCRIPT_NAME'],'/')).'/';		// 定义网站根目录
$cfg_defualt['core']['HOME'] = rtrim($_SERVER['SCRIPT_NAME'],'/');					// 定义网站入口文件
$cfg_defualt['core']['DS'] = '/';							// 目录分隔符【用处不大】
$cfg_defualt['core']['DEBUG'] = false;						// 调试模式

$cfg_defualt['core']['DEFUALT_CTL'] = 'home';				// 定义默认控制器
$cfg_defualt['core']['DEFUALT_ACT'] = 'index';				// 定义默认方法
$cfg_defualt['core']['ERROR_404'] = 'core_error_404';		// 定义404页面

$cfg_defualt['core']['CTL_NAME'] = 'c';						// 定义默认控制器
$cfg_defualt['core']['ACT_NAME'] = 'a';						// 定义默认方法

$cfg_defualt['core']['ACT_FIX'] = '_act';						// 定义默认方法的后缀，防止前端随便访问和执行函数

$cfg_defualt['core']['FOLDER_CTL'] = 'c/';					// 定义控制器目录
$cfg_defualt['core']['FOLDER_VIEW'] = 'v/';					// 定义视图目录

$cfg_defualt['core']['VIEW_FIX'] = '.html';					// 模板后缀

// 定义前端用地址
// $cfg_defualt['view']['AUI242'] = PUBLIC_ROOT.'AmazeUI-2.4.2/';
$cfg_defualt['view']['SITE'] = $cfg_defualt['core']['SITE'];	// 模板变量定义：网站根目录
$cfg_defualt['view']['HOME'] = $cfg_defualt['core']['HOME'];	// 定义网站入口文件
$cfg_defualt['view']['PUBLIC_ROOT'] = 'Public/';				// 模板变量定义：公共Public目录

// 定义404页面的内容
$cfg_defualt['ERROR_404']['title'] = '页面没找到';
$cfg_defualt['ERROR_404']['info'] = '非常的抱歉，你访问的页面没找到。';
