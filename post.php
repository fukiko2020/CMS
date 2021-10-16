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

                //$dbh = null;

                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                $this_title = $rec["title"];

                print $rec["title"];
                print "<br>";
                print "<div class='catetime'>";
                print $rec["category"];
                print "<br>";
                print $rec["created_at"];
                print "</div>";
                print "<br>";
                print "<img class='bunimg' src='cms/img/" . $rec['img'] . "'>";
                print "<br>";
                print $rec["content"];

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
                    print "<div class='posi2'></div>";;
                } else {
                    print "<div class='posi2'>前の記事:";
                    if (empty($get["category"]) === true) {
                        print "<a href='single.php?id=" . $box[$mae] . "'>" . strip_tags($title[$mae]) . "</a></div>";
                    } else {
                        print "<a href='post.php?id=" . $box[$mae] . "&category=" . $get['category'] . "'>" . strip_tags($title[$mae]) . "</a></div>";
                    }
                }

                if ($ato > $max) {
                    print "<div class='posi2'></div>";
                } else {
                    print "<div class='posi2'>次の記事:";
                    if (empty($get["category"]) === true) {
                        print "<a href='post.php?n=" . $box[$ato] . "'>" . strip_tags($title[$ato]) . "</a></div>";
                    } else {
                        print "<a href='post.php?n=" . $box[$ato] . "&category=" . $get['category'] . "'>" . strip_tags($title[$ato]) . "</a></div>";
                    }
                }
                print "</div>";

                print "<h3>コメントを残す</h3>";
                print "<div class='comment'>";
                print "<form action='comment.php' method='post'>";
                print "お名前<br>";
                print "<input type='text' name='name'><br>";
                print "コメント<br>";
                print "<textarea name='comment'></textarea><br>";
                print "<input type='hidden' name='id' value='" . $id . "'>";
                print "<input type='hidden' name='title' value='" . $this_title . "'>";
                print "<input type='submit' value='送信'>";
                print "</form>";
                print "</div>";
                print "<br><br>";

                print "<h3>コメント一覧</h3>";

                $sql = "SELECT name, content, created_at FROM comment WHERE post_id=? AND permitted=1 ORDER BY id DESC";
                $stmt = $dbh->prepare($sql);
                $data[] = $id;
                $stmt->execute($data);
                $data = array();

                $dbh = null;

                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                if (empty($rec["name"]) === true) {
                    print "コメントはまだありません";
                } else {
                    print "<div class='comment2'>";
                    print $rec["name"] . "<br>";
                    print $rec["created_at"] . "<br>";
                    print $rec["content"] . "<br>";
                    print "</div>";
                    while (true) {
                        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (empty($rec["name"]) === true) {
                            break;
                        }
                        print "<div class='comment2'>";
                        print $rec["name"] . "<br>";
                        print $rec["created_at"] . "<br>";
                        print $rec["content"] . "<br>";
                        print "</div>";
                    }
                }
            } catch (Exception $e) {
                print "異常";
                exit();
            }
            ?>

            <?php require_once("parts/nav.php"); ?>

        </main>
        <?php require_once("parts/side.php"); ?>
        <?php require_once("parts/footer.php"); ?>
