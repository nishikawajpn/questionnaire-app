<?php
namespace controller\topic\edit;

use model\TopicModel;
use model\UserModel;
use db\DataSource;
use db\TopicQuery;
use db\ChoiceQuery;
use lib\Auth;
use lib\Msg;
use model\ChoiceModel;
use Throwable;
use Error;

function get() {
  
  $topic = new TopicModel;
  $topic->id = get_param('topic_id', null, false);
  
  $fetchedTopic = TopicQuery::fetchById($topic);
  $choices = ChoiceQuery::fetchByTopicId($topic);

  // var_dump($choices);

  \view\topic\edit\index($fetchedTopic, $choices, false);
  
}

function post() {

  Auth::requireLogin();

  $topic = new TopicModel;
  $topic->id = get_param('id', null);
  $topic->title = get_param('title', null);
  $topic->published = get_param('published', null);

  $user = UserModel::getSession();
  Auth::requirePermission($topic->id, $user);

  try {

    $db = new DataSource;

    $db->begin();
  
    if (!TopicQuery::update($topic)) { 
      throw new Error;
    }
  
    $choices = ChoiceQuery::fetchByTopicId($topic);
  
    $choice_num = 0;
    
    foreach ($choices as $choice) {
  
      $choice_num++;
      $body = get_param("choice_{$choice_num}", null);
  
      if (empty($body)) {
  
        if (!ChoiceQuery::delete($choice)) { 
          throw new Error;
        }
  
      } else {
  
        if (!ChoiceQuery::update($choice, $body)) { 
          throw new Error;
        }
        
      }

    }
  
    for($i = $choice_num + 1; $i <= 10; $i++) {
  
      $choice_body = get_param("choice_{$i}", null);
  
      if (empty($choice_body)) {
        continue;
      }
  
      $choice = new ChoiceModel;
      $choice->topic_id = $topic->id;
      $choice->body = $choice_body;
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
    Msg::push(Msg::INFO, 'トピックの更新に成功しました。');
    redirect('topic/archive');

  } else {
    
    $db->rollback();
    Msg::push(Msg::INFO, 'トピックの更新に失敗しました。');
    redirect(GO_REFERER);

  }

}