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
    <title>cms - 子カテゴリ追加</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    try {

        require_once("../common/common.php");
        require_once("../common/local_settings.php");

        $post = sanitize($_POST);
        $name = $post["name"];
        $parent = $post["parent"];

        if (empty($name) === true) {
            print "メニュー名を入力して下さい。<br>";
            print "<a href='c_menu_add.php'>戻る</a>";
            exit();
        }

        $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
        $user = "root";
        $password = $db_password;
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT name FROM c_menu WHERE1";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        while (true) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($rec["name"]) === true) {
                break;
            }
            $c_name[] = $rec["name"];
        }

        if (empty($c_name) === false) {
            if (in_array($name, $c_name) === true) {
                print "すでに登録されている項目です。<br>";
                print "<a href='child_menu_add.php'>戻る</a>";
                exit();
            }
        }

        $sql = "SELECT id FROM p_menu WHERE name=?";
        $stmt = $dbh -> prepare($sql);
        $data[] = $parent;
        $stmt -> execute($data);

        $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
        $p_id = $rec["id"];
        $data = array();

        $sql = "INSERT INTO c_menu(p_id, name) VALUES(?, ?)";
        $stmt = $dbh->prepare($sql);
        $data[] = $p_id;
        $data[] = $name;
        $stmt->execute($data);

        $dbh = null;

    } catch (Exception $e) {
        print "異常が発生しました。<br>";
        print $e;
        print "<a href='cms_top.php'>cmsトップへ</a>";
    }
    ?>

    子メニューを追加しました。<br><br>
    <a href="child_menu_add.php">子メニュー一覧へ</a>
    <br>
    <a href="cms_top.php">トップメニューへ</a>

</body>

</html>
