<?php
require __DIR__.'/lib/curl.php';

if(strtolower($_SERVER['REQUEST_METHOD']) == 'post'){
    $type = $_POST['type'];
    if($type == 'meituan'){
        include __DIR__.'/lib/meituan.php';
        $result = Meituan::waimaiMini();
        echo json_encode(['code' => 1,'data' => $result]);die;
    }elseif($type == 'meituanshangou'){
        include __DIR__.'/lib/meituan.php';
        $result = Meituan::shangou();
        echo json_encode(['code' => 1,'data' => $result]);die;
    }elseif($type == 'eleme'){
        include __DIR__.'/lib/taobao.php';
        $result = Taobao::elemeMini();
        echo json_encode(['code' => 1,'data' => $result]);die;
    }
}else{
    return json_encode(['code' => 0,'msg' => '请求方式错误']);
}
