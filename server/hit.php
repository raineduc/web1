<?php

include './render-template.php';

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

function validate_radius($radius) {
  if (!isset($radius)) {
    return "Радиус не задан";
  } elseif(!is_numeric($radius)) {
    return "Радиус должен быть числом";
  } elseif ($radius < 0) {
    return "Радиус не может быть отрицательным";
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
    validate_coord($x, 'X'),
    validate_coord($y, 'Y'),
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