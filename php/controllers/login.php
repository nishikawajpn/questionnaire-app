<?php
namespace controller\login;

use lib\Auth;

function get() {

  \view\login\index();
  
}

function post() {

  $id = get_param('id', null);
  $pwd = get_param('pwd', null);

  if (Auth::login($id, $pwd)) {

    redirect(GO_HOME);
    
  } else {

    redirect(GO_REFERER);
    
  }


}