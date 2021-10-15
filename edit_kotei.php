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
    <title>cms - 固定記事作成</title>
    <link rel="stylesheet" href="cms/css/edit.css">
</head>

<body>
    <?php
    try {
        require_once("common/local_settings.php");

        $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
        $user = "root";
        $password = $db_password;
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT id, name FROM c_menu WHERE1";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        while (true) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($rec["name"]) === true) {
                break;
            }
            $c_menu_name[$rec["id"]] = $rec["name"];
        }
        $dbh = null;
    } catch (Exception $e) {
        print "只今障害が発生しております。<br><br>";
        print "<a href='login.html'>ログイン画面へ</a>";
    }
    ?>
    <h1>記事作成</h1>
    <div id="edit">
        <div id="box2">
            <form action="cms/upload.php" method="post" enctype="multipart/form-data">
                <h2>画像ファイルアップロード</h2>
                <input type="file" name="image_data[]" multiple="multiple">
                <input type="submit" value="アップロード">
            </form>
            <br>
            <form action="check_kotei.php" method="post" enctype="multipart/form-data">
                <h2>カテゴリ</h2>
                <select name='category'>
                    <option value=""></option>
                    <?php foreach ($c_menu_name as $key => $value) {; ?>
                        <option value='<?php print $key; ?>'><?php print $value; ?></option>
                    <?php }; ?>
                </select>
                <h2>タイトル</h2>
                <textarea name="title" id="title"><h1></h1></textarea>
                <br>
                <h2>サムネイル</h2>
                <input type="text" id="thumbnail_name" name="img">
                <input type="button" id="thumbnail_btn" value="ok">
                <br><br>
                <input type="radio" name="enable_comment" value="1">問い合わせフォームあり
                <input type="radio" name="enable_comment" value="0">問い合わせフォームなし

                <div class="tag">
                    <div id="h1">h1　</div>
                    <div id="p">p　</div>
                    <div id="br">br　</div>
                    <div id="h2">h2　</div>
                    <div id="img">img　</div>
                    <a href="cms/choose_img.php" target="blank">imgファイル名検索</a>
                </div>

                <textarea id="content" name="content"></textarea>
                <br>
                <input type="submit" value="確認画面へ">
                <input type="button" onclick="history.back()" value="戻る">
            </form>
        </div>
        <div id="write">
            <h3>タイトル</h3>
            <div id="show_title"></div>
            <h3>サムネイル</h3>
            <div id="show_img"></div>
            <h3>本文</h3>
            <div id="show_content"></div>

        </div>
    </div>

    <script src="js/edit.js"></script>
</body>


</html>
