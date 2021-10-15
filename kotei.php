<?php require_once("parts/header.php"); ?>
<wrapper>
    <main>

        <?php require_once("parts/pankuzu.php"); ?>

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

            print $rec["title"];
            print "<br>";
            print $rec["created_at"];
            print "<br>";
            if (!empty($rec["img"]) === true) {
                print "<img src='cms/img/" . $rec['img'] . "'>";
            }
            print "<br>";
            print $rec["content"];

            if ($rec["comment"] === "1") {
                print "<br><br>";
                print "<h2>お問い合わせフォーム</h2>";
                print "<form action='contact.php' method='post'>";
                print "お名前";
                print "<br>";
                print "<div class='toi'>";
                print "<input type='text' name='name'>";
                print "<br>";
                print "mail";
                print "<br>";
                print "<input type='text' name='mail'>";
                print "</div>";
                print "<br>";
                print "内容";
                print "<br>";
                print "<div class='toi2'>";
                print "<textarea name='content'></textarea>";
                print "</div>";
                print "<br><br>";
                print "<input type='submit' value='送信'>";
                print "</form>";
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
