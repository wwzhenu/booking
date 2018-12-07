<?php
/**
 * Created by PhpStorm.
 * User: wangtian
 * Date: 2018/12/6
 * Time: 5:42 PM
 */

$config = include 'config.php';
$appId = $config['appId'];
$secret = $config['secret'];

$data = json_decode(file_get_contents("php://input"),1);
$code = $data['code'];


$url  = "https://api.weixin.qq.com/sns/jscode2session?appid={$appId}&secret={$secret}&js_code={$code}&grant_type=authorization_code";

$data = file_get_contents($url);
$openId = json_decode($data,1)['openid'];

$db = new SQLite3('booking.sqlite3');
$rs = [];
$userInfo = $db->query("select * from user where openid='{$openId}'")->fetchArray(SQLITE3_ASSOC);
if (empty($userInfo)){
    $rs = ['code'=>1];
}else{
    $rs = ['code'=>0,'data'=>$userInfo];
}
echo json_encode($rs);