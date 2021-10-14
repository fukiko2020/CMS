<?php

session_start();
session_regenerate_id(true);
if (isset($_SESSION["login"]) === false) {
    print "ログインしていません。<br><br>";
    print "<a href='set_login.php'>ログイン画面へ</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>cms - 投稿完了</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

    <?php
    require_once("../common/local_settings.php");

    try {

        $category = $_POST["category"];
        $title = $_POST["title"];
        $content = $_POST["content"];
        $img = $_POST["img"];

        $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
        $user = "root";
        $password = $db_password;
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO post(category, title, content, img) VALUES(?,?,?,?)";
        $stmt = $dbh->prepare($sql);
        $data[] = $category;
        $data[] = $title;
        $data[] = $content;
        $data[] = $img;
        $stmt->execute($data);
    } catch (Exception $e) {
        print "只今障害が発生しております。<br><br>";
        print $e;
        print "<a href='login.html'>ログイン画面へ</a>";
    }
    ?>

    記事を登録しました。
    <br><br>
    <a href="edit_post.php">記事投稿ページへ戻る</a>
    <a href="cms_top.php">トップメニューへ</a>

</body>

</html>
