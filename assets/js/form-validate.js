validate_form();

function validate_form() {

  const $inputs = document.querySelectorAll('.validate-target');
  const $choice_inputs = document.querySelectorAll('.choices-validate-target');
  const $form = document.querySelector('.validate-form');
  if (!$form) { return; }

  let $inputtingChoices = $choice_inputs.length !== 0 ? [] : false;

  activateSubmitBtn($form, $inputtingChoices);

  for (const $input of $inputs) {
    $input.addEventListener('input', function(event) {
      activateSubmitBtn($form, $inputtingChoices);

      const $target = event.currentTarget;
      const $feedback = $target.nextElementSibling;
      if (!$feedback.classList.contains('invalid-feedback')) { return; }

      if ($target.checkValidity()) {

        $target.classList.add('is-valid');
        $target.classList.remove('is-invalid');
        $feedback.textContent = '';

      } else {

        $target.classList.add('is-invalid');
        $target.classList.remove('is-valid');

        if ($target.validity.valueMissing) {
          $feedback.textContent = '値の入力が必須です。';
        } else if ($target.validity.tooShort) {
          $feedback.textContent = $target.minLength + '文字以上で入力してください。現在の文字数は' + $target.value.length + '文字です。';
        } else if ($target.validity.tooLong) {
          $feedback.textContent = $target.maxLength + '文字以下で入力してください。現在の文字数は' + $target.value.length + '文字です。';
        } else if ($target.validity.patternMismatch) {
          $feedback.textContent = '半角英数字で入力してください。';
        }

      }
    })
  }

  for (const $choice_input of $choice_inputs) {

    if ($choice_input.value.length > 0) {
      $inputtingChoices.push($choice_input.name);
    }

    activateSubmitBtn($form, $inputtingChoices);

    $choice_input.addEventListener('input', function(event) {

      if (event.currentTarget.value.length > 0) {

        if($inputtingChoices.indexOf(event.currentTarget.name) === -1) {
          $inputtingChoices.push(event.currentTarget.name);
        }

      } else {
        $targetIndex = $inputtingChoices.findIndex((el) => el === event.currentTarget.name);
        $inputtingChoices.splice($targetIndex, 1);
      }

      activateSubmitBtn($form, $inputtingChoices);
      echoChoicesFeedback($inputtingChoices);

    })
  }
}

function activateSubmitBtn($form, $enoghChoices) {
  const $submitBtn = $form.querySelector('[type="submit"]');

  let isEnogh = false;
  if (Array.isArray($enoghChoices)) {
    isEnogh = $enoghChoices.length >= 2;
  } else {
    isEnogh = true;
  }

  if ($form.checkValidity() && isEnogh) {
    $submitBtn.removeAttribute('disabled');
  } else {
    $submitBtn.setAttribute('disabled', true);
  }
}

function echoChoicesFeedback($inputtingChoices) {
  let choices_feedback = document.querySelector('.choices-invalid-feedback')

  if ($inputtingChoices.length < 2) {
    choices_feedback.textContent = '選択肢は2つ以上入力してください。';
  } else {
    choices_feedback.textContent = '';
  }

}
