<?php
namespace controller\register;

use model\UserModel;
use lib\Auth;

function get() {

  $user = UserModel::getSessionAndFlush();
  if (empty($user)) {
    $user = new UserModel;
    $user->id = '';
    $user->pwd = '';
    $user->nickname = '';
  }
  
  \view\register\index($user);
  
}

function post() {

  $user = new UserModel;
  $user->id = get_param('id', null);
  $user->pwd = get_param('pwd', null);
  $user->nickname = get_param('nickname', null);

  if (Auth::regist($user)) {

    redirect(GO_HOME);
    
  } else {

    UserModel::setSession($user);
    redirect(GO_REFERER);
    
  }
  
}