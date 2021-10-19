<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>my blog</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/post.css">
</head>

<body>
    <div class="body__container">

        <?php require_once("parts/header.php"); ?>
        <?php require_once("parts/pankuzu.php"); ?>
        <wrapper>
            <div class="main__wrapper">

                <?php
                try {

                    require_once("common/common.php");
                    require_once("common/local_settings.php");

                    $get = sanitize($_GET);

                    $id = $get["kotei"];

                    $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
                    $user = "root";
                    $password = $db_password;
                    $dbh = new PDO($dsn, $user, $password);
                    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "SELECT title, img, created_at, content, comment FROM kotei WHERE id=$id";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();

                    //$dbh = null;

                    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                    $post_date = explode(" ", $rec["created_at"])[0];
                    $post_date_styled = explode("-", $post_date);

                    print "<div class='post__wrapper'>";
                    print "<div class='post-date__wrapper'>";
                    print $post_date_styled[0] . "/" . $post_date_styled[1] . "/" . $post_date_styled[2];
                    print "</div>";

                    print $rec["title"];
                    if (!empty($rec["img"]) === true) {
                        print "<img class='thumbnail' src='cms/img/" . $rec['img'] . "'>";
                    }
                    print $rec["content"];
                    print "</div>";

                    if ($rec["comment"] === "1") {
                        print "<div class='comment-form__wrapper'>";
                        print "<h2>お問い合わせフォーム</h2>";
                        print "<form action='contact.php' method='post' class='comment__form'>";
                        print "<label for='name'><span>お名前</span>";
                        print "<input type='text' name='name' class='comment-form__item'></label>";
                        print "<br>";
                        print "<label for='mail'><span>メール</span>";
                        print "<input type='mail' name='mail' class='comment-form__item'></label>";
                        print "<br>";
                        print "<label for='comment'><span class='comment-content__label'>コメント</span>";
                        print "<textarea name='comment' class='comment-form__item'></textarea></label>";
                        // print "<input type='hidden' name='id' value='" . $id . "'>";
                        print "<br>";
                        print "<button type='submit' class='form__btns--green'>送信</button>";
                        print "</form>";
                        print "</div>";

                    }
                } catch (Exception $e) {
                    print "異常";
                    exit();
                }
                ?>

    </div> <!-- main__wrapper -->
    <?php require_once("parts/side.php"); ?>
    </div> <!-- body__container -->
    <?php require_once("parts/footer.php"); ?>
