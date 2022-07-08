<?php
namespace controller\topic\create;

use model\TopicModel;
use model\UserModel;
use model\ChoiceModel;
use db\DataSource;
use db\TopicQuery;
use db\ChoiceQuery;
use lib\Auth;
use lib\Msg;
use Throwable;
use Error;

function get() {

  $topic = TopicModel::getSessionAndFlush();
  if (empty($topic)) {
    $topic = new TopicModel;
    $topic->id = -1;
    $topic->title = '';
    $topic->published = 1;
  }

  $choice_1 = new ChoiceModel;
  $choice_1->id = -1;
  $choice_1->body = '';
  $choice_1->topic_id = -1;

  $choice_2 = new ChoiceModel;
  $choice_2->id = -1;
  $choice_2->body = '';
  $choice_2->topic_id = -1;

  $choices = [$choice_1, $choice_2];

  \view\topic\edit\index($topic, $choices, true);

}

function post() {

  Auth::requireLogin();

  $topic = new TopicModel;
  $topic->id = get_param('id', null);
  $topic->title = get_param('title', null);
  $topic->published = get_param('published', null);

  try {

    $db = new DataSource;
    $db->begin();

    $user = UserModel::getSession();

    $topic->user_id = $user->id;
    
    list($is_insert_success, $lastInsertId) = TopicQuery::insert($topic);
    if (!$is_insert_success) {
      throw new Error;
    }

    for($i = 1; $i <= 10; $i++) {

      $choice = new ChoiceModel;
      $choice->body = get_param("choice_{$i}", null);
      $choice->topic_id = $lastInsertId;

      if ($choice->body === '') { continue; }
      if (!ChoiceQuery::insert($choice)) {
        throw new Error;
      }
    }

    $is_success = true;

  } catch (Throwable $e) {

    Msg::push(Msg::DEBUG, $e->getMessage());
    $is_success = false;

  }

  if ($is_success) {

    $db->commit();
    Msg::push(Msg::INFO, 'トピックの投稿に成功しました。');
    redirect('topic/archive');

  } else {

    $db->rollback();
    TopicModel::setSession($topic);
    Msg::push(Msg::ERROR, 'トピックの投稿に失敗しました。');
    redirect(GO_REFERER);

  }


}
