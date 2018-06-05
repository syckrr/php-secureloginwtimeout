<?php
include("include.php");
if(isset($_POST["cikis"])){
  session_destroy();
  session_start();
  header("location:login.php");
}
login_kontrol(1);
 ?>
<html>
<body>

<form action="" method="post"><center>
  <input type="text" name="kod" placeholder="Giriş Kodunuz"></input>
  <input type="submit" name="giris"></input>  </center>


<?php
//COOKIE - SESSION
if(isset($_POST["giris"])){
  $kod = $_POST['kod'];
$query = $db->query("SELECT * FROM users WHERE kod = '{$kod}'")->fetch(PDO::FETCH_ASSOC);
if ( $query ){
    session_destroy();
    session_start();

    $hash1 = md5(rand(0,9999)+rand(0,9999));
    $hash2 = md5(rand(0,9999)+rand(0,9999));
    $exe = $db->exec("UPDATE users set session_name='$hash1',session_value='$hash2' WHERE kod = '{$kod}'");
    if($exe){
      $_SESSION["current_id"]=$query["id"];
      $_SESSION[$hash1]=$hash2;
      setcookie($hash1,$hash2,time()+3600);
      header('Location:index.php');
    }
    else{
      echo "Sunucuyla kontak kurarken bir hata meydana geldi, Lütfen daha sonra tekrar deneyiniz.";
      header('Refresh:5;login.php');
    }

}
else {
  echo "Yanlis bilgi girimi";
}
}
?>

</body>
</html>
