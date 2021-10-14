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
    <title>cms - 画像アップロード</title>
    <link rel="stylesheet" href="setting/style2.css">
</head>

<body>
    <?php
    require_once("../common/local_settings.php");

    $img = $_FILES["image_data"];
    $max = count($img["name"]);

    foreach ($img["tmp_name"] as $key => $value) {
        $tmp_name[] = $value;
    }

    foreach ($img["name"] as $key => $value) {
        $name[] = $value;
    }

    for ($i = 0; $i < $max; $i++) {
        move_uploaded_file($tmp_name[$i], "img/".$name[$i]);
    }

    $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
    $user = "root";
    $password = $db_password;
    $dbh = new PDO($dsn, $user, $password);
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    for ($i = 0; $i < $max; $i++) {
        $sql = "INSERT INTO img(name) VALUES(?)";
        $stmt = $dbh -> prepare($sql);
        $data[] = $name[$i];
        $stmt -> execute($data);
        $data = array();
    }

    print "画像をアップロードしました";
    ?>
</body>
</html>
