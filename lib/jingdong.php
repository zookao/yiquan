<?php
class Jingdong
{
    const KEY = '836413038';
    const PRE_URL = 'http://api.web.ecapi.cn/jingdong/doItemCpsUrl?';
    const JINGDONG_KEY = 'J4838956112181787';

    public static function run($content)
    {
        $buildQuery = [
            'apkey'    => self::KEY,
            'materialId'  => $content,
            'key_id'   => self::JINGDONG_KEY,
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
                $content['url'] = $data['shortURL'];
                $content['usage'] = "复制链接至浏览器打开";
            }else{
                $content['url'] = "";
                $content['usage'] = "宝贝优惠活动可能结束了，换个宝贝试一下吧";
            }
        }else{
            $content['url'] = "";
            $content['usage'] = "查询优惠券时出了个小问题，换个宝贝试一下吧";
        }
        return $content;
    }
}
