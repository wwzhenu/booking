<?php
/**
 * Created by PhpStorm.
 * User: wangtian
 * Date: 2018/12/10
 * Time: 4:05 PM
 */

namespace App\Http\Controllers;


use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $userService )
    {
        $this->service = $userService;
    }

    public function getUserInfo(Request $request)
    {
        $this->service->getUserInfo($request->all());
    }

}