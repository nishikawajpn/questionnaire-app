<?php

namespace view\home;

function index($topics)
{
?>
  <ul class="topic-item-wrapper">
    <?php
    foreach ($topics as $topic) {
      \partials\topic_list_item($topic, 'detail');
    }
    ?>
  </ul>

<?php
}
