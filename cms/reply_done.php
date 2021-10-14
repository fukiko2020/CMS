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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cms</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <?php
    try {

        require_once("../common/common.php");
        require_once("../common/local_settings.php");

        $post = sanitize($_POST);

        $name = $post["name"];
        $reply = $post["reply"];
        $post_id = $post["post_id"];
        print $post_id."←post_id";
        $id = $post["id"];


        $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
        $user = "root";
        $password = $db_password;
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE comment SET replied=? WHERE post_id=? && id=?";
        $stmt = $dbh->prepare($sql);
        $data[] = "1";
        $data[] = $post_id;
        $data[] = $id;
        $stmt->execute($data);
        $data = array();

        $sql = "INSERT INTO comment(name, content, post_id, replied) VALUES(?,?,?,?)";
        $stmt = $dbh->prepare($sql);
        $data[] = $name;
        $data[] = $reply;
        $data[] = $post_id;
        $data[] = "0";
        $stmt->execute($data);

        $dbh = null;
    } catch (Exception $e) {
        print "サーバーに異常が発生しました。<br>";
        print $e;
        print "<a href='cms_top.php'>cmsトップへ</a>";
    }
    ?>

    コメントを返信しました<br><br>
    <a href="cms_top.php">トップへ戻る</a>
</body>

</html>
