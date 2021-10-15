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
    <title>cms - コメント認証・削除</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    try {

        require_once("../common/local_settings.php");

        $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
        $user = "root";
        $password = $db_password;
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT comment.id AS id, comment.post_id AS post_id, comment.name AS name, comment.content AS content, comment.created_at AS created_at, comment.permitted AS permitted, post.title AS post_title FROM comment LEFT OUTER JOIN post ON comment.post_id = post.id WHERE comment.permitted = 0";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        // var_dump($rec);

        if (empty($rec["name"]) === true) {
            print "認証待ちのコメントはありません。<br><br>";
            print "<input type='button' onclick='history.back()' value='戻る'>";
            print "</form>";
            exit();
        }
        print "以下のコメントが認証待ちになっています。<br><br>";
        $title_untaged = strip_tags($rec["post_title"]);
        print $title_untaged. " に対するコメント<br>";
        print "投稿日時: ".$rec["created_at"];
        print "<br>";
        print "投稿者: ".$rec["name"];
        print "<br>";
        print "コメント: ".$rec["content"];
        print "<br><br>";
        print "<a href='comment_done.php?post_id=" . $rec['post_id'] . "&id=" . $rec['id'] . "'>";
        print "認証する</a>";
        print "<br><br>";
        print "<a href='comment_done.php?post_id=" . $rec['post_id'] . "&id=" . $rec['id'] . "&flag=1'>";
        print "削除する</a>";
        print "<br><br>";

        while (true) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($rec["name"]) === true) {
                break;
            }
            print $rec["post_title"] . " に対するコメント<br>";
            print $rec["created_at"];
            print "<br>";
            print $rec["name"];
            print "<br>";
            print $rec["content"];
            print "<br><br>";
            print "<a href='comment_done.php?post_id=" . $rec['post_id'] . "&id=" . $rec['id'] . "'>";
            print "認証する</a>";
            print "<br><br>";
            print "<a href='comment_done.php?post_id=" . $rec['post_id'] . "&id=" . $rec['id'] . "&flag=1'>";
            print "削除する</a>";
            print "<br><br>";
        }

        $dbh = null;
    } catch (Exception $e) {
        print "サーバーに異常が発生しました。<br>";
        print $e."<br>";
        print "<a href='cms_top.php'>cmsトップへ</a>";
    }
    ?>

    <form>
        <input type="button" onclick="history.back()" value="戻る">
    </form>
</body>

</html>
