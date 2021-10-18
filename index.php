<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>my blog</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body class="body__container">

    <?php require_once("parts/header.php"); ?>
    <wrapper>
        <div class="main__wrapper">

            <?php require_once("parts/pankuzu.php"); ?>

            <?php
            try {

                require_once("common/common.php");
                require_once("common/local_settings.php");

                // ページネーション
                if (empty($_GET["page"]) === true) {
                    $page = 1;
                } else {
                    $get = sanitize($_GET);
                    $page = $get["page"];  // 現在いるページ番号
                }

                $now = $page - 1;  // 現在のページ-1
                $card_max = 5;  // 1ページに表示させる記事の上限

                $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
                $user = "root";
                $password = $db_password;
                $dbh = new PDO($dsn, $user, $password);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT title FROM post WHERE1";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();

                while (true) {
                    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (empty($rec["title"]) === true) {
                        break;
                    }
                    $title[] = $rec["title"];
                }

                if (isset($title) === true) {

                    $card_all = count($title);  // 投稿記事のトータル数
                    $page_max = ceil($card_all / $card_max);  // ページ数

                    if ($page === 1) {
                        $sql = "SELECT id, category, img, title, content, created_at FROM post ORDER BY id DESC LIMIT $now, $card_max";
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute();
                    } else {
                        $now = $now * $card_max;
                        $sql = "SELECT id, category, img, title, content, created_at FROM post ORDER BY id DESC LIMIT $now, $card_max";
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute();
                    }

                    while (true) {
                        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (empty($rec["title"]) === true) {
                            break;
                        }
                        print "<div class='blog-card__wrapper' id='blog-card__wrapper'>";
                        print "<a class='card' href='post.php?id=" . $rec['id'] . "'>";
                        print "<div id='main-img' class='blog-card__main-img'>";
                        print "<img src='cms/img/" . $rec['img'] . "'>";
                        print "</div>";
                        print "<div id='main_text' class='blog-card__text'>";
                        print "<div class='blog-card__title'>";
                        print strip_tags($rec["title"]) . "</div>";
                        print "<div class='blog-card__content'>" . $rec["content"] . "</div>";
                        print "<div class='blog-card__subtext'>";
                        print "<div>カテゴリ: " . $rec["category"] . "</div>";
                        print "<div>更新日: " . $rec["created_at"] . "</div>";
                        print "</div>";
                        print "</div>";
                        print "</a>";
                        print "</div>";
                    }

                    print "<div class='paging__wrapper'>";
                    for ($i = 1; $i <= $page_max; $i++) {
                        if ($i == $page) {
                            // 今いるページにはリンクなし
                            print "<div class='paging__page paging__page--now'>" . $page . "</div>";
                        } else {
                            // 別ページにはリンク付き
                            print "<div class='paging__page--notnow'><a href='index.php?page=" . $i . "'>";
                            print $i . "</a></div>";
                        }
                    }
                    print "</div>";
                } else {
                    print "<br><br>";
                    print "記事はありません。";
                }

                $dbh = null;
            } catch (Exception $e) {
                print "異常";
                print $e;
                exit();
            }

            ?>

            <!-- <?php //require_once("parts/nav.php"); ?> -->

        </div>  <!-- main -->
        <?php require_once("parts/side.php"); ?>
        <?php require_once("parts/footer.php"); ?>
