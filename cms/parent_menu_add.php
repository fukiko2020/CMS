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
    <title>cms - 親カテゴリ追加</title>
</head>

<body>
    <?php
    try {
        $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
        $user = "root";
        $password = $db_password;
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT name FROM p_menu";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        $dbh = null;

        print "<h1>親メニュー一覧</h1>";

        while ($rec = $stmt -> fetch(PDO::FETCH_ASSOC)) {

            if (empty($rec) === true) {
                break;
            }
            print $rec["name"]."<br>";
            $p_name[] = $rec["name"];
        }
        if (empty($p_name) === true) {
            print "親カテゴリがありません";
        }
    } catch (Exception $e) {
        print "サーバーに異常が発生しました。<br>";
        print "<a href='cms_top.php'>cmsトップへ</a>";
        exit();
    }
    ?>

    <h2>親カテゴリ追加</h2>
    <form action="parent_menu_add_done.php" method="POST">
        <input type="text" name="name">
        <button type="submit" value="submit">追加</button>
    </form>
</body>

</html>
