<?php
require __DIR__.'/lib/curl.php';

if(strtolower($_SERVER['REQUEST_METHOD']) == 'post'){
    $keyword = $_POST['content'];
    preg_match('/￥.*￥/', $keyword, $matchToken);
    if (isset($matchToken[0]) && $matchToken[0]) {
        $type = 'taobao';
        $content = $matchToken[0];
    }else{
        preg_match('/(https|http):\/\/[-A-Za-z0-9+&@#\/%?=~_|!:,.;]*/', $keyword, $matchUrls);
        if (isset($matchUrls[0]) && $matchUrls[0]) {
            $url = $matchUrls[0];
            if(strstr($url,'tmall.com') || strstr($url,'taobao.com')){
                $type = 'taobao';
                $content = $keyword;
            }elseif(strstr($url,'jd.com')){
                $type = 'jingdong';
                $content = $keyword;
            }elseif(strstr($url,'vip.com')){
                $type = 'weipinhui';
                $content = $keyword;
            }elseif(strstr($url,'yangkeduo.com') || strstr($url,'pinduoduo.com')){
                $type = 'pinduoduo';
                $content = $keyword;
            }else{
                $type = 'taobao';
                $content = $keyword;
            }
        }else{
            $type = 'taobao';
            $content = $keyword;
        }
    }
    if($type == 'taobao'){
        $content = $_POST['content'];
        include __DIR__.'/lib/taobao.php';
        $result = Taobao::run($content);
        echo json_encode(['code' => 1,'data' => $result]);die;
    }elseif($type == 'jingdong'){
        $content = $_POST['content'];
        include __DIR__.'/lib/jingdong.php';
        $result = Jingdong::run($content);
        echo json_encode(['code' => 1,'data' => $result]);die;
    }elseif($type == 'pinduoduo'){
        $content = $_POST['content'];
        include __DIR__.'/lib/pinduoduo.php';
        $result = Pinduoduo::run($content);
        echo json_encode(['code' => 1,'data' => $result]);die;
    }elseif($type == 'meituan-waimai'){
        include __DIR__.'/lib/meituan.php';
        $result = Meituan::waimai();
        echo json_encode(['code' => 1,'data' => $result]);die;
    }elseif($type == 'meituan-jiudian'){
        include __DIR__.'/lib/meituan.php';
        $result = Meituan::jiudian();
        echo json_encode(['code' => 1,'data' => $result]);die;
    }elseif($type == 'meituan-youxuan'){
        include __DIR__.'/lib/meituan.php';
        $result = Meituan::youxuan();
        echo json_encode(['code' => 1,'data' => $result]);die;
    }elseif($type == 'meituan-shangou'){
        include __DIR__.'/lib/meituan.php';
        $result = Meituan::shangou();
        echo json_encode(['code' => 1,'data' => $result]);die;
    }elseif($type == 'weipinhui'){
        $content = $_POST['content'];
        include __DIR__.'/lib/weipinhui.php';
        $result = Weipinhui::run($content);
        echo json_encode(['code' => 1,'data' => $result]);die;
    }
}else{
    return json_encode(['code' => 0,'msg' => '请求方式错误']);
}
