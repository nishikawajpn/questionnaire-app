<?php

namespace views\topic\archive;

function index($topics)
{
?>
  <h2 class="headint--large mb20">過去の投稿</h2>
  <ul class="topic-item-wrapper">
    <?php
    foreach ($topics as $topic) {
      \partials\topic_list_item($topic, 'edit');
    }
  ?>
</ul>
<?php
}
