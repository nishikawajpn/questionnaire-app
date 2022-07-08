<?php
namespace controller\topic\archive;

use lib\Auth;
use lib\Msg;
use model\UserModel;
use db\TopicQuery;

function get() {

  Auth::requireLogin();

  $user = UserModel::getSession();
  $topics = TopicQuery::fetchByUserId($user);

  if ($topics === false) {
    Msg::push(Msg::ERROR, 'ログインしてください。');
    redirect('login');
  }

  if (count($topics) > 0) {

    \views\topic\archive\index($topics);

  } else {

    echo '<p>トピックを投稿してみましょう。</p>';

  }
}
