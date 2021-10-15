<?php require_once("parts/header.php"); ?>
<warapper>
    <main>

        <?php require_once("parts/pankuzu.php"); ?>

        <?php
        try {

            require_once("common/common.php");
            require_once("common/local_settings.php");

            $post = sanitize($_POST);

            $name = $post["name"];
            $mail = $post["mail"];
            $content = $post["content"];
            $flag = true;

            if (empty($name) === true) {
                print "名前が入力されていません。";
                print "<br><br>";
                $flag = false;
            }

            if (preg_match("/\A[\w\-\.]+\@[\w\-\.]+\.([a-z]+)\z/", $mail) === 0) {
                print "正しいemailを入力してください。";
                print "<br><br>";
                $flag = false;
            }

            if (empty($content) === true) {
                print "問い合わせ内容が入力されていません。";
                print "<br><br>";
                $flag = false;
            }

            if ($flag === false) {
                print "<form>";
                print "<input type='button' onclick='history.back()' value='戻る'>";
                print "</form>";
            } else {

                $dsn = "mysql:host=localhost;dbname=test;charset=utf8";
                $user = "root";
                $password = $db_password;
                $dbh = new PDO($dsn, $user, $password);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "INSERT INTO toi(name, mail, content) VALUES(?,?,?)";
                $stmt = $dbh->prepare($sql);
                $data[] = $name;
                $data[] = $mail;
                $data[] = $content;
                $stmt->execute($data);

                $dbh = null;

                //$rec = $stmt -> fetch(PDO::FETCH_ASSOC);

                print "<br><br>";
                print "問い合わせを送信いたしました。";
                print "<br><br>";
                print "<form>";
                print "<input type='button' onclick='history.back()' value='戻る'>";
                print "</form>";

                $bun = "";
                $bun .= $name . "様より問い合わせ\n\n";
                $bun .= $content;

                print "<br>";
                print nl2br($bun);

                $title = "お客様より問い合わせが入りました。";
                $header = "From:" . $mail;
                $content = html_entity_decode($bun, ENT_QUOTES, "UTF-8");
                mb_language("Japanese");
                mb_internal_encoding("UTF-8");
                mb_send_mail($email, $title, $bun, $header);
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
parts/
