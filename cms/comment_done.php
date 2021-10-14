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
    <title>cms - コメント認証</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    try {
        require_once("../common/local_settings.php");

        $id = $_GET["id"];
        $post_id = $_GET["post_id"];

        $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
        $user = "root";
        $password = $db_password;
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_GET["flag"]) === true) {
            $sql = "DELETE FROM comment WHERE post_id=? && id=?";
            $stmt = $dbh->prepare($sql);
            $data[] = $post_id;
            $data[] = $id;
            $stmt->execute($data);

            $dbh = null;

            print "コメントを削除しました<br><br>";
            print "<a href='cms_top.php'>TOPへ戻る</a>";
            exit();
        }

        $sql = "SELECT * FROM comment WHERE id=?";
        $stmt = $dbh->prepare($sql);
        $data[] = $id;
        // $data[] = $post_id;
        $stmt->execute($data);
        $data = array();

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        // var_dump($rec);
        $name = $rec["name"];
        $content = $rec["content"];
        // $title = $rec["title"];
        $created_at = $rec["created_at"];

        $sql = "UPDATE comment SET permitted = 1 WHERE id = ?";
        $stmt = $dbh->prepare($sql);
        // $data[] = $name;
        // $data[] = $honbun;
        $data[] = $id;
        // $data[] = $title;
        // $data[] = $time;
        $stmt->execute($data);
        $data = array();

        // $sql = "DELETE FROM karicm WHERE id=? && code=?";
        // $stmt = $dbh->prepare($sql);
        // $data[] = $id;
        // $data[] = $code;
        // $stmt->execute($data);

        $dbh = null;

        print "コメントを認証しました。<br><br>";
        print "<a href='cms_top.php'>TOPへ戻る</a>";
    } catch (Exception $e) {
        print "サーバーに異常が発生しました。<br>";
        print "<a href='cms_top.php'>cmsトップへ</a>";
    }
    ?>

</body>

</html>
