<?php

    // 编码
    header('Content-type:application/json');
    
    // 获取appid
    $appid = trim($_GET['appid']);
    
    // appid正则表达式验证规则
    $appid_pattern = '/^wx[a-f0-9]{16}$/';
    
    if($appid) {
        
        // 验证appid是否符合规则
        if(!preg_match($appid_pattern, $appid)) {
        
            $result = array(
                'code' => 201,
                'msg' => 'appid不符合规则'
            );
        }else {
            
            // 目标URL
            $url = 'https://mp.weixin.qq.com/mp/waerrpage?appid='.$appid.'&type=offshelf';
            
            // 初始化cURL会话
            $ch = curl_init();
            
            // 设置cURL选项
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            // 执行cURL并获取页面内容
            $response = curl_exec($ch);
            
            // 关闭cURL会话
            curl_close($ch);
            
            // 获取后面的内容
            $str1 = substr($response, strripos($response, "weui-msg__title"));
            
            // 获取前面的内容
            $str2 = substr($str1, 0, strrpos($str1, "weui-msg__desc"));
            
            // 不正常的类型
            $close_type_1 = '小程序因违规已暂停服务';
            $close_type_2 = '小程序系统故障，开发者正在修复';
            $close_type_3 = '小程序已暂停服务';
            $close_type_4 = '小程序系统更新维护中';
            
            // 判断
            if(preg_match("/因违规已暂停服务/", $str2)) {
                
                $result = array(
                    'code' => 201,
                    'msg' => $close_type_1
                );
            }else if(preg_match("/正在修复/", $str2)) {
                
                $result = array(
                    'code' => 201,
                    'msg' => $close_type_2
                );
            }else if(preg_match("/小程序已暂停服务/", $str2)) {
                
                $result = array(
                    'code' => 201,
                    'msg' => $close_type_3
                );
            }else if(preg_match("/更新维护中/", $str2)) {
                
                $result = array(
                    'code' => 201,
                    'msg' => $close_type_4
                );
            }else{
                
                $result = array(
                    'code' => 200,
                    'msg' => '小程序正常'
                );
            }
        }
    }else {
        
        $result = array(
            'code' => 201,
            'msg' => '请传入appid'
        );
    }

    // 输出
    echo json_encode($result,JSON_UNESCAPED_UNICODE);

?>
