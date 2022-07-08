<?php
namespace model;

use lib\Msg;

class CommentModel extends AbstractModel {

  protected static $SESSION_NAME = '_comment';
  public $id;
  public $body;
  public $topic_id;
  public $user_id;
  public $nickname;
  public $del_flg;

  public static function validateBody($val) {
    $res = true;

    if (empty($val)) {

      $res = false;

    } else {

      if (mb_strlen($val) > 140) {

        $res = false;
        Msg::push(Msg::ERROR, 'コメントは140文字以内で入力してください。');

      }

    }

    return $res;
  }

  public function isValidBody() {
    return static::validateBody($this->body);
  }

}
