<?php

include './render-template.php';

header('Access-Control-Allow-Origin: *');

date_default_timezone_set('Europe/Moscow');

$start = microtime(true);


session_start();

function validate_coord($coord, $coord_name) {
  if (!isset($coord)) {
    return "Координата $coord_name не задана";
  } elseif (!is_numeric($coord)) {
    return "Координата $coord_name должна быть числом";
  }
  return "";
}

function validate_x_coord($coord, $coord_name) {
  $err = validate_coord($coord, $coord_name);
  if ($err) return $err;
  if (!in_array(floatval($coord), [-2, -1.5, -1, -0.5, 0, 0.5, 1, 1.5, 2])) {
    return "Координата $coord_name должна быть одной из чисел: { -2, -1.5, -1, -0.5, 0, 0.5, 1, 1.5, 2 }";
  }
  return "";
}

function validate_y_coord($coord, $coord_name) {
  $err = validate_coord($coord, $coord_name);
  if ($err) return $err;
  if ($coord <= -3 || $coord >= 5) {
    return "Координата $coord_name должна лежать в пределах (-3, 5)";
  }
  return "";
}

function validate_radius($radius) {
  if (!isset($radius)) {
    return "Радиус не задан";
  } elseif(!is_numeric($radius)) {
    return "Радиус должен быть числом";
  } elseif ($radius < 0) {
    return "Радиус не может быть отрицательным";
  } elseif (!in_array(floatval($radius), [1, 2, 3, 4, 5])) {
    return "Радиус должен быть одним из чисел: { 1, 2, 3, 4, 5 }";
  }
  return "";
}

function is_point_in_square($x, $y, $r) {
  return $x <= 0 && $x >= (-$r) && $y >= 0 && $y <= $r;
}

function is_point_in_triangle($x, $y, $r) {
  return $x >= 0 && $y >= 0 && ($x + $y - $r/2) <= 0;
}

function is_point_in_circle($x, $y, $r) {
  return $x <= 0 && $y <= 0 && ($x**2 + $y**2) <= $r**2;
}

function is_point_in_area($x, $y, $r) {
  return is_point_in_square($x, $y, $r) || is_point_in_triangle($x, $y, $r) || is_point_in_circle($x, $y, $r);
}


if (isset($_POST)) {
  $x = $_POST['x-coord'];
  $y = $_POST['y-coord'];
  $r = $_POST['r-param'];
  $errors = [
    validate_x_coord($x, 'X'),
    validate_y_coord($y, 'Y'),
    validate_radius($r, 'R'),
  ];
  foreach ($errors as $error) {
    if ($error !== '') {
      http_response_code(400);
      exit($error);
    }
  }

  if (!isset($_SESSION['hits'])) {
    $_SESSION['hits'] = [];
  }

  $exec_time = microtime(true) - $start;
  $current_time = date("H:i:s, Часовой пояс: T");

  $hit = array($x, $y, $r, is_point_in_area($x, $y, $r), $exec_time, $current_time);
  array_push($_SESSION['hits'], $hit);

  $table = renderTemplate('./templates/table.php', ['rows' => $_SESSION['hits']]);
  echo($table);
}