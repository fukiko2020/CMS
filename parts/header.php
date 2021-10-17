

    <header class="header__container">
        <h1 class="header__title"><a href="index.php">my blog</a></h1>
        <h2 class="header__subtitle">ブログサブタイトル</h2>
        <p id="target">menu</p>

        <?php
        try {
            require_once("common/local_settings.php");

            $dsn = "mysql:host=localhost;dbname=blog;charset=utf8";
            $user = "root";
            $password = $db_password;
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT name, id FROM p_menu WHERE1";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            while (true) {
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if (empty($rec["name"]) === true) {
                    break;
                }
                $p_category_name[] = $rec["name"];
                $p_id_list[] = $rec["id"];
            }

            if (isset($p_category_name) === true) {
                $max = count($p_category_name);
                // php 形式の値をJSONに変換してJSに渡す（JSで各メニューのIDに合わせてクリックイベントを生成するため）
                $maxval = json_encode($max);

                print "<ul class='nav-parent__wrapper'>";  // 親メニューのul開始

                for ($i = 0; $i < $max; $i++) {
                    $n = $i + 1;
                    print "<li id='menu$n' class='nav-parent'><a href='#'>" . $p_category_name[$i] . "</a>";

                    $id = $p_id_list[$i];

                    // $p_category_name[$i] の子メニュー取得
                    $sql = "SELECT name FROM c_menu WHERE p_id=?";
                    $stmt = $dbh->prepare($sql);
                    $data[] = $id;
                    $stmt->execute($data);

                    print "<ul id='menu_open$n' class='nav-child__wrapper'>\n";
                    foreach ($stmt as $rec2) {

                    // while (true) {
                        // $rec2 = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (empty($rec2["name"]) === false) {
                            print "<li class='nav-child'>";
                            print "<a href='category.php?category=" . $rec2["name"] . "'>" . $rec2["name"] . "</a>". "</li>" ;
                        } else {
                            // print "</ul>";
                            // $data = array();
                            break 1;
                        }
                    }
                    $data = array();
                    print "</ul>";  // 子メニューのul閉じタグ
                }
                print "</li>";  // 親メニューのli閉じタグ
                $p_category_name = array();
                $p_id_list = array();
            } else {
                $maxval = json_encode(999);
            }

            // 固定記事をnavバーに表示
            $sql = "SELECT title, id FROM kotei WHERE1";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            while (true) {
                $rec3 = $stmt->fetch(PDO::FETCH_ASSOC);
                if (empty($rec3["title"]) === true) {
                    break;
                }
                $max += 1;
                print "<li id=menu$max class='nav-parent'><a href='page.php?kotei=" . $rec3['id'] . "'>";
                print strip_tags($rec3["title"]);
                print "</a></li>";
                print "<br>";
            }

            $dbh = null;
        } catch (Exception $e) {
            print "異常";
            print $e;
            exit();
        }

        ?>
    </header>
