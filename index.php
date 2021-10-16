<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>my blog</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="body__container">

    <?php require_once("parts/header.php"); ?>
    <wrapper>
        <main>

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
                        $sql = "SELECT id, category, img, title, created_at FROM post ORDER BY id DESC LIMIT $now, $card_max";
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute();
                    } else {
                        $now = $now * $card_max;
                        $sql = "SELECT id, category, img, title, created_at FROM post ORDER BY id DESC LIMIT $now, $card_max";
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute();
                    }

                    while (true) {
                        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (empty($rec["title"]) === true) {
                            break;
                        }
                        print "<hr>";
                        print "<div id='blog_card'>";
                        print "<a class='card' href='post.php?id=" . $rec['id'] . "'>";
                        print "<div id='main_img'>";
                        print "<img src='cms/img/" . $rec['img'] . "'>";
                        print "</div>";
                        print "<div id='main_text'>";
                        print "カテゴリ　" . $rec["category"] . "<br>";
                        print "更新日　" . $rec["created_at"] . "<br>";
                        print "<div class='card_title'>";
                        print strip_tags($rec["title"]) . "</div><br>";
                        print "</div>";
                        print "</a>";
                        print "</div>";
                        print "<hr>";
                    }

                    print "<div class='pag'>";
                    for ($i = 1; $i <= $page_max; $i++) {
                        if ($i == $page) {
                            // 今いるページにはリンクなし
                            print "<div class='posi'>" . $page . "</div>";
                        } else {
                            // 別ページにはリンク付き
                            print "<div class='posi'><a href='index.php?page=" . $i . "'>";
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

            <?php require_once("parts/nav.php"); ?>

        </main>
        <?php require_once("parts/side.php"); ?>
        <?php require_once("parts/footer.php"); ?>
