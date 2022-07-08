<?php

use libs\Msg;

function get_param($key, $default_val, $is_post = true) {

  $method = $is_post ? $_POST : $_GET;
  return $method[$key] ?? $default_val;

}

function redirect($path)
{
  if ($path === GO_HOME) {

    $path = get_url('');

  } else if ($path === GO_REFERER) {

    $path = $_SERVER['HTTP_REFERER'];

  } else {

    $path = get_url($path);

  }

  header('Location: ' . $path);
}

function echo_url($path) {

  echo get_url($path);

}

function get_url($path) {

  return BASE_CONTEXT_PATH . $path;

}

function is_half_alphanum($val) {

  return preg_match("/^[a-zA-Z0-9]+$/", $val);

}

function num2per($number, $total, $precision = 0) {

  if ($number <= 0 || $total <= 0) {
    return 0;
  }

  try {

    $percent = ($number / $total) * 100;
    return round($percent, $precision);

  } catch (Exception $e) {

    return 0;

  }
}

function escape($data) {
  if (is_array($data)) {

    foreach($data as $prop => $val) {
      $data[$prop] = escape($val);
    }
    return $data;

  } elseif (is_object($data)) {

    foreach($data as $prop => $val) {
      $data->$prop = escape($val);
    }
    return $data;

  } else {

    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

  }
}
