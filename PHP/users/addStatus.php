<?php session_start();

$pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

$status = $_POST['select'];

// Create status USER
function status($status){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin;charset=UTF8", 'root', '');

  $id = $_REQUEST['id'];

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

  $sql = "UPDATE users SET status='$status' WHERE user_id = '$id'";
  $update = $pdo->prepare($sql);
  $update->execute();

  if ($status){
    create_session('status', '<strong>Уведомление!</strong> Данные успешно изменены');
    redirect("status.php?id=$id");
  }
}

// Создать СЕССИЮ
function create_session( $key, $message ){ $_SESSION["$key"] = $message; }
// Создать путь
function redirect($link){ header("Location: /$link"); exit(); }

status($status);