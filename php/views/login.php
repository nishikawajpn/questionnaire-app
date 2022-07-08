<?php
namespace view\login;

function index() {
?>

<form action="<?php echo CURRENT_URI ?>" method="POST" class="form--general validate-form" novalidate autocomplete="off">
  <h2 class="headint--large form--general__heading">ログイン</h2>
  <label for="id" class="form--general__label">ユーザーID</label>
  <input type="text" class="form--general__input-text validate-target" id="id" name="id" required minlength="4" maxlength="10" pattern="[a-zA-Z0-9]+" autofocus tabindex="1">
  <div class="form__error-message invalid-feedback"></div>
  <label for="pwd" class="form--general__label">パスワード</label>
  <input type="password" class="form--general__input-text validate-target" id="pwd" name="pwd" required minlength="4" pattern="[a-zA-Z0-9]+" tabindex="2">
  <div class="form__error-message invalid-feedback"></div>
  <div class="form__buttons">
    <a href="<?php echo_url('register'); ?>" class="button button--text button--nml1-5rem">アカウント登録</a>
    <input type="submit" value="ログイン" tabindex="3" class="button button--emphasis">
  </div>
</form>

<?php
}
