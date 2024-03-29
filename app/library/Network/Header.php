<?php

/**
 * HTTP头信息
 * @author enychen
 */
namespace Network;

class Header
{

	/**
	 * 设置字符集头信息
	 * @param string $content
	 */
	public static function contentType($content, $charset = 'CHARSET=UTF-8')
	{
		header("Content-Type:{$content};{$charset}");
	}

	/**
	 * 允许跨域设置cookie
	 * @return void
	 */
	public static function p3p()
	{
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	}

	/**
	 * 缓存控制
	 * @return void
	 */
	public static function cacheControl()
	{
		header('Cache-Control:private, max-age=0, no-cache, must-revalidate, no-cache=Set-Cookie, proxy-revalidate');
	}

	/**
	 * 跨域的访问控制
	 */
	public static function AccessControl($httpHost, $headers = TRUE)
	{
		$httpHost = is_array($httpHost) ? implode(',', $httpHost) : $httpHost;
		header("Access-Control-Allow-Origin: {$httpHost}");
		$headers and header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); // 设置允许的跨域header
	}
}