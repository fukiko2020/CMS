<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cmsログイン</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    ログイン情報を入力してください。
    <br><br>
    管理者名<br>
    <form action="login_check.php" method="post">
        <input type="text" name="name">
        <br>
        パスワード<br>
        <input type="password" name="password">
        <br>
        パスワード再入力<br>
        <input type="password" name="password2">
        <br><br>
        <input type="submit" value="OK">


    </form>
</body>

</html>
