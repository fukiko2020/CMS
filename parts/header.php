

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

                for ($i = 0; $i < $max; $i++) {
                    $n = $i + 1;
                    print "<div id='menu$n'>" . $p_category_name[$i] . "</div>";

                    $id = $p_id_list[$i];

                    // $p_category_name[$i] の子メニュー取得
                    $sql = "SELECT name FROM c_menu WHERE p_id=?";
                    $stmt = $dbh->prepare($sql);
                    $data[] = $id;
                    $stmt->execute($data);

                    print "<ul id='menuopen$id'>";

                    while (true) {
                        $rec2 = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (empty($rec2["name"]) === false) {
                            //print "<li>".$rec2['name']."</li>";
                            print "<a href='category.php?category=" . $rec2['name'] . "'>";
                            print "<li>" . $rec2['name'] . "</li>";
                            print "</a>";
                        } else {
                            print "</ul>";
                            $data = array();
                            break 1;
                        }
                    }
                }
                $p_category_name = array();
                $p_id_list = array();
            } else {
                $maxval = json_encode(999);
            }

            $sql = "SELECT title, id FROM kotei WHERE1";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            while (true) {
                $rec3 = $stmt->fetch(PDO::FETCH_ASSOC);
                if (empty($rec3["title"]) === true) {
                    break;
                }
                print "<a href='page.php?kotei=" . $rec3['id'] . "'>";
                print strip_tags($rec3["title"]);
                print "</a>";
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
