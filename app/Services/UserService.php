<?php
/**
 * Created by PhpStorm.
 * User: wangtian
 * Date: 2018/12/10
 * Time: 4:07 PM
 */

namespace App\Services;

use App\Models\User;

class UserService
{
    protected $appId;
    protected $secret;
    protected $openId;

    const ERRORSTR = "{'code':1}";

    public function __construct()
    {
        $this->appId = env('WX_APP_ID');
        $this->secret = env('WX_SECRET');
    }

    public function getUserInfo($params)
    {
        $code = $params['code'];
        $this->getOpenId($code);
        $rs = User::query()->where('openid',$this->openId)->first();
        if (!empty($rs)){
            echo json_encode(['code'=>0,$rs]);
        }else{
            die(self::ERRORSTR);
        }
    }

    protected function getOpenId($code)
    {
        $appId = $this->appId;
        $secret = $this->secret;
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $appId . '&secret=' . $secret . '&js_code=' . $code . '&grant_type=authorization_code';
        $data = json_decode(file_get_contents($url),TRUE);
        if ($data['errcode'] != 0){
            die(self::ERRORSTR);
        }else{
            $this->openId =  json_decode($data, 1)['openid'];
        }
    }


}