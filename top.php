<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>苳のブログ</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="body__container">

        <header class="header__container">
            <h1 class="header__title">苳のブログ</h1>
            <p class="header__subtitle">ふきのぶろぐ</p>
        </header>
        <ul class="nav__container">
            <li class="nav__item"><a href="">JavaScript</a></li>
            <li class="nav__item"><a href="">Python</a></li>
            <li class="nav__item"><a href="">PHP</a></li>
            <li class="nav__item"><a href="">diary</a></li>
            <li class="nav__item"><a href="">others</a></li>
        </ul>

        <div class="main__container">
            <div class="article__list">

                <?php
                print <<< article_list

                <div class="article__item">
                <div class="article__title">ここにタイトルが入ります</div>
                <div class="article__content">ここに記事の本体が入ります</div>
                </div>
                <div class="article__item">
                <div class="article__title">ここにタイトルが入ります</div>
                <div class="article__content">ここに記事の本体が入ります</div>
                </div>
                <div class="article__item">
                <div class="article__title">ここにタイトルが入ります</div>
                <div class="article__content">ここに記事の本体が入ります</div>
                </div>

                article_list;
                ?>
            </div>
        </div>

        <!-- <div class="sidebar__container"></div> -->
        <div class="footer__container">
            <div class="footer__profile">
                <div class="footer__icon">
                    <img src="images/icon.jpg" alt="Fukiのアイコン">
                </div>
                <div class="footer__str">
                    <p>著者 / Fuki</p>
                    <p>大学合格後、プログラミングの学習を始めました。文学部の女子学生で、美味しいものを食べることや小説を読むことが大好きです。</p>
                </div>
            </div>
            <small class="footer__copyright">&copy;2021 Fuki</small>
        </div>
    </div>

</body>

</html>
