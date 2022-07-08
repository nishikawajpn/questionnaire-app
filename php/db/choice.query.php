<?php
namespace db;

use db\DataSource;
use model\ChoiceModel;
use model\TopicMOdel;

class ChoiceQuery {

  public static function fetchByTopicId($topic)
  {
    if (!$topic->isValidId()) {
      return false;
    }

    $db = new DataSource;
    $sql = 'SELECT *
      FROM `choices`
      WHERE topic_id = :id
      ORDER BY id;
    ';

    return $db->select($sql, [
      ':id' => $topic->id
    ], DataSource::CLS, ChoiceModel::class);
  }

  public static function fetchByTopicIdWithCount($topic)
  {
    if (!$topic->isValidId()) {
      return false;
    }

    $db = new DataSource;
    $sql = 'SELECT *
      FROM `choices` c
      LEFT JOIN (
        SELECT choice_id, COUNT(*) AS count
        FROM `poll`
        GROUP BY choice_id
        ) p
      ON c.id = p.choice_id
      WHERE c.topic_id = :id
      ORDER BY c.id;
    ';

    return $db->select($sql, [
      ':id' => $topic->id
    ], DataSource::CLS, ChoiceModel::class);
  }

  public static function update($choice, $body)
  {
    if (!$choice->isValidId()
        * ChoiceModel::validateBody($body)) {
      return false;
    }

    $db = new DataSource;
    $sql = 'UPDATE choices
            SET body = :choice_body
            WHERE id = :id;';

    return $db->execute($sql, [
      ':choice_body' => $body,
      ':id' => $choice->id
    ]);
  }

  public static function insert($choice) {

    if (!($choice->isValidBody()
        * TopicMOdel::validateId($choice->topic_id))) {
      return false;
    }

    $db = new DataSource;
    $sql = 'INSERT INTO `choices` (`body`, `topic_id`)
            VALUES (:body, :topic_id)';

    return $db->execute($sql, [
      ':body' => $choice->body,
      ':topic_id' => $choice->topic_id
    ]);
  }

  public static function delete($choice) {
    if (!($choice->isValidBody())) {
      return false;
    }

    $db = new DataSource;
    $sql = 'DELETE FROM `choices` WHERE id = :choice_id';

    return $db->execute($sql, [
      ':choice_id' => $choice->id
    ]);

  }

}
