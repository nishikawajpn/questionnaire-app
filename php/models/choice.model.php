<?php
namespace model;

use lib\Msg;

class ChoiceModel extends AbstractModel {

  protected static $SESSION_NAME = '_choices';
  public $id;
  public $body;
  public $topic_id;
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

  public static function validateBody($val)
  {
    $res = true;

    if (empty($val)) {

      $res = false;

    } else {

      if (mb_strlen($val) > 20) {

        $res = false;
        
      }
      
    }
    
    return $res;

  }

  public function isValidBody()
  {
    return static::validateBody($this->body);
  }

  public static function validateTopicId($val) {

    $res = true;

    if (empty($val) || !is_numeric($val)) {

      $res = false;

    }
    
    return $res;

  }

  public function isValidTopicId() {

    return static::validateTopicId($this->id);
    
  }
  
}