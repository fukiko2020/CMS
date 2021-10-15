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
    <title>cms - コメント一覧</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <main>

        <?php
        try {
            require_once("../common/local_settings.php");

            $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
            $user = "root";
            $password = $db_password;
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // $sql = "SELECT * FROM comment WHERE1 ORDER BY id DESC";
            $sql = "SELECT COM.id AS id, COM.post_id AS post_id, COM.name AS name, COM.content AS content, COM.created_at AS created_at, COM.replied AS replied, post.title AS post_title FROM comment AS COM LEFT OUTER JOIN post ON COM.post_id = post.id WHERE COM.permitted = 1";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            print "コメント一覧<br><br>";
            if (empty($rec["name"]) === true) {
                print "まだコメントはありません。<br><br>";
                print "<form>";
                print "<input type='button' onclick='history.back()' value='戻る'>";
                print "</form>";
                exit();
            }

            $title_untagged = strip_tags($rec["post_title"]);
            print $title_untagged . " に対するコメント<br>";
            print "投稿日時: " . $rec["created_at"];
            print "<br>";
            print "投稿者: " . $rec["name"];
            print "<br>";
            print "コメント: " . $rec["content"];
            if (empty($rec["replied"]) === true) {
                print "<strong>未返信です</strong><br>";
                print "<a href='comment_reply.php?id=" . $rec['id'] . "&post_id=" . $rec['post_id'] . "&content=" . $rec['content'] . "'>";
                print "返信する</a>";
            } else {
                print "<strong>返信済です</strong><br>";
            }
            print "<br><br>";

            while (true) {
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if (empty($rec["name"]) === true) {
                    break;
                }
                $title_untagged = strip_tags($rec["post_title"]);
                print $title_untagged . " に対するコメント<br>";
                print "投稿日時: " . $rec["created_at"];
                print "<br>";
                print "投稿者: " . $rec["name"];
                print "<br>";
                print "コメント: " . $rec["content"];
                print "<br>";
                if (empty($rec["replied"]) === true) {
                    print "<strong>未返信です</strong><br>";
                    print "<a href='comment_reply.php?id=" . $rec['id'] . "&post_id=" . $rec['post_id'] . "&content=" . $rec['content'] . "'>";
                    print "返信する</a>";
                } else {
                    print "<strong>返信済です</strong><br>";
                }
                print "<br><br>";
            }
        
            $dbh = null;
        } catch (Exception $e) {
            print "サーバーに異常が発生しました。<br>";
            print $e;
            print "<a href='cms_top.php'>cmsトップへ</a>";
        }
        ?>
        <form>
            <input type="button" onclick="history.back()" value="戻る">
        </form>

    </main>
</body>

</html>
