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
    <title>cms - プロフィール編集</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <p>プロフィールを入力して下さい。</p>
    <br><br>
    <form action="check_profile.php" method="post" enctype="multipart/form-data">
        管理人名<br>
        <input type="text" name="name">
        <br><br>
        画像<br>
        <input type="file" name="img">
        <br><br>
        紹介文<br>
        <input type="textarea" name="body">
        <br><br>
        <input type="submit" value="確認画面へ">
        <input type="button" onclick="history.back()" value="戻る">
    </form>
</body>

</html>
