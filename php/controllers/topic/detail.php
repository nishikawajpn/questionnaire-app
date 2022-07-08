<?php
namespace controller\topic\detail;

use model\TopicModel;
use model\CommentModel;
use model\UserModel;
use model\PollModel;
use db\TopicQuery;
use db\ChoiceQuery;
use db\CommentQuery;
use db\PollQuery;
use lib\Auth;
use lib\Msg;

function get() {

  $topic = new TopicModel;
  $topic->id = get_param('topic_id', null, false);

  TopicQuery::incrementViewCount($topic);

  $fetchedTopic = TopicQuery::fetchById($topic);
  if (empty($fetchedTopic) || !$fetchedTopic->published) {
    Msg::push(Msg::ERROR, 'トピックが見つかりません。');
    redirect('404');
  }
  $choices = ChoiceQuery::fetchByTopicIdWithCount($topic);
  $comments = CommentQuery::fetchByTopicId($topic);

  $user = UserModel::getSession() ?? new UserModel;
  $polledChoice = PollQuery::polledChoice($topic->id, $user);

  $sessionComment = CommentModel::getSessionAndFlush();
  if (empty($sessionComment)) {
    $sessionComment = new CommentModel;
    $sessionComment->body = '';
  }

  \view\topic\detail\index($fetchedTopic, $choices, $comments, $polledChoice, $sessionComment);


}

function post() {

  Auth::requireLogin();

  $user = UserModel::getSession();
  $topic_id = get_param('topic_id', null);

  $poll = new PollModel;
  $poll->choice_id = get_param('choice_id', null);
  $poll->topic_id = $topic_id;
  $poll->user_id = $user->id;

  $comment = new CommentModel;
  $comment->body = get_param('comment_body', null);
  $comment->topic_id = $topic_id;
  $comment->user_id = $user->id;

  if (isset($poll->choice_id)) {

    $polledChoice = PollQuery::polledChoice($topic_id, $user);

    if (!empty($polledChoice)) {

      PollQuery::deletePolledChoice($polledChoice);

    }

    if ($polledChoice->choice_id == $poll->choice_id) {

      PollQuery::deletePolledChoice($polledChoice);

    } else {

      PollQuery::insert($poll);

    }

  } else {

    if (!CommentQuery::insert($comment)) {
      CommentModel::setSession($comment);
    } else {
      Msg::push(Msg::INFO, 'コメントに成功しました。');
    }

  }

  redirect(GO_REFERER);

}
