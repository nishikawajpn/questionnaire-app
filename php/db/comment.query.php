<?php
namespace db;

use db\DataSource;
use model\CommentModel;
use model\TopicModel;
use model\UserModel;

class CommentQuery {

  public static function fetchByTopicId($topic)
  {
    if (!($topic->isValidId())) {
      return false;
    }

    $db = new DataSource;
    $sql = 'SELECT c.*, u.nickname
      FROM `comments` c
      LEFT JOIN `users` u
      ON c.user_id = u.id
      WHERE c.topic_id = :topic_id
      AND c.del_flg != 1
      ORDER BY c.update_at DESC;
    ';

    return $db->select($sql, [
      ':topic_id' => $topic->id
    ], DataSource::CLS, CommentModel::class);
  }

  public static function insert($comment) {
    if (!($comment->isValidBody()
        * TopicModel::validateId($comment->topic_id)
        * UserModel::validateId($comment->user_id))) {
          return false;
        }

    $db = new DataSource;
    $sql = 'INSERT INTO `comments` (`body`, `topic_id`, `user_id`)
            VALUE (:body, :topic_id, :user_id);';

    return $db->execute($sql, [
      ':body' => $comment->body,
      ':topic_id' => $comment->topic_id,
      ':user_id' => $comment->user_id,
    ]);
    
  }
  
}