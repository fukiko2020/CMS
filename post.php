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

                    $id = $get["id"];

                    $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
                    $user = "root";
                    $password = $db_password;
                    $dbh = new PDO($dsn, $user, $password);
                    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "SELECT title, img, category, created_at, content  FROM post WHERE id=$id";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();

                    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this_title = $rec["title"];
                    // $dbh = null;

                    // カテゴリー名取得
                    $c_category_id = $rec["category"];
                    $sql = "SELECT p_menu.name AS p_name, c_menu.name AS c_name FROM p_menu INNER JOIN c_menu ON p_menu.id = c_menu.p_id WHERE c_menu.id=$c_category_id";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();

                    $category = $stmt->fetch(PDO::FETCH_ASSOC);
                    $post_date = explode(" ", $rec["created_at"])[0];
                    $post_date_styled = explode("-", $post_date);

                    print "<div class='post__wrapper'>";
                    print "<div class='post-date__wrapper'>";
                    print $post_date_styled[0] . "/" . $post_date_styled[1] . "/" . $post_date_styled[2];
                    print "</div>";
                    print "<div class='post-category__wrapper'>";
                    print "カテゴリ: " . $category["p_name"] . " - " . $category["c_name"];
                    print "</div>";
                    print $rec["title"];
                    print "<img class='thumbnail' src='cms/img/" . $rec['img'] . "'>";
                    print $rec["content"];
                    print "</div>";

                    // 前後記事へのリンク
                    if (empty($get["category"]) === true) {
                        // 全記事に対する前後リンク
                        $sql = "SELECT id, title FROM post WHERE1";
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute();
                    } else {
                        // カテゴリ別の前後記事へのリンク
                        $sql = "SELECT id, title FROM post WHERE category=?";
                        $stmt = $dbh->prepare($sql);
                        $data[] = $get["category"];
                        $stmt->execute($data);
                    }
                    $data = array();
                    //$dbh = null;

                    while (true) {
                        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (empty($rec["id"]) === true) {
                            break;
                        }
                        $box[] = $rec["id"];
                        $title[] = $rec["title"];
                    }

                    $maxim = count($box);  // 記事数カウント
                    $max = $maxim - 1;
                    $point = array_search($id, $box);  // 全記事の中でどこにいるのか
                    $mae = $point - 1;
                    $ato = $point + 1;

                    print "<div class='pag2'>";
                    if ($mae < 0) {
                        print "<div class='post__link'></div>";;
                    } else {
                        print "<div class='post__link'>";
                        if (empty($get["category"]) === true) {
                            print "<a href='kotei.php?id=" . $box[$mae] . "'>&laquo; 前の記事「" . strip_tags($title[$mae]) . "」へ</a></div>";
                        } else {
                            print "<a href='post.php?id=" . $box[$mae] . "&category=" . $get['category'] . "'>&laquo; 前の記事「" . strip_tags($title[$mae]) . "」へ</a></div>";
                        }
                    }

                    if ($ato > $max) {
                        print "<div class='post__link'></div>";
                    } else {
                        print "<div class='post__link'>";
                        if (empty($get["category"]) === true) {
                            print "<a href='kotei.php?n=" . $box[$ato] . "'>&raquo; 次の記事「" . strip_tags($title[$ato]) . "」へ</a></div>";
                        } else {
                            print "<a href='post.php?n=" . $box[$ato] . "&category=" . $get['category'] . "'>&raquo; 次の記事「" . strip_tags($title[$ato]) . "」へ</a></div>";
                        }
                    }
                    print "</div>";

                    // print "<div class='comment-form__wrapper'>";
                    // print "<h3>コメントを残す</h3>";
                    // print "<form action='comment.php' method='post' class='comment__form'>";
                    // print "<label for='name'><span>お名前</span>";
                    // print "<input type='text' name='name' class='comment-form__item'></label>";
                    // print "<br>";
                    // print "<label for='comment'><span class='comment-content__label'>コメント</span>";
                    // print "<textarea name='comment' class='comment-form__item'></textarea></label>";
                    // print "<input type='hidden' name='id' value='" . $id . "'>";
                    // print "<input type='hidden' name='title' value='" . $this_title . "'>";
                    // print "<br>";
                    // print "<button type='submit' class='form__btns--green'>送信</button>";
                    // print "</form>";
                    // print "</div>";

                    print "<div class='comment-list__wrapper'>";
                    print "<h3>コメント一覧</h3>";

                    $sql = "SELECT name, content, created_at FROM comment WHERE post_id=? AND permitted=1 ORDER BY id DESC";
                    $stmt = $dbh->prepare($sql);
                    $data[] = $id;
                    $stmt->execute($data);
                    $data = array();

                    $dbh = null;

                    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (empty($rec["name"]) === true) {
                        print "<p>コメントはまだありません。</p>";
                    } else {
                        print "<div class='comment-list__item'>";
                        print "<span class='comment-list__time'>" . $rec["created_at"] . "</span>";
                        print "<span class='comment-list__name'>" . $rec["name"] . "</span>";
                        print "<div class='comment-list__content'>" . $rec["content"] . "</div>";
                        print "</div>";
                        while (true) {
                            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                            if (empty($rec["name"]) === true) {
                                break;
                            }
                            print "<div class='comment-list__item'>";
                            print "<span class='comment-list__time'>" . $rec["created_at"] . "</span>";
                            print "<span class='comment-list__name'>" . $rec["name"] . "</span>";
                            print "<div class='comment-list__content'>" . $rec["content"] . "</div>";
                            print "</div>";
                        }
                    }
                    print "</div>";

                    print "<div class='comment-form__wrapper'>";
                    print "<h3>コメントを残す</h3>";
                    print "<form action='comment.php' method='post' class='comment__form'>";
                    print "<label for='name'><span>お名前</span>";
                    print "<input type='text' name='name' class='comment-form__item'></label>";
                    print "<br>";
                    print "<label for='comment'><span class='comment-content__label'>コメント</span>";
                    print "<textarea name='comment' class='comment-form__item'></textarea></label>";
                    print "<input type='hidden' name='id' value='" . $id . "'>";
                    print "<input type='hidden' name='title' value='" . $this_title . "'>";
                    print "<br>";
                    print "<button type='submit' class='form__btns--green'>送信</button>";
                    print "</form>";
                    print "</div>";
                } catch (Exception $e) {
                    print "異常";
                    exit();
                }
                ?>

    </div> <!-- main__wrapper -->
    <?php require_once("parts/side.php"); ?>
    </div> <!-- body__container -->
    <?php require_once("parts/footer.php"); ?>
