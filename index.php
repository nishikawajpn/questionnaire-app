<?php

require_once 'config.php';

// Library
require_once SOURCE_BASE . 'libs/helper.php';
require_once SOURCE_BASE . 'libs/router.php';
require_once SOURCE_BASE . 'libs/auth.php';

// Model
require_once SOURCE_BASE . 'models/abstract.model.php';
require_once SOURCE_BASE . 'models/user.model.php';
require_once SOURCE_BASE . 'models/topic.model.php';
require_once SOURCE_BASE . 'models/choice.model.php';
require_once SOURCE_BASE . 'models/poll.model.php';
require_once SOURCE_BASE . 'models/comment.model.php';

// Message
require_once SOURCE_BASE . 'libs/message.php';

// DB
require_once SOURCE_BASE . 'db/datasource.php';
require_once SOURCE_BASE . 'db/user.query.php';
require_once SOURCE_BASE . 'db/topic.query.php';
require_once SOURCE_BASE . 'db/choice.query.php';
require_once SOURCE_BASE . 'db/poll.query.php';
require_once SOURCE_BASE . 'db/comment.query.php';

// Partials
require_once SOURCE_BASE . 'partials/header.php';
require_once SOURCE_BASE . 'partials/footer.php';
require_once SOURCE_BASE . 'partials/topic-list-item.php';

// View
require_once SOURCE_BASE . 'views/home.php';
require_once SOURCE_BASE . 'views/login.php';
require_once SOURCE_BASE . 'views/register.php';
require_once SOURCE_BASE . 'views/topic/detail.php';
require_once SOURCE_BASE . 'views/topic/archive.php';
require_once SOURCE_BASE . 'views/topic/edit.php';


use function lib\route;

session_start();

try {

  $url = parse_url(CURRENT_URI);
  $rpath = str_replace(BASE_CONTEXT_PATH, '', $url['path']);
  $method = strtolower($_SERVER['REQUEST_METHOD']);
  $dmetaData = META_DATA[$rpath] ?? [
    'title' => 'みんなのアンケート',
    'description' => '複数の選択肢から選ぶタイプのアンケートをつくったり、回答したりできます。'
  ];

  \partials\header($dmetaData);

  route($rpath, $method);

  \partials\footer();

} catch(Throwable $e) {

  die('<p>何かが凄くおかしいようです。</p>');

}
