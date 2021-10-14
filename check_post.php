<?php

session_start();
session_regenerate_id(true);
if (isset($_SESSION["login"]) === false) {
    print "ログインしていません。<br><br>";
    print "<a href='cms/login.php'>ログイン画面へ</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cms - 記事確認</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php

    $category = $_POST["category"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    $img = $_POST["img"];

    if (empty($title) === true or empty($content) === true or empty($category) === true) {
        print "必要項目を入力して下さい";
        print "<br><br>";
        print "<form>";
        print "<input type='button' onclick='history.back()' value='戻る'>";
        print "</form>";
        exit();
    }

    print $title;
    print $category;
    print "<img class='content_img' src='cms/img/" . $img . "'>";
    print $content;

    ?>

    <br><br>
    上記内容で登録しますか？<br><br>
    <form action="post_done.php" method="post">
        <input type="hidden" name="category" value="<?php print $category; ?>">
        <input type="hidden" name="title" value="<?php print $title; ?>">
        <input type="hidden" name="content" value="<?php print $content; ?>">
        <input type="hidden" name="img" value="<?php print $img; ?>">
        <input type="submit" value="登録する">
    </form>

</body>

</html>
