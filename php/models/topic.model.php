<?php
namespace model;

use lib\Msg;

class TopicModel extends AbstractModel {
  
  protected static $SESSION_NAME = '_topic';
  public $id;
  public $title;
  public $published;
  public $views;
  public $user_id;
  public $del_flg;

  public static function validateId($val) {

    $res = true;

    if (empty($val) || !is_numeric($val)) {

      Msg::push(Msg::ERROR, 'パラメータが不正です。');
      $res = false;

    }
    
    return $res;

  }

  public function isValidId() {

    return static::validateId($this->id);
    
  }

  public static function validateTitle($val) {
    
    $res = true;

    if (empty($val)) {

      $res = false;

    } else {

      if (mb_strlen($val) > 30) {

        $res = false;
        
      }
      
    }
    
    return $res;

  }

  public function isValidTitle() {

    return static::validateTitle($this->title);

  }

  public static function validatePublished($val) {
    
    $res = true;

    if (!isset($val)) {

      Msg::push(Msg::ERROR, '公開するか選択してください。');
      $res = false;
      
    } else {

      if (!($val == 0 || $val == 1)) {

        Msg::push(Msg::ERROR, '公開ステータスが不正です。');
        $res = false;
      }
    }

    return $res;
  }

  public function isValidPublished() {

    return static::validatePublished($this->published);

  }
  
}