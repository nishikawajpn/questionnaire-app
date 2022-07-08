<?php
namespace db;

use db\DataSource;
use model\UserModel;

class UserQuery {

  public static function fetchById($id) {

    if (!(UserModel::validateId($id))) {
      return false;
    }

    $db = new DataSource;
    $sql = 'SELECT * FROM `users` WHERE id = :id;';

    return $db->selectOne($sql, [
      ':id' => $id
    ], DataSource::CLS, UserModel::class);
    
  }

  public static function insert($user) {

    if (!($user->isValidId()
        * $user->isValidPwd()
        * $user->isValidNickname())) {
      return false;
    }

    $db = new DataSource;
    $sql = 'INSERT INTO `users` (`id`, `pwd`, `nickname`) VALUES (:id, :pwd, :nickname);';

    $user->pwd = password_hash($user->pwd, PASSWORD_DEFAULT);
    
    return $db->execute($sql, [
      ':id' => $user->id,
      ':pwd' => $user->pwd,
      ':nickname' => $user->nickname,
    ]);
    
  }
  
}