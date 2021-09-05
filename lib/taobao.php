<?php
class Taobao
{
    const KEY = '836413038';
    const TAOBAO_PID = 'mm_26539241_2299800169_111344300080';
    const TAOBAO_NAME = '超and颖';
    const PRE_URL = 'http://api.web.ecapi.cn/taoke/doItemHighCommissionPromotionLinkByAll?';
    const ELEME_URL = 'http://api.web.ecapi.cn/taoke/getTbkActivityInfo?';

    public static function run($content)
    {
        $buildQuery = [
            'apkey'    => self::KEY,
            'pid'      => self::TAOBAO_PID,
            'tbname'   => self::TAOBAO_NAME,
            'content'  => $content,
            'tpwd' => 1,
            'shorturl' => 1,
        ];
        $result = self::handle(self::PRE_URL,$buildQuery);
        return $result;
    }

    public static function handle($url,$buildQuery)
    {
        $query = http_build_query($buildQuery);
        $finalUrl = $url.$query;
        $response = curlGet($finalUrl);
        if ($response) {
            $responseArray = json_decode($response,true);
            if (is_array($responseArray) && isset($responseArray['code']) && $responseArray['code'] == 200) {
                $data = $responseArray['data'];
                $content['url'] = $data['short_url'];
                $content['token'] = $data['tpwd'];
                $content['usage'] = "淘口令和短链接任选一种即可";
            }else{
                $content['url'] = "";
                $content['usage'] = "宝贝优惠活动可能结束了，换个宝贝试一下吧";
            }
        }else{
            $content['url'] = "";
            $content['usage'] = "宝贝优惠活动可能结束了，换个宝贝试一下吧";
        }
        return $content;
    }

    public static function elemeMini()
    {
        $url = self::ELEME_URL.'apkey=836413038&eid=common';
        $buildQuery = [
            'apkey'    => self::KEY,
            'pid'      => self::TAOBAO_PID,
            'tbname'   => self::TAOBAO_NAME,
            'activity_material_id'  => 20150318020002597,
        ];
        $query = http_build_query($buildQuery);
        $result = curlGet($url.$query);
        $array = json_decode($result,true);
        if(isset($array['code']) && $array['code'] == 200){
            $page = $array['data']['wx_miniprogram_path'];
            return $page;
        }else{
            return '请重试';
        }
    }
}
