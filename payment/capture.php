<?php
	$postInfo = $_POST;
	$host = 'http://test.api.wintranx.com';
	$method = "POST";
	$md5Key = 'xvjaOk3bBDwpnv45aAkAN3vtj5z3fNxfICnnmSoAkxbq10Z9eVJyqrCn1nYeJROA2sTdREsnz5h6jssdlJwOxiRb7AnZ4KX1Y2dZZw6Hjse3dMLOUHnLBX7WXEIadKpb';
	$authorizeUrl = $host . '/wintranx-order/api/transaction/capture';
	$postInfo['md5Key'] = $md5Key;
	$postInfo['tf_sign'] = getSing($postInfo);
    //去掉值为空的键值对
    $postInfo = array_filter($postInfo);
	$authorize = post($host, $authorizeUrl, $method, json_encode($postInfo, 320));
	echo json_encode($authorize);

	// 发送POST请求
	function post($host, $url, $method, $data_string) {
		$curl = curl_init();
		
		curl_setopt($curl, CURLOPT_HTTPGET, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。


		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'X-AjaxPro-Method:ShowList',
			'Content-Type: application/json; charset=utf-8',
			'Content-Length: ' . strlen($data_string)
		));

		curl_setopt($curl, CURLOPT_HEADER, true); //返回response头部信息
		curl_setopt($curl, CURLINFO_HEADER_OUT, true); //TRUE 时追踪句柄的请求字符串，从 PHP 5.1.3 开始可用。这个很关键，就是允许你查看请求header
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_FAILONERROR, false);
		if (1 == strpos("$".$host, "https://"))
		{
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		}
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
		$response = curl_exec($curl);
		$headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$res['header'] = substr($response, 0, $headerSize);
		$res['body'] = substr($response, $headerSize);
		$res['getHeader'] = curl_getinfo($curl, CURLINFO_HEADER_OUT) . 'body: ' . stripslashes_deep(json_encode($data_string, 320)); //官方文档描述是“发送请求的字符串”，其实就是请求的header。这个就是直接查看请求header，因为上面允许查看		
		curl_close($curl);
		return $res;
	};

	function stripslashes_deep($value) {
		$value = is_array($value) ?
				array_map('stripslashes_deep', $value) :
				stripslashes($value);
		return $value;
	}

	function getSing($params){
		if(!empty($params)){
			$p = ksort($params);
			if($p) {
				$str = '';
				foreach ($params as $k => $val) {
					if(!empty($val)) {
						if(is_array($val)) {
							if(count($val) == count($val, 1)) {
								ksort($val);
								$val = json_encode($val, 320);
							} else {
								foreach($val as $key => $value) {
									ksort($val[$key]);
								};
								$val = json_encode($val);
							};
						}
						
						$str .= $k .'=' . $val . '&';						
					}
					
				};
				$strs = rtrim($str, '&');
				return strtoupper(md5($strs));
			}
		}
		return '参数错误';
	}
?>