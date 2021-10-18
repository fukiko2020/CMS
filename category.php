<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>my blog</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
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

                $category = $get["category"];
                // print $category;
                $card_max = 5;

                if (empty($get["page"]) == true) {
                    $page = 1;
                } else {
                    $page = $get["page"];
                }

                $now = $page - 1;

                $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
                $user = "root";
                $password = $db_password;
                $dbh = new PDO($dsn, $user, $password);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT title FROM post WHERE category=?";
                $stmt = $dbh->prepare($sql);
                $data[] = $category;
                $stmt->execute($data);
                $data = array();

                while (true) {
                    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (empty($rec["title"]) === true) {
                        break;
                    }
                    $title[] = $rec["title"];
                }

                if (isset($title) === true) {

                    $card_all = count($title);
                    $page_max = ceil($card_all / $card_max);

                    if ($page === 1) {
                        $sql = "SELECT id, category, img, title, content, created_at FROM post WHERE category=? ORDER BY id DESC LIMIT $now, $card_max";
                        $stmt = $dbh->prepare($sql);
                        $data[] = $category;
                        $stmt->execute($data);
                    } else {
                        $now = $now * $card_max;
                        $sql = "SELECT id, category, img, title, content, created_at FROM post WHERE category=? ORDER BY id DESC LIMIT $now, $card_max";
                        $stmt = $dbh->prepare($sql);
                        $data[] = $category;
                        $stmt->execute($data);
                    }
                    $data = array();
                    $dbh = null;
                    while (true) {
                        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (empty($rec["title"]) === true) {
                            break;
                        }
                        print "<div class='blog-card__wrapper' id='blog-card__wrapper'>";
                        print "<a class='card' href='post.php?id=" . $rec['id'] . "&category=" . $rec['category'] . "'>";
                        print "<div id='main-img' class='blog-card__main-img'>";
                        print "<img src='cms/img/" . $rec['img'] . "'>";
                        print "</div>";
                        print "<div id='main_text' class='blog-card__text'>";
                        print "<div class='blog-card__title'>";
                        print strip_tags($rec["title"]) . "</div>";
                        print "<div class='blog-card__content'>" . $rec["content"] . "</div>";
                        print "<div class='blog-card__subtext'>";
                        print "<div>カテゴリ: " . $rec["category"] . "</div>";
                        print "<div>更新日時: " . $rec["created_at"] . "</div>";
                        print "</div>";
                        print "</div>";
                        print "</a>";
                        print "</div>";
                    }

                    print "<div class='paging__wrapper'>";
                    for ($i = 1; $i <= $page_max; $i++) {
                        if ($i == $page) {
                            print "<div class='paging__page paging__page--now'>" . $page . "</div>";
                        } else {
                            print "<div class='paging__page paging__page--notnow'><a href='category.php?page=" . $i . "&category=" . $category . "'>";
                            print $i . "</a></div>";
                        }
                    }
                    print "</div>";
                } else {
                    print "<div class='blog-card__nopost'>記事がありません。</div>";
                }
                $dbh = null;
            } catch (Exception $e) {
                print "異常";
                print $e;
                exit();
            }

            ?>
        </div>  <!-- main__wrapper -->
        <?php require_once("parts/side.php"); ?>
        </div> <!-- body__container -->
        <?php require_once("parts/footer.php"); ?>
