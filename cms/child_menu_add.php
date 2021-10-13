<?php
require_once("../common/local_settings.php");

session_start();
session_regenerate_id(true);
if (isset($_SESSION["login"]) === false) {
    print "ログインしていません。<br>";
    print "<a href='login.php'>ログイン画面へ</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cms - 子カテゴリ追加</title>
</head>

<body>
    <?php
    try {
        $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
        $user = "root";
        $password = $db_password;
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT p_menu.name AS p_name, c_menu.name AS c_name FROM p_menu INNER JOIN c_menu ON p_menu.id = c_menu.p_id;";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        // $dbh = null;

        print "<h1>子メニュー一覧</h1>";
        while ($rec = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (empty($rec["c_name"]) === true) {
                break;
            }
            print $rec["p_name"]." - ".$rec["c_name"]."<br>";
        }

        $sql = "SELECT name FROM p_menu";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        $dbh = null;



        print "<h2>親メニュー</h2>";

        while ($rec = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if (empty($rec["name"]) === true) {
                break;
            }
            print $rec["name"] . "<br>";
            $p_name[] = $rec["name"];
        }

        if (empty($p_name) === true) {
            print "親カテゴリがありません";
            exit();
        }

        print "親メニューを選択してください<br>";
        print "<form action='child_menu_add_done.php' method='POST'>";
        print "<select name='parent'>";

        $max = count($p_name);
        for ($i = 0; $i < $max; $i++) {
            print "<option value='".$p_name[$i]."'>".$p_name[$i]."</option>";
            print "<br>";
        }
        print "</select>";
        print "<br>";

    } catch (Exception $e) {
        print "サーバーに異常が発生しました。<br>";
        print "<a href='cms_top.php'>cmsトップへ</a>";
        exit();
    }
    ?>

    <h2>子カテゴリ追加</h2>
    <form action="child_menu_add_done.php" method="POST">
        <input type="text" name="name">
        <button type="submit" value="submit">追加</button>
    </form>
</body>

</html>
