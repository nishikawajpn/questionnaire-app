<?php
namespace view\topic\edit;

function index($topic, $choices, $from_create)
{
  $page_title = $from_create ? 'トピックの投稿' : 'トピックの編集';
  $choices = escape($choices);
?>

<form action="<?php echo CURRENT_URI ?>" method="POST" class="form--general form--general--wide validate-form">
  <h2 class="headint--large form--general__heading"><?php echo $page_title ?></h2>
  <input type="hidden" name="id" value="<?php echo $topic->id ?>">
  <label for="title" class="form--general__label">タイトル</label>
  <input type="text" class="form--general__input-text validate-target" id="title" name="title" value="<?php echo $topic->title ?>" required maxlength="30">
  <div class="form__error-message invalid-feedback"></div>

  <label for="published" class="form--general__label">公開・非公開</label>
  <select name="published" id="published" class="form--general__select">
    <option value="1" <?php echo $topic->published ? 'selected' : '' ?>>公開</option>
    <option value="0" <?php echo $topic->published ? '' : 'selected' ?>>非公開</option>
  </select>

  <?php
    $choice_num = 0;
    foreach($choices as $choice)
    {
      $choice_num++;
  ?>
  <label for="choice_<?php echo $choice_num ?>" class="form--general__label">選択肢 <?php echo $choice_num ?></label>
  <input type="text" class="form--general__input-text choices-validate-target" id="choice_<?php echo $choice_num ?>" name="choice_<?php echo $choice_num ?>" value="<?php echo $choice->body ?>">
  <?php }; ?>

  <?php
  for($i = $choice_num + 1; $i <= 10; $i++) {
  ?>
  <label for="choice" class="form--general__label">選択肢 <?php echo $i ?></label>
  <input type="text" class="form--general__input-text choices-validate-target" id="choice" name="choice_<?php echo $i ?>">
  <?php
  }
  ?>
  <div class="form__error-message choices-invalid-feedback"></div>

  <div class="form__buttons">
    <input type="submit" value="投稿する" class="button button--emphasis">
  </div>
</form>

<?php
}
