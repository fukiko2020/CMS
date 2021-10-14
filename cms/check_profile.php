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
    <title>cms</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <aside>
        <?php
        try {

            require_once("../common/common.php");
            require_once("../common/local_settings.php");

            $post = sanitize($_POST);

            $name = $post["name"];
            $img = $_FILES["img"];
            $body = $post["body"];

            if (empty($name) === true or empty($img["name"]) === true or empty($body) === true) {
                print "プロフィール情報を全て入力して下さい";
                print "<form>";
                print "<input type='button' onclick='history.back()' value='戻る'>";
                print "</form>";
                exit();
            }

            move_uploaded_file($img["tmp_name"], "./img/" . $img["name"]);

            $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
            $user = "root";
            $password = $db_password;
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM profile WHERE1";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($rec["id"]) === true) {
                $sql = "INSERT INTO profile(name, img, body) VALUES(?,?,?)";
                $stmt = $dbh->prepare($sql);
                $data[] = $name;
                $data[] = $img["name"];
                $data[] = $body;
                $stmt->execute($data);

            } else {
                $sql = "UPDATE profile SET name=?, img=?, body=? WHERE id=?";
                $stmt = $dbh->prepare($sql);
                $data[] = $name;
                $data[] = $img["name"];
                $data[] = $body;
                $data[] = $rec["id"];
                $stmt->execute($data);
            }


            print "<h2>管理人</h2>";
            print "<div class='box'>";
            print "<h3>" . $name . "</h3>";
            print "<div class='img'>";
            print "<img src='img/" . $img['name'] . "'>";
            print "</div>";
            print $body;
            print "</div>";
        } catch (Exception $e) {
            print "サーバーに異常が発生しました。<br>";
            print "<a href='cms_top.php'>cmsトップへ</a>";
            exit();
        }
        ?>
        <br><br>
        上記内容で登録しました。
        <br><br>
        <a href="edit_profile.php">プロフィール作成画面へ戻る</a>
        <br>
        <a href="cms_top.php">トップメニューへ</a>
    </aside>
</body>

</html>
