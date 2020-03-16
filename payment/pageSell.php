<?php
	$postInfo = $_POST;
	$md5Key = 'xvjaOk3bBDwpnv45aAkAN3vtj5z3fNxfICnnmSoAkxbq10Z9eVJyqrCn1nYeJROA2sTdREsnz5h6jssdlJwOxiRb7AnZ4KX1Y2dZZw6Hjse3dMLOUHnLBX7WXEIadKpb';

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