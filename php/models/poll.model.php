<?php
namespace model;

class PollModel extends AbstractModel {

  protected static $SESSION_NAME = '_poll';
  public $id;
  public $choice_id;
  public $topic_id;
  public $user_id;
  // public $nickname;
  // public $choice;
  public $del_flg;

  public static function validateId($val) {

    $res = true;

    if (empty($val) || !is_numeric($val)) {

      $res = false;

    }
    
    return $res;

  }

  public function isValidId() {

    return static::validateId($this->id);
    
  }
}