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
    <title>cms - 記事作成</title>
    <link rel="stylesheet" href="css/edit.css">
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
    <div class="contents__wrapper">

        <div id="edit" class="edit-form__wrapper">
            <!-- <div id="box"> -->
            <form action="check_post.php" method="post" enctype="multipart/form-data">
                <div class="form-item__wrapper">
                    <div>タイトル *</div>
                    <textarea name="title" class="form__title" id="title" cols="30" rows="1"><h1></h1></textarea>
                </div>

                <div class="form-item__wrapper">
                    <div>カテゴリ *</div>

                    <select name='category' class="form__category">
                        <?php foreach ($c_menu_name as $key => $value) {; ?>
                            <option value='<?php print $key; ?>'><?php print $value; ?></option>
                        <?php }; ?>
                    </select>
                </div>

                <div class="form-item__wrapper">
                    <div>サムネイル</div>
                    <input type="text" class="form__thumbnail" id="thumbnail_name" name="img">
                    <input type="button" id="thumbnail_btn" value="決定">
                </div>

                <div class="form-item__wrapper">
                    <div>本文 *</div>
                    <div class="form-tag__wrapper">
                        <div id="h1">&lt;h1&gt;</div>
                        <div id="p">&lt;p&gt;</div>
                        <div id="br">&lt;br&gt;</div>
                        <div id="h2">&lt;h2&gt;</div>
                        <div id="img">&lt;img&gt;</div>
                        <a href="cms/choose_img.php" target="blank">アップロード済画像ファイル名を検索</a>
                    </div>
                    <textarea class="form__content" id="content" name="content"></textarea>
                </div>

                <div class="form__btns">
                    <!-- <input type="submit" value="確認画面へ"> -->
                    <!-- <input type="button" onclick="history.back()" value="戻る"> -->
                    <button type="button" class="form__btns--white" onclick="history.back()">戻る</button>
                    <button type="submit" class="form__btns--green">確認画面へ</button>
                </div>
            </form>
            <form action="cms/upload.php" method="post" enctype="multipart/form-data">
                <div class="form-item__wrapper">
                    <div>画像ファイルアップロード</div>
                    <input type="file" name="image_data[]" multiple="multiple">
                    <input type="submit" value="アップロード">
                </div>
            </form>
        </div>

        <!-- プレビュー -->
        <div id="preview__wrapper">
            <div class="form-item__wrapper">
                <div>プレビュー</div>
            </div>
            <div id="show_title"></div>
            <div id="show_img"></div>
            <div id="show_content"></div>

        </div>
    </div>
    </div> <!-- contents__wrapper -->

    <script src="js/edit.js"></script>
</body>


</html>
