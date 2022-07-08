<?php
namespace view\topic\detail;

use lib\Auth;

function index($topic, $choices, $comments, $polledChoice, $sessionComment) {
  $polledChoiceId = !empty($polledChoice) ? $polledChoice->choice_id : '';
  $topic = escape($topic);
  $choices = escape($choices);
  $comments = escape($comments);

  $total_poll = $topic->count;
?>

<div class="content-area">
  <section class="choices-list__item">
    <h2 class="headint--large choices-list__heading"><?php echo $topic->title; ?></h2>
    <form action="<?php echo CURRENT_URI ?>" method="POST" class="" id="poll_btn">
      <input type="hidden" name="topic_id" value="<?php echo $topic->id ?>">
    </form>
    <ul class="choices-list <?php if(!empty($polledChoice)) { echo 'choices-list--polled'; } ?>">
      <?php
        foreach($choices as $choice) {
          $voteRate = !empty($polledChoice) ? num2per($choice->count, $total_poll) : '? ';
      ?>
      <li class="choices-list__item">
        <button type="submit" form="poll_btn" value="<?php echo $choice->id; ?>" name="choice_id" class="choices-list__button <?php if ($choice->id == $polledChoiceId) { echo 'selectedChoice'; } ?>" style="--rate: <?php echo $voteRate . '%' ?>">
          <p class="choices-list__label"><?php echo $choice->body; ?></p>
          <p class="choices-list__ratio <?php if(!empty($polledChoice)) { echo 'choices-list__ratio--visible'; } ?>"><?php echo $voteRate ?>%</p>
        </button>
      </li>
      <?php }; ?>
    </ul>
    <p class="section-poll__counter"><?php echo $total_poll ?> 票</p>
  </section>
  <section class="section-comment">
    <?php if (Auth::isLogin()): ?>
    <form action="<?php echo CURRENT_URI ?>" method="POST" class="form--comment validate-form" novalidate>
      <input type="hidden" name="topic_id" value="<?php echo $topic->id ?>">
      <textarea type="text" class="form--comment__textarea validate-target auto-adjust" name="comment_body" maxlength="140" placeholder="コメントを追加..." required><?php echo $sessionComment->body ?></textarea>
      <div class="form__error-message invalid-feedback"></div>
      <div class="form__buttons form__buttons--right-justified">
        <input type="submit" value="コメント" class="button button--emphasis">
      </div>
    </form>
    <?php else: ?>
      <a href="<?php echo_url('login') ?>" class="button button--emphasis mb25">ログインしてコメントする</a>
    <?php endif; ?>
    <ul class="comments-list">
      <?php foreach($comments as $comment): ?>
      <li class="comments-list__item">
        <span class="comments-list__nickname"><?php echo $comment->nickname; ?></span>
        <span class="comments-list__body"><?php echo $comment->body; ?></span>
      </li>
      <?php endforeach; ?>
    </ul>
  </section>
</div>
<!-- <script>
document.querySelectorAll(".auto-adjust").forEach(function(){
  this.addEventListener('input',function(e){
    e.srcElement.style.height = 0;
    e.srcElement.style.height = e.srcElement.scrollHeight+"px";
  })
})
</script> -->
<?php
}
