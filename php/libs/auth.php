<?php
namespace lib;

use db\UserQuery;
use db\TopicQuery;
use model\UserModel;
use Throwable;
use lib\Msg;

class Auth {

  public static function login($id, $pwd) {

    try {

      $is_success = false;
      $user = escape(UserQuery::fetchById($id));

      if (!empty($user) && $user->del_flg !== 1) {

        if(password_verify($pwd, $user->pwd)) {

          $is_success = true;
          Msg::push(Msg::INFO, "{$user->nickname}さん、こんにちは。");
          UserModel::setSession($user);

        } else {

          $is_success = false;
          Msg::push(Msg::ERROR, 'パスワードが一致しません。');

        }

      } else {

          $is_success = false;
          Msg::push(Msg::ERROR, 'ユーザーが存在しません。');

      }

    } catch (Throwable $e) {

      $is_success = true;
      Msg::push(Msg::ERROR, 'ログイン処理でエラーが発生しました。');
      Msg::push(Msg::DEBUG, $e->getMessage());

    }

    return $is_success;
  }

  public static function regist($user) {

    try {

      if (!($user->isValidId()
          * $user->isValidPwd()
          * $user->isValidNickname())) {
            return false;
          }

      $is_success = false;

      $exist_user = UserQuery::fetchById($user->id);

      if (!empty($exist_user)) {

        Msg::push(Msg::ERROR, 'すでにIDが登録されています。');
        return false;

      }

      if (UserQuery::insert($user)) {

        $is_success = true;
        $user = escape($user);
        Msg::push(Msg::INFO, "{$user->nickname}さん、ようこそ。");
        UserModel::setSession($user);

      }

    } catch (Throwable $e) {

      Msg::push(Msg::DEBUG, $e->getMessage());
      Msg::push(Msg::ERROR, 'ユーザー登録でエラーが発生しました。');
      $is_success = false;

    }

    return $is_success;
  }

  public static function isLogin() {

    try {

      $user = UserModel::getSession();

    } catch (Throwable $e) {

      UserModel::clearSession();
      Msg::push(Msg::DEBUG, $e->getMessage());
      return false;

    }

    if (isset($user)) {

      return true;

    } else {

      return false;

    }

  }

  public static function logout() {

    try {

      UserModel::clearSession();

    } catch (Throwable $e) {

      Msg::push(Msg::DEBUG, $e->getMessage());
      return false;

    }

    return true;

  }

  public static function requireLogin() {

    if (!static::isLogin()) {

      Msg::push(Msg::ERROR, 'ログインしてください。');
      redirect('login');

    }

  }

  public static function hasPermission($topic_id, $user) {

    return TopicQuery::isUserOwnTopic($topic_id, $user);

  }

  public static function requirePermission($topic_id, $user) {

    if (!static::hasPermission($topic_id, $user)) {

      Msg::push(Msg::ERROR, '編集権限がありません。ログインしてもう一度お試しください。');
      redirect('login');

    }

  }

}
