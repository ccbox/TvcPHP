<?php
// +----------------------------------------------------------------------
// | TvcPHP PHP微型框架，一个用于快速构建交互DEMO系统的微型框架。
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.ccbox.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: 达达 <ccbox_net@163.com> <http://www.ccbox.net>
// +----------------------------------------------------------------------
// | Date Time: 16:21 2017-03-20
// | Title: 支持函数文件
// +----------------------------------------------------------------------

// =================================================================================================
// 生成随机数字串，一般用于订单号生成
function mark_order_sn(){
	$return = date('YmdHis') . rand(1000,9999);
	return $return;
}

// =================================================================================================
/* 
 * 获取当前时间
 */
function getNowDateTime() {
	return date ( 'Y-m-d H:i:s' );
}

/* ============ 调试部分函数 ================================================================================== */
//dump('import function OK!');
/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dump($var, $label=null, $echo=true, $strict=true) {
	$label = ($label === null) ? '' : rtrim($label) . ' ';
	if (!$strict) {
		if (ini_get('html_errors')) {
			$output = print_r($var, true);
			$output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
		} else {
			$output = $label . print_r($var, true);
		}
	} else {
		ob_start();
		var_dump($var);
		$output = ob_get_clean();
		if (!extension_loaded('xdebug')) {
			$output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
			$output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
		}
	}
	if ($echo) {
		echo($output);
		return null;
	}else
		return $output;
}

// =================================================================================================
// 输出session
function dump_ul_list($array, $protected_root_key=array(), $pkey=array(), $level=0, $protected_sub=false) {
	if($level > 0){
		$style = 'border-left:1px solid #c88;';
	}else{
		$style = 'border-left:1px solid #c8c;';
	}
	$output = '<ul style="'.$style.'">';
	
	foreach($array as $key=>$val){
		$pkey[$level] = $key;
		$result = '';
		
		$url_key = implode('|',$pkey);
		$url_text = implode(' - ',$pkey);
		
		//if(!in_array($url_key,$protected_root_key)){
			$style_li = '';
			if($level < 1){
				$style_li = 'border-top:4px solid #8ee;';
				if(!in_array($key,$protected_root_key)){
					$protected_sub=false;
				}
			}
			if(in_array($key,$protected_root_key) || $protected_sub){
				$url_key = '';
				$url_text = '';
				$protected_sub=true;
				$style_li = 'border-top:4px solid #ee3;';
			}
		
			$output .= '<li style="'.$style_li.'">';
			//$output .= '【'.$url_key.' - '.$keyin.'】';
			$output .= '<a data-href="'.$url_key.'" data-text="'.$url_text.'" 
						style="border-bottom:1px solid #8ee;display:block;width:100%;">';
			//$output .= '【'.$level.'】';
			if(is_array($val)){
				
				$output .= '<b>'.$key.'</b> :  (array)['.count($val).']';
				$output .= '</a>';
				if($protected_sub)$protected_sub=true;
				$result = dump_ul_list($val,$protected_root_key,$pkey,$level+1,$protected_sub);
				if($result){
					$output .= $result;
				}
			}else{
				$output .= '<b>'.$key.'</b> : '.$val;
				$output .= '</a>';
				$output .= '';
			}
			$output .= '</li>';
		//}
	}
	$output .= '</ul>';
	return $output;
}

// =================================================================================================
// =================================================================================================
// =================================================================================================
