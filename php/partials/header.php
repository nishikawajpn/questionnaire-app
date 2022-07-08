<?php
namespace partials;

use lib\Msg;
use lib\Auth;

function header($dmetaData) {
?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $dmetaData['title'] ?></title>
    <meta name="author" content="Nishikawa">
    <meta name="description" content="<?php echo $dmetaData['description'] ?>">
    <link rel="shortcut icon" href="<?php echo BASE_IMAGE_PATH ?>/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_CSS_PATH; ?>style.css">
  </head>
  <body>
    <div id="container">
      <header class="header">
        <h1 class="header__title">
          <a href="<?php echo_url(GO_HOME) ?>" class="header__link">
            <img src="<?php echo BASE_IMAGE_PATH ?>logo.png" srcset="<?php echo BASE_IMAGE_PATH ?>logo.png 1x, <?php echo BASE_IMAGE_PATH ?>logo@2x.png 2x" alt="みんなのアンケート" width="220px" height="58px" class="header__logo">
          </a>
        </h1>
        <nav class="global-nav header__nav">
          <ul class="global-nav__li">
            <li class="global-nav__item"><a href="<?php echo_url(GO_HOME) ?>" class="button button--text">ホーム</a></li>
            <?php if (!Auth::isLogin()): ?>
            <li class="global-nav__item"><a href="<?php echo_url('login') ?>" class="button button--text">ログイン</a></li>
            <li class="global-nav__item"><a href="<?php echo_url('register') ?>" class="button button--emphasis">新規登録</a></li>
            <?php else: ?>
            <li class="global-nav__item"><a href="<?php echo_url('topic/create') ?>" class="button button--text">投稿</a></li>
            <li class="global-nav__item"><a href="<?php echo_url('topic/archive') ?>" class="button button--text">過去の投稿</a></li>
            <li class="global-nav__item"><a href="<?php echo_url('logout') ?>" class="button button--text">ログアウト</a></li>
            <?php endif; ?>
          </ul>
        </nav>
      </header>
      <main class="main">
        <div class="main-inner">
<?php
  Msg::flush();
}
