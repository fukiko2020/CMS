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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cms</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php
    try {

        require_once("../common/common.php");
        require_once("../common/local_settings.php");

        $post = sanitize($_POST);
        $name = $post["name"];

        if (empty($name) === true) {
            print "メニュー名を入力して下さい。<br>";
            print "<a href='p_menu_add.php'>戻る</a>";
            exit();
        }

        $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
        $user = "root";
        $password = $db_password;
        $dbh = new PDO($dsn, $user, $password);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT name FROM p_menu WHERE1";
        $stmt = $dbh->prepare($sql);
        $stmt -> execute();

        while (true) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($rec["name"]) === true) {
                break;
            }
            $p_name[] = $rec["name"];
        }

        if (empty($p_name) === false) {
            if (in_array($name, $p_name) === true) {
                print "すでに登録されている項目です。<br>";
                print "<a href='p_menu_add.php'>戻る</a>";
                exit();
            }
        }

        $sql = "INSERT INTO p_menu(name) VALUES(?)";
        $stmt = $dbh->prepare($sql);
        $data[] = $name;
        $stmt -> execute($data);

        $dbh = null;

    } catch (Exception $e) {
        print "サーバーに異常が発生しました。<br>";
        print $e;
        print "<a href='cms_top.php'>cmsトップへ</a>";
    }
    ?>

    親メニューを追加しました。<br><br>
    <a href="p_menu_add.php">親メニューへ</a>
    <br>
    <a href="cms_top.php">トップメニューへ</a>

</body>

</html>
