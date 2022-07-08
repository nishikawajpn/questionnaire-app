<?php
namespace db;

use db\DataSource;
use model\TopicModel;

class TopicQuery {

  public static function fetchPublishedTopics() {

    $db = new DataSource;
    $sql = 'SELECT *
      FROM `topics` t
      LEFT JOIN (SELECT topic_id, COUNT(*) as count
                  FROM `poll`
                  GROUP BY topic_id) p
        ON t.id = p.topic_id
      WHERE t.published = 1
        AND t.del_flg != 1
      ORDER BY t.id DESC;
    ';

    return $db->select($sql, [], DataSource::CLS, TopicModel::class);
  }

  public static function fetchById($topic) {

    if (!$topic->isValidId()) {
      return false;
    }

    $db = new DataSource;
    $sql = 'SELECT *
      FROM `topics` t
      LEFT JOIN (SELECT topic_id, COUNT(*) as count
                  FROM `poll`
                  GROUP BY topic_id) p
        ON t.id = p.topic_id
      WHERE t.id = :id
      AND t.del_flg != 1;';

    return $db->selectOne($sql, [
      ':id' => $topic->id
    ], DataSource::CLS, TopicModel::class);

  }

  public static function fetchByUserId($user) {

    if (!$user->isValidId()) {
      return false;
    }

    $db = new DataSource;
    $sql = 'SELECT *
      FROM `topics` t
      LEFT JOIN (
        SELECT topic_id, COUNT(*) AS count
        FROM `poll`
        WHERE del_flg != 1
        GROUP BY topic_id
        ) p
      ON t.id = p.topic_id
      WHERE t.user_id = :user_id
      AND t.del_flg != 1
      ORDER BY t.id DESC;';

    return $db->select($sql, [
      ':user_id' => $user->id
    ], DataSource::CLS, TopicModel::class);

  }

  public static function isUserOwnTopic($topic_id, $user) {

    if (!(TopicModel::validateId($topic_id)
        * $user->isValidId())) {
      return false;
    }

    $db = new DataSource;
    $sql = 'SELECT COUNT(*)
      FROM `topics`
      WHERE id = :topic_id
      AND user_id = :user_id;';

    $result = $db->selectOne($sql, [
      ':topic_id' => $topic_id,
      ':user_id' => $user->id
    ], DataSource::CLS, TopicModel::class);

    if (isset($result)) {
      return true;
    } else {
      return false;
    }
  }

  public static function update($topic) {

    if (!($topic->isValidId()
        * $topic->isValidTitle()
        * $topic->isValidPublished())) {
          return false;
        }

    $db = new DataSource;
    $sql = 'UPDATE `topics`
      SET title = :title,
          published = :published
      WHERE id = :id;';

    return $db->execute($sql, [
      ':id' => $topic->id,
      ':title' => $topic->title,
      ':published' => $topic->published,
    ]);
  }

  public static function insert($topic) {

    if (!($topic->isValidId()
        * $topic->isValidTitle()
        * $topic->isValidPublished())) {
          return false;
        }

    $db = new DataSource;
    $sql = 'INSERT INTO `topics`(`title`, `published`, `user_id`)
            VALUES (:title, :published, :user_id);';

    $is_success =  $db->execute($sql, [
      ':title' => $topic->title,
      ':published' => $topic->published,
      ':user_id' => $topic->user_id
    ]);

    $lastInsertId = $db->getLastInsertId();

    return array ($is_success, $lastInsertId);

  }

  public static function incrementViewCount($topic)
  {
    $db = new DataSource;
    $sql = 'UPDATE `topics`
            SET views = views + 1
            WHERE id = :id;';

    return $db->execute($sql, [
      ':id' => $topic->id
    ]);
  }

}
