<?php
//Table gerekenler Table name->users , kolon olarak id session_name ve session_value
session_start();
$dsn = 'mysql:host=localhost;dbname=script';
$user = 'root';
$password = '';

try {
    $db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Baglanti kurulamadi: ' . $e->getMessage();
  }

function login_kontrol($loginsayfasindami=0){
  global $db;
  if(isset($_SESSION['current_id'])){
  $id = $_SESSION['current_id'];
  $query = $db->query("SELECT * FROM users WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
  if ( $query ){
    $dbname= $query['session_name'];
    $dbvalue= $query['session_value'];
    if(!(isset($_COOKIE[$dbname]) and isset($_SESSION[$dbname]) )){
      //yanlis
      return bitir($loginsayfasindami);
    }
    else{
      if(($_COOKIE[$dbname]==$dbvalue && $_SESSION[$dbname]==$dbvalue)){ //Doğru giriş
        if($loginsayfasindami) header("Location:index.php");
      return setcookie($dbname,$dbvalue,time()+3600);
    }
    else{
      return bitir($loginsayfasindami);
    }
    }
}}
else{
  if(!$loginsayfasindami) {
    header('Location:login.php');
  }
  }
}


function bitir($loginsayfasindami=0){
  session_destroy();
  session_start();
  if(!$loginsayfasindami)
  header('Location:login.php');}

?>
