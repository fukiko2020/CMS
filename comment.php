<?php require_once("parts/header.php"); ?>
<wrapper>
    <main>

        <?php require_once("parts/pankuzu.php"); ?>

        <?php
        try {

            require_once("common/common.php");
            require_once("common/local_settings.php");

            $post = sanitize($_POST);

            $name = $post["name"];
            $comment = $post["comment"];
            $id = $post["id"];
            $title = $post["title"];
            // 今回の設計上、改行があると次ページへ遷移できないため改行を削除
            $comment = str_replace(PHP_EOL, '', $comment);

            if (empty($name) === true or empty($comment) === true) {
                print "<br><br>";
                print "名前かコメントが空白です。";
                print "<br><br>";
                print "<form>";
                print "<input type='button' onclick='history.back()' value='戻る'>";
                print "</form>";
            } else {

                $title = strip_tags($title);

                $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
                $user = "root";
                $password = $db_password;
                $dbh = new PDO($dsn, $user, $password);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "INSERT INTO comment(name, content, post_id) VALUES(?,?,?)";
                $stmt = $dbh->prepare($sql);
                $data[] = $name;
                $data[] = $comment;
                $data[] = $id;
                var_dump($data);
                $stmt->execute($data);
                print "これはデバッグプリントです";
                $data = array();

                $dbh = null;

                print "<br><br>";
                print "コメントを送信しました。<br>";
                print "コメントは認証後に反映されます。<br><br>";
                print "<a href='post.php?n=" . $id . "'>";
                print "戻る";
                print "</a>";

                $bun = "";
                $bun .= $name . "様よりコメント\n\n";
                $bun .= $title . "　の記事\n\n";
                $bun .= $comment . "\n\n下記URLよりログインして認証可否して下さい。\n\n";
                $bun .= "https://masimaro-comp.com/cms/login.php";

                //print "<br>";
                //print nl2br($bun);

                $title = "コメントが入りました。";
                $header = "From:" . $name;
                $content = html_entity_decode($bun, ENT_QUOTES, "UTF-8");
                mb_language("Japanese");
                mb_internal_encoding("UTF-8");
                mb_send_mail($email, $title, $bun, $header);
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
