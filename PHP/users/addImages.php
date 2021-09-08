<?php session_start();

// FILES
$avatarName = $_FILES['avatar']['name'];
$avatarTmp = $_FILES['avatar']['tmp_name'];

// Записать IMG в БД
function avatar($avatarName, $avatarTmp){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin;charset=UTF8", 'root', '');

  $id = $_REQUEST['id'];

  if (empty($avatarName) AND empty($avatarTmp)){
    $sql = "UPDATE users SET img='img/demo/avatars/avatar-m.png' WHERE user_id='$id'";
    $update = $pdo->prepare($sql);
    $update->execute();
  }

  if (move_uploaded_file($avatarTmp, 'D:\OpenServer\OpenServer\domains\tasks2\img\demo\avatars' . '/' . $avatarName)){
    create_session('img_true', '<strong>Уведомление!</strong> Аватар успешно изменён');

    $sql = "UPDATE users SET img='img/demo/avatars/$avatarName' WHERE user_id='$id'";
    $update = $pdo->prepare($sql);
    $update->execute();
  }

  redirect("media.php?id=$id");
}

// Создать СЕССИЮ
function create_session( $key, $message ){ $_SESSION["$key"] = $message; }
// Создать путь
function redirect($link){ header("Location: /$link"); exit(); }

avatar($avatarName, $avatarTmp);