<?php
try {

    require_once("common/common.php");
    require_once("common/local_settings.php");

    print "<div class='pankuzu__container'>";
    if (empty($_GET["id"]) === true && empty($_GET["category"]) === true && empty($_GET["kotei"]) === true) {
        print "<a href='index.php'>";
        print "home";
        print "</a>";
    } else {
        $get = sanitize($_GET);
        $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
        $user = "root";
        $password = $db_password;
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($get["id"]) === true) {
            // 記事指定

            $sql = "SELECT title, category FROM post WHERE id=?";
            $stmt = $dbh->prepare($sql);
            $data[] = $get["id"];
            $stmt->execute($data);
            $data = array();

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            $category = $rec["category"];
            $title = $rec["title"];

            $sql = "SELECT p_id FROM c_menu WHERE id=?";
            $stmt = $dbh->prepare($sql);
            $data[] = $category;
            $stmt->execute($data);
            $data = array();

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            $p_id = $rec["p_id"];

            $sql = "SELECT name FROM p_menu WHERE id=?";
            $stmt = $dbh->prepare($sql);
            $data[] = $p_id;
            $stmt->execute($data);
            $data = array();

            $dbh = null;

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            $p_category = $rec["name"];

            print "<a href='index.php'>";
            print "home";
            print "</a>";
            print "  ≫  ";
            print "<a href='category.php?category=" . $category . "'>";
            print $p_category . " - " . $category;
            print "</a>";
            print "  ≫  ";
            print strip_tags($title);

            $p_id = array();
            $title = array();
        } else if (isset($get["category"]) === true) {
            // カテゴリー指定、記事は指定せず
            $sql = "SELECT p_id, name FROM c_menu WHERE id=?";
            $stmt = $dbh->prepare($sql);
            $data[] = $get["category"];
            $stmt->execute($data);
            $data = array();

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            $p_id = $rec["p_id"];
            $c_category = $rec["name"];

            $sql = "SELECT name FROM p_menu WHERE id=?";
            $stmt = $dbh->prepare($sql);
            $data[] = $p_id;
            $stmt->execute($data);
            $data = array();

            $dbh = null;

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            $p_category = $rec["name"];

            print "<a href='index.php'>";
            print "home";
            print "</a>";
            print "  ≫  ";
            print "<a href='category.php?category=" . $get['category'] . "'>";
            print $p_category . " - " . $c_category;
            print "</a>";

            $o_code = array();
        } else {
            // 固定記事
            $sql = "SELECT title FROM kotei WHERE id=?";
            $stmt = $dbh->prepare($sql);
            $data[] = $get["kotei"];
            $stmt->execute($data);
            $data = array();

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            print "<a href='index.php'>";
            print "home";
            print "</a>";
            print "  ≫  ";
            print strip_tags($rec["title"]);
        }
    }
    print "</div>";

} catch (Exception $e) {
    print "異常";
    print $e;
    exit();
}
