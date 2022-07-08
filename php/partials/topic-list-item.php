<?php
namespace partials;

function topic_list_item($topic, $destination) {
  $topic = escape($topic);
  $polledCount = $topic->count !== '' ? $topic->count : 0;
?>
<li class="topic-item">
  <a href="<?php echo echo_url('topic/' . $destination . '?topic_id=' . $topic->id) ?>" class="topic-item__link">
    <p class="topic-item__title"><?php echo $topic->title ?></p>
    <div class="topic-counter-wrapper">
      <span class="topic-counter topic-counter--votes">
        <span class="topic-counter__number"><?php echo $polledCount ?></span>
        <span class="topic-counter__unit">投票数</span>
      </span>
      <span class="topic-counter topic-counter--views">
        <span class="topic-counter__number"><?php echo $topic->views ?></span>
        <span class="topic-counter__unit">ビュー数</span>
      </span>
    </div>
  </a>
</li>

<?php
}
