<?php
session_start();
include 'connectdb.php';

$sql = "UPDATE user SET avatar=:avatar WHERE id = :id";
$params = [
  'avatar' => uniqid() . $_FILES['img']['name'],
  'id' => $_SESSION['uid']
];

$prepare = $conn->prepare($sql);
$prepare->execute($params);
move_uploaded_file($_FILES['img']['tmp_name'], 'uploads/avatars/' . $params['avatar']);

echo json_encode(['img' => $params['avatar']])

?>