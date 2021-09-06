<?php
session_start();

// DATA
$email = $_POST['email'];
$password = $_POST['password'];

// USER INFO
$name = $_POST['name'];
$position = $_POST['position'];
$phone = $_POST['phone'];
$address = $_POST['address'];

// LINKS
$vk = $_POST['vk'];
$telegram = $_POST['telegram'];
$instagram = $_POST['instagram'];

// STATUS
$status = $_POST['select'];

// FILES
$avatarName = $_FILES['avatar']['name'];
$avatarTmp = $_FILES['avatar']['tmp_name'];

// Проверить, существует ли такой Email
function get_userInfo($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin;charset=UTF8", 'root', '');

  $sql = "SELECT email, password FROM login WHERE email = :email";
  $select = $pdo->prepare($sql);
  $select->execute(['email' => "$email"]);

  $result = $select->fetch(PDO::FETCH_ASSOC);

//  Если Email пуст, вывести СООБЩЕНИЕ и ВЕРНУТЬ ОБРАТНО
  if (empty($email)) {
    create_session("error_againCreateUserPassword", "<strong>Уведомление!</strong> Вы не указали Email");
    redirect("create_user.php");
  }

//  Если такого EMAIL нет, то добавить пользователя
//  В противном случае ВЕРНУТЬ ОБРАТНО и ВЫВЕСТИ СООБЩЕНИЕ
  if (empty($result)){
    addData($email, $password);
  }else{
    create_session("error_createUserEmail", "<strong>Уведомление!</strong> Такой Email уже существует.");
  }

  create_session("create_user", "Профиль успешно обновлен.");
}

// Записать EMAIL и PASSWORD
// получить последний ID
function addData($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin;charset=UTF8", 'root', '');

  $sql = "INSERT INTO login(role, email, password) VALUES ('user', :email, :password)";
  $insert = $pdo->prepare($sql);

  if (!empty($password)){
    $insert->execute([ 'email' => $email, 'password' => md5($password)]);
    $user_id = $pdo->lastInsertId();

    create_session('user_id', "$user_id");
  }else{
    create_session("error_createUserPassword", "<strong>Уведомление!</strong> Вы не указали пароль");
    redirect("create_user.php");
  }
}

// Записать пользователя в БД
function addUser($name, $position, $phone, $address){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin;charset=UTF8", 'root', '');

  $sql = "INSERT INTO users(user_id, name, position, phone, address) VALUES ('". $_SESSION['user_id']."', :name, :position , :phone, :address)";
  $insert = $pdo->prepare($sql);

//  Проверить, не пусты ли ПОЛЯ ВВОДА
  if (!empty($name) OR !empty($position) OR !empty($phone) OR !empty($address)){
    $insert->execute(['name' => $name, 'position' => $position, 'phone' => $phone, 'address' => $address]);
  }else{
    create_session("error_addUser", "<strong>Уведомление!</strong> Вы не указали данные");
    redirect("create_user.php");
  }

}

// Create status USER
function status($status)
{
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin;charset=UTF8", 'root', '');

  switch ($status) {
    case 'Онлайн':
      $status = 'success';
      break;
    case 'Отошел':
      $status = 'warning';
      break;
    case 'Не беспокоить':
      $status = 'danger';
      break;
  }

  $sql = "UPDATE users SET status='$status' WHERE user_id='" . $_SESSION['user_id'] . "'";
  $update = $pdo->prepare($sql);
  $update->execute();
}

// Записать IMG в БД
function avatar($avatarName, $avatarTmp){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin;charset=UTF8", 'root', '');

  if (move_uploaded_file($avatarTmp, 'D:\OpenServer\OpenServer\domains\tasks2\img\demo\avatars' . '/' . $avatarName)){
    $sql = "UPDATE users SET img='img/demo/avatars/$avatarName' WHERE user_id='". $_SESSION['user_id'] ."'";
    $update = $pdo->prepare($sql);
    $update->execute();
  }
}

// Записать LINK
function addLinkUser($vk, $telegram, $instagram){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin;charset=UTF8", 'root', '');

  $sql = "INSERT INTO links(user_id, vk, telegram, instagram) VALUES ('". $_SESSION['user_id']."', :vk, :telegram, :instagram)";
  $insert = $pdo->prepare($sql);

//  Проверить, не пусты ли ПОЛЯ ВВОДА
  if (!empty($vk) OR !empty($telegram) OR !empty($instagram)){
    $insert->execute(['vk' => $vk, 'telegram' => $telegram, 'instagram' => $instagram]);
  }else{
    create_session("error_addUser", "<strong>Уведомление!</strong> Вы не указали данные");
    redirect("create_user.php");
  }

  redirect("users.php");
}

// Создать СЕССИЮ
function create_session( $key, $message ){ $_SESSION["$key"] = $message; }
// Создать путь
function redirect($link){ header("Location: /$link"); exit(); }

get_userInfo($email, $password);
addUser($name, $position, $phone, $address);
status($status);
avatar($avatarName, $avatarTmp);
addLinkUser($vk, $telegram, $instagram);
