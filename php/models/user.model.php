<?php
namespace model;

class UserModel extends AbstractModel {

  protected static $SESSION_NAME = '_user';

  public $id;
  public $pwd;
  public $nickname;

  public static function validateId($val) {

    $res = true;

    if (empty($val)) {

      $res = false;

    } else {

      if (strlen($val) > 10) {
        $res = false;
      }

      if (!is_half_alphanum($val)) {
        $res = false;
      }
      
    }

    return $res;
  }

  public function isValidId() {
    return static::validateId($this->id);
  }

  public static function validatePwd($val) {

    $res = true;

    if (empty($val)) {

      $res = false;
      
    } else {

      if (strlen($val) > 40) {
        $res = false;
      }

      if (!is_half_alphanum($val)) {
        $res = false;
      }
    }
    
    return $res;
  }

  public function isValidPwd() {
    return static::validatePwd($this->pwd);
  }

  public static function validateNickname($val) {

    $res = true;

    if (empty($val)) {

      $res = false;

    } else {

      if (mb_strlen($val) > 10) {
        $res = false;
      }

    }
    
    return $res;
  }

  public function isValidNickname() {
    return static::validateNickname($this->nickname);
  }
  
}