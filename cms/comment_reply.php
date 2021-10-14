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
    <title>cms - コメント返信</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <main>

        <?php

        $post_id = $_GET["post_id"];
        $id = $_GET["id"];
        // $title = $_GET["title"];
        $content = $_GET["content"];

        print "下記コメントに対して返信します<br><br>";
        print "コメント<br><br>";
        print $content;
        print "<br><br>";

        print "<h3>コメントを返信</h3>";
        print "<div class='comment'>";
        print "<form action='reply_done.php' method='post'>";
        print "<input type='text' name='name' value='管理人'><br>";
        print "コメント<br>";
        print "<textarea name='reply'></textarea><br>";
        print "<input type='hidden' name='post_id' value='" . $post_id . "'>";
        print "<input type='hidden' name='id' value='" . $id . "'>";
        print "<input type='submit' value='送信'>";
        print "<input type='button' onclick='history.back()' value='戻る'>";
        print "</form>";
        print "</div>";
        print "<br><br>";

        ?>

    </main>
</body>

</html>
