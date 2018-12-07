<?php
/**
 * Created by PhpStorm.
 * User: wangtian
 * Date: 2018/12/6
 * Time: 5:42 PM
 */

$db = new SQLite3('booking.sqlite');

$data = $db->query("select * from users where openid='123'");
$data = $data->fetchArray(SQLITE3_ASSOC);
var_dump($data);