<?php require_once("parts/header.php"); ?>
<wrapper>
    <main>

        <?php require_once("parts/pankuzu.php"); ?>

        <?php
        try {

            require_once("common/common.php");
            require_once("common/local_settings.php");

            $get = sanitize($_GET);

            $category = $get["category"];
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
                    $sql = "SELECT id, category, img, title, time FROM post WHERE category=? ORDER BY id DESC LIMIT $now, $card_max";
                    $stmt = $dbh->prepare($sql);
                    $data[] = $category;
                    $stmt->execute($data);
                } else {
                    $now = $now * $card_max;
                    $sql = "SELECT id, category, img, title, time FROM post WHERE category=? ORDER BY id DESC LIMIT $now, $card_max";
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
                    print "<div id='blog_card'>";
                    print "<a class='card' href='post.php?id=" . $rec['id'] . "&category=" . $rec['category'] . "'>";
                    print "<div id='main_img'>";
                    print "<img src='cms/img/" . $rec['img'] . "'>";
                    print "</div>";
                    print "<div id='main_text'>";
                    print "カテゴリ　" . $rec["category"] . "<br>";
                    print "更新日時　" . $rec["time"] . "<br>";
                    print "<div class='card_title'>";
                    print strip_tags($rec["title"]) . "</div><br>";
                    print "</div>";
                    print "</a>";
                    print "</div>";
                }

                print "<div class='pag'>";
                for ($i = 1; $i <= $page_max; $i++) {
                    if ($i == $page) {
                        print "<div class='posi'>" . $page . "</div>";
                    } else {
                        print "<div class='posi'><a href='category.php?page=" . $i . "&category=" . $category . "'>";
                        print $i . "</a></div>";
                    }
                }
                print "</div>";
            } else {
                print "<br><br>";
                print "記事がありません。";
            }
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
