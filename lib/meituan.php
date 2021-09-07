<?php
class Meituan
{
    const KEY = '836413038';
    const WAIMAI_PRE_URL = 'http://api.web.ecapi.cn/platform/meituan_v2?';
    const JIUDIAN_PRE_URL = 'http://api.web.ecapi.cn/platform/meituan_hotel?';
    const SHANGOU_PRE_URL = 'http://api.web.ecapi.cn/platform/meituan_shangou?';
    const YOUXUAN_PRE_URL = 'http://api.web.ecapi.cn/platform/meituan_youxuan?';

    public static function waimai()
    {
        $url = self::WAIMAI_PRE_URL.'apkey=836413038&eid=common';
        $result = curlGet($url);
        $array = json_decode($result,true);
        if(isset($array['code']) && $array['code'] == 200){
            $url = $array['data']['url'];
            return $url;
        }else{
            return '请重试';
        }
    }

    public static function jiudian()
    {
        $url = self::JIUDIAN_PRE_URL.'apkey=836413038&eid=1';
        $result = curlGet($url);
        $array = json_decode($result,true);
        if(isset($array['code']) && $array['code'] == 200){
            $url = $array['data']['h5_link'];
            return $url;
        }else{
            return '请重试';
        }
    }

    public static function youxuan()
    {
        $url = self::YOUXUAN_PRE_URL.'apkey=836413038&eid=1';
        $result = curlGet($url);
        $array = json_decode($result,true);
        if(isset($array['code']) && $array['code'] == 200){
            $url = $array['data']['h5_link'];
            return $url;
        }else{
            return '请重试';
        }
    }

    public static function shangou()
    {
        $url = self::SHANGOU_PRE_URL.'apkey=836413038&eid=common';
        $result = curlGet($url);
        $array = json_decode($result,true);
        if(isset($array['code']) && $array['code'] == 200){
            $page = $array['data']['wx_app']['page_url'];
            return $page;
        }else{
            return '请重试';
        }
    }

    public static function waimaiMini()
    {
        $url = self::WAIMAI_PRE_URL.'apkey=836413038&eid=common';
        $result = curlGet($url);
        $array = json_decode($result,true);
        if(isset($array['code']) && $array['code'] == 200){
            $page = $array['data']['wx_app']['page_url'];
            return $page;
        }else{
            return '请重试';
        }
    }
}
