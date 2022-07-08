<?php
namespace db;

use db\DataSource;
use model\PollModel;
use model\ChoiceModel;
use model\TopicModel;
use model\UserModel;

class PollQuery {

  public static function insert($poll)
  {
    if (!(ChoiceModel::validateId($poll->choice_id)
        * TopicModel::validateId($poll->topic_id)
        * UserModel::validateId($poll->user_id))) {
          return false;
        }
    
    $db = new DataSource;
    $sql = 'INSERT INTO `poll` (`choice_id`, `topic_id`, `user_id`)
            VALUES (:choice_id, :topic_id, :user_id);';

    return $db->execute($sql, [
      ':choice_id' => $poll->choice_id,
      ':topic_id' => $poll->topic_id,
      ':user_id' => $poll->user_id,
    ]);
  }

  public static function polledChoice($topic_id, $user) {

    if (!(TopicModel::validateId($topic_id)
        * $user->isValidId())) {
          return false;
        }

    $db = new DataSource;
    $sql = 'SELECT *
            FROM `poll`
            WHERE topic_id = :topic_id
            AND user_id = :user_id;';

    return $db->selectOne($sql, [
      ':topic_id' => $topic_id,
      ':user_id' => $user->id,
    ], DataSource::CLS, PollModel::class);
    
  }

  public static function deletePolledChoice($polledChoice) {

    if (!$polledChoice->isValidId()) {
      return false;
    }

    $db = new DataSource;
    $sql = 'DELETE FROM `poll` 
            WHERE id = :id;';

    return $db->execute($sql, [
      ':id' => $polledChoice->id
    ]);
    
  }
  
}