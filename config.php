<?php
define('CURRENT_URI', $_SERVER['REQUEST_URI']);
define('BASE_CONTEXT_PATH', '/questionnaire-app-main/');

define('BASE_IMAGE_PATH', BASE_CONTEXT_PATH . 'assets/img/');
define('BASE_JS_PATH', BASE_CONTEXT_PATH . 'assets/js/');
define('BASE_CSS_PATH', BASE_CONTEXT_PATH . 'assets/css/');
define('SOURCE_BASE', __DIR__ . '/php/');

define('GO_HOME', 'home');
define('GO_REFERER', 'referer');

define('DEBUG', true);

define('META_DATA', [
  'home' => [
    'title' => 'みんなのアンケート',
    'description' => '複数の選択肢から選ぶタイプのアンケートをつくったり、回答したりできます。'
  ],
  'login' => [
    'title' => 'ログイン | みんなのアンケート',
    'description' => '複数の選択肢から選ぶタイプのアンケートをつくったり、回答したりできます。'
  ],
  'register' => [
    'title' => '新規登録 | みんなのアンケート',
    'description' => '複数の選択肢から選ぶタイプのアンケートをつくったり、回答したりできます。'
  ],
  '404' => [
    'title' => '404 | みんなのアンケート',
    'description' => '複数の選択肢から選ぶタイプのアンケートをつくったり、回答したりできます。'
  ],
  'topic/archive' => [
    'title' => '過去の投稿 | みんなのアンケート',
    'description' => '複数の選択肢から選ぶタイプのアンケートをつくったり、回答したりできます。'
  ],
  'topic/detail' => [
    'title' => '回答ページ | みんなのアンケート',
    'description' => '複数の選択肢から選ぶタイプのアンケートをつくったり、回答したりできます。'
  ],
  'topic/edit' => [
    'title' => 'トピックの編集 | みんなのアンケート',
    'description' => '複数の選択肢から選ぶタイプのアンケートをつくったり、回答したりできます。'
  ],
  'topic/create' => [
    'title' => 'トピックの投稿 | みんなのアンケート',
    'description' => '複数の選択肢から選ぶタイプのアンケートをつくったり、回答したりできます。'
  ],
]);
