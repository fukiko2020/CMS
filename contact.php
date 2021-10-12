<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>苳のブログ</title>
</head>

<body>
    <div class="body__container">

        <header class="header__container">
            <h1 class="header__title">苳</h1>
            <p class="header__subtitle">ふきのぶろぐ</p>
        </header>
        <ul class="nav__container">
            <li class="nav__item"><a href="">JavaScript</a></li>
            <li class="nav__item"><a href="">Python</a></li>
            <li class="nav__item"><a href="">PHP</a></li>
            <li class="nav__item"><a href="">diary</a></li>
            <li class="nav__item"><a href="">others</a></li>
        </ul>

        <form action="" method="POST" class="form">
            <label for="name" class="form__item-label">お名前</label>
            <input type="text" name="name" class="form__item">
            <label for="email" class="form__item-label">メールアドレス</label>
            <input type="mail" name="email" class="form__item">
            <label for="content" class="form__item-label">お問い合わせ内容</label>
            <textarea name="content" id="" cols="30" rows="10" class="form__item"></textarea>
            <button type="submit" class="form__button">送信</button>
        </form>

        <!-- <div class="sidebar__container"></div> -->
        <div class="footer__container">
            <div class="footer__profile">
                <div class="footer__icon">
                    <img src="images/fuki.jpg" alt="アイコン">
                </div>
                <div class="footer__str">
                    <p>著者 / Fuki</p>
                    <p>大学合格後、プログラミングの学習を始めました。文学部の女子学生で、美味しいものを食べることや小説を読むことが大好きです。</p>
                </div>
            </div>
            <small class="footer__copyright">&copy;2021 Fuki</small>
        </div>
    </div>

    <?php

    ?>

</body>

</html>
