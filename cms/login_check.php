<?php
try {

    require_once("../common/common.php");
    require_once("../common/local_settings.php");

    $post = sanitize($_POST);
    $name = $post["name"];
    $pass = $post["password"];
    $pass2 = $post["password2"];

    if (empty($name) === true or empty($pass) === true or empty($pass2) === true) {
        print "ログイン情報が間違っています。<br>" ;
        print "<form>" ;
        print "<input type='button' onclick='history.back()' value='戻る'>" ;
        print "</form>" ;
        exit();
    }

    $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
    $user = "root";
    $password = $db_password;
    $dbh = new PDO($dsn, $user, $password);
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT name FROM editor WHERE name=? && password=?";
    $stmt = $dbh -> prepare($sql);
    $data[] = $name;
    $data[] = $pass;
    $stmt -> execute($data);

    $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
    if (empty($rec["name"]) === true) {
        print "ログイン情報が間違っています。管理者名かパスワードが違います。<br>";
        print "<form>";
        print "<input type='button' onclick='history.back()' value='戻る'>";
        print "</form>";
        exit();
    }
    session_start();
    $_SESSION["login"] = 1;
    $_SESSION["name"] = $rec["name"];
    header("Location:cms_top.php");

}
catch (Exception $e) {
    print "ただ今障害が発生しております。<br>";
    print $e -> getMessage();
    print "<a href='login.php'>戻る</a>";
}
?>
