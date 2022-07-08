<?php
namespace view\register;

function index($user) {
?>

<form action="<?php echo CURRENT_URI ?>" method="POST" class="form--general validate-form" novalidate autocomplete="off">
  <h2 class="headint--large form--general__heading">新規登録</h2>
  <label for="id" class="form--general__label">ユーザーID</label>
  <input type="text" class="form--general__input-text validate-target" id="id" name="id" required minlength="4" maxlength="10" pattern="[a-zA-Z0-9]+" autofocus tabindex="1" value="<?php echo $user->id ?>">
  <div class="form__error-message invalid-feedback"></div>
  <label for="pwd" class="form--general__label">パスワード</label>
  <input type="password" class="form--general__input-text validate-target" id="pwd" name="pwd" required minlength="4" tabindex="2" pattern="[a-zA-z0-9]+" value="<?php echo $user->pwd ?>">
  <div class="form__error-message invalid-feedback"></div>
  <label for="nickname" class="form--general__label">ニックネーム</label>
  <input id="nickname" type="text" name="nickname" class="form--control form--general__input-text validate-target" required maxlength="10" tabindex="3" value="<?php echo $user->nickname ?>">
  <div class="form__error-message invalid-feedback"></div>
  <div class="form__buttons">
    <a href="<?php echo_url('login'); ?>" class="button button--text button--nml1-5rem">ログイン</a>
    <input type="submit" value="新規登録" tabindex="4" class="button button--emphasis">
  </div>
</form>

<?php
}
