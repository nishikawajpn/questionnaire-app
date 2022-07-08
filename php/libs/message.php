<?php
namespace lib;

use model\AbstractModel;
use Throwable;

class Msg extends AbstractModel{

  protected static $SESSION_NAME = '_message';
  public const INFO = 'info';
  public const ERROR = 'error';
  public const DEBUG = 'debug';


  public static function push($type, $msg) {

    if (!is_array(static::getSession())) {
      static::init();
    }

    $msgs = static::getSession();
    $msgs[$type][] = $msg;
    static::setSession($msgs);
  }

  public static function flush() {

    try {

      $msgs_with_type = static::getSessionAndFlush() ?? [];

      echo '<div id="messages">';

      foreach($msgs_with_type as $type => $msgs) {

        if ($type === static::DEBUG && !DEBUG) {
          continue;
        }

        $color = $type === static::INFO ? 'alert--info' : 'alert--error';

        foreach($msgs as $msg) {
          echo "<div class='alert $color'>$msg</div>";
        }

      }

      echo '</div>';

    } catch (Throwable $e) {



    }

  }

  private static function init() {

    static::setSession([
      static::ERROR => [],
      static::INFO => [],
      static::DEBUG => [],
    ]);

  }

}
