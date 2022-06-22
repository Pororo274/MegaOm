<?php

// $host = 'localhost';
// $dbname = 'megaom';
// $user = 'root';
// $password = '';

$host = 'renovationidea.ru';
$dbname = 'u1550026_megaom';
$user = 'u1550026_taurus';
$password = 'taurus8888';

$conn = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', 
                $user, 
                $password, 
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

function insertPDO($table, $params) {
  global $conn;
  $sql = "INSERT INTO $table (";
  $tmp = [];

  foreach ($params AS $key => $value) {
    $tmp[count($tmp)] = $key;
  }
  $sql .= implode(',', $tmp);

  $sql .= ") VALUES (";
  $tmp = [];

  foreach ($params AS $key => $value) {
    $tmp[count($tmp)] = ':' . $key;
  }

  $sql .= implode(',', $tmp);

  $sql .= ")";
  
  $prepare = $conn->prepare($sql);
  
  return $prepare->execute($params);
}

function isExistPDO($table, $params) {
  global $conn;

  $sql = "SELECT COUNT(*) AS countVar FROM $table WHERE ";
  $tmp = [];

  foreach ($params AS $key => $value) {
    $tmp[count($tmp)] = $key . "=:" . $key;
  }

  $sql .= implode(' AND ', $tmp);
  $prepare = $conn->prepare($sql);
  $prepare->execute($params);
  $count = $prepare->fetch(PDO::FETCH_ASSOC);
  return $count['countVar'] > 0;
}