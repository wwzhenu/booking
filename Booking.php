<?php
/**
 * Created by PhpStorm.
 * User: wangtian
 * Date: 2018/12/7
 * Time: 2:08 PM
 */
class Booking
{
    protected $db;
    protected $openId;
    protected $appId;
    protected $secret;
    protected $code;


    public function __construct($appId,$secret,$code)
    {
        $this->db = new SQLite3('booking.sqlite');
        $this->appId = $appId;
        $this->secret = $secret;
        $this->code = $code;
        $this->openId = $this->getOpenId($appId,$secret,$code);
    }

    public function getUserInfo()
    {
        $openId = $this->openId;
        return $this->db->query('SELECT * FROM users WHERE openid='."'{$openId}'")->fetchArray(SQLITE3_ASSOC);
    }

    protected function getOpenId($appId,$secret,$code){
        $url  = "https://api.weixin.qq.com/sns/jscode2session?appid={$appId}&secret={$secret}&js_code={$code}&grant_type=authorization_code";
        $data = file_get_contents($url);
        return json_decode($data,1)['openid'];
    }

    public function addUser($class,$name){
        $openId = $this->openId;
        $this->db->query("insert into users values ('{$openId}','{$class}','{$name}')");
    }
}