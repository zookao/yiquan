<?php
class Pinduoduo
{
    const KEY = '836413038';
    const GOOD_PRE_URL = 'http://api.web.ecapi.cn/pinduoduo/goodsSearch?';
    const TRANSFER_PRE_URL = 'http://api.web.ecapi.cn/pinduoduo/createItemPromotionUrl?';
    const PID = '1764187_217232393';
    const NAME = '17600104430';

    public static function run($content)
    {
        $searchQuery = [
            'apkey'    => self::KEY,
            'pdname'   => self::NAME,
            'page' => 1,
            'page_size' => 10,
            'keyword' => $content,
            'pid' => self::PID,
        ];
        $result = self::search(self::GOOD_PRE_URL,$searchQuery);
        return $result;
    }

    public static function search($url,$searchQuery)
    {
        $query = http_build_query($searchQuery);
        $searchUrl = $url.$query;
        $response = curlGet($searchUrl);
        $responseArray = json_decode($response,true);
        if (is_array($responseArray) && isset($responseArray['code']) && $responseArray['code'] == 200) {
            $goodsSign = $responseArray['data']['list'][0]['goods_sign'];
            $buildQuery = [
                'apkey'    => self::KEY,
                'pdname'   => self::NAME,
                'p_id' => self::PID,
                'goods_sign' => $goodsSign,
            ];
            $content = self::handle(self::TRANSFER_PRE_URL,$buildQuery);
        }else{
            $content = "查询优惠券时出了个小问题，换个宝贝试一下吧";
        }
        return $content;
    }

    public static function handle($url,$buildQuery)
    {
        $query = http_build_query($buildQuery);
        $finalUrl = $url.$query;
        $response = curlGet($finalUrl);
        if ($response) {
            $responseArray = json_decode($response,true);
            if (is_array($responseArray) && isset($responseArray['code']) && $responseArray['code'] == 200) {
                $data = $responseArray['data']['url'][0];
                $content['url'] = $data['short_url'];
                $content['usage'] = "复制链接至浏览器打开";
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
}
