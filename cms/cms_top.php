<?php
session_start();
session_regenerate_id(true);  // セッションIDを絶えず変更する
// ログインしていなければログイン画面に戻る
if (isset($_SESSION["login"]) === false) {
    print "ログインしていません。<br>";
    print "<a href='login.php'>ログイン画面へ</a>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS TOP</title>
</head>
<body>
    <h1>CMS TOP</h1>
    <h2>サイトを見る</h2>
    <a href="../index.php">http://example.com</a>
    <h2>カテゴリー追加</h2>
    <a href="parent_menu_add.php">親カテゴリ追加</a>
    <a href="child_menu_add.php">子カテゴリ追加</a>
    <h2>記事投稿</h2>
    <a href="../edit_post.php">新規記事作成</a>
    <a href="../edit_kotei.php">固定ページ作成</a>
    <h2>プロフィール</h2>
    <a href="edit_profile.php">プロフィール編集</a>
    <h2>コメント</h2>
    <a href="check_comment.php">コメント認証・削除</a>
    <a href="comment_list.php">コメントリスト・返信</a>
    <h2>ログアウト</h2>
    <a href="logout.php">ログアウト</a>
</body>
</html>
