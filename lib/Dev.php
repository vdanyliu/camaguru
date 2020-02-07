<?php

	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	function debug($str) {
		echo '<pre>';
		var_dump($str);
		echo '<pre>';
		//exit;
	}

	function trim_value(&$value)
	{
		$value = trim($value);
	}

	function sanitizee(&$str) {
		$str = trim($str);
		$str = htmlspecialchars($str);
		$str = preg_replace("/=/", "=\"\"", $str);
		$str = preg_replace("/&quot;/", "&quot;\"", $str);
		$tags = "/&lt;(\/|)(\w*)(\ |)(\w*)([\\\=]*)(?|(\")\"&quot;\"|)(?|(.*)?&quot;(\")|)([\ ]?)(\/|)&gt;/i";
		$replacement = "<$1$2$3$4$5$6$7$8$9$10>";
		$str = preg_replace($tags, $replacement, $str);
		$str = preg_replace("/=\"\"/", "=", $str);
	}
