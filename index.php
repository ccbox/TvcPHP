<?php
// +----------------------------------------------------------------------
// | TvcPHP PHP微型框架，一个用于快速构建交互DEMO系统的微型框架。
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.ccbox.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: 达达 <ccbox_net@163.com> <http://www.ccbox.net>
// +----------------------------------------------------------------------
// | Date Time: 16:21 2017-03-20
// | Title: 入口文件
// +----------------------------------------------------------------------

// 定义
// define('NOWDIR','./');		// 当前文件所在目录相对网站根目录，暂时没啥用
define('CORE','Core/');			// 核心驱动目录
define('APP','APP_Core/');	// 应用目录
require(CORE.'core.php');		// 导入核心驱动文件
start();						// 启动
