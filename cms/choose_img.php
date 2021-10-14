<?php

session_start();
session_regenerate_id(true);
if (isset($_SESSION["login"]) === false) {
    print "ログインしていません。<br><br>";
    print "<a href='login.php'>ログイン画面へ</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>cms - 画像選択</title>
    <link rel="stylesheet" href="setting/style2.css">
</head>

<body>

<?php
require_once("../common/local_settings.php");

$dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
$user = "root";
$password = $db_password;
$dbh = new PDO($dsn, $user, $password);
$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT name FROM img WHERE1";
$stmt = $dbh -> prepare($sql);
$stmt -> execute();

while (true) {
    $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
    if (empty($rec["name"]) === true) {
        break;
    }
    print "<img src='img/".$rec['name']."'>";
    print $rec["name"];
    print "<br>";
}

?>

</body>
</html>
