<?php
/**
 * Created by PhpStorm.
 * User: wangtian
 * Date: 2018/12/6
 * Time: 5:42 PM
 */
include 'Booking.php';
$config = include 'config.php';
$appId = $config['appId'];
$secret = $config['secret'];
$data = json_decode(file_get_contents("php://input"),1);
$code = $data['code'];

$booking = new Booking($appId,$secret,$code);

$rs = ['code'=>1];
$userInfo = $booking->getUserInfo();
if (!empty($userInfo)){
   $rs['code'] = 1;
   $rs['data'] = $userInfo;
}
echo json_encode($rs);