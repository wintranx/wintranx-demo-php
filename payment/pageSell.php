<?php
	$postInfo = $_POST;
	$md5Key = 'E30D1kozivwvYys8V5OjsVTgWDc0B73q2H0Jr4fkuNWWzuZkpuHIIGq0DL6z6iwCOr5tZVcIxGE8Ou6Z2hIu4UE0JRm7nV1arpj0qTQ7KxxZU4x906NRWgPLHaEJYt6T';
    $postInfo['basket'] = json_decode($postInfo['basket'], true);
    $postInfo['deliveryAddress'] = json_decode($postInfo['deliveryAddress'], true);
    $postInfo['billingAddress'] = json_decode($postInfo['billingAddress'], true);
    $postInfo['merDescribe'] = json_decode($postInfo['merDescribe'], true);
	$postInfo['md5Key'] = $md5Key;
    //去掉值为空的键值对
    $postInfo = array_filter($postInfo);
	$postInfo['tf_sign'] = getSing($postInfo);

	$postSell['requestJson'] = $postInfo;

	echo json_encode($postSell);

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
								$val = json_encode($val, JSON_FORCE_OBJECT);
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