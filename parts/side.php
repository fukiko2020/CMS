<aside>
    <div class="box2">
        <h2>カテゴリー</h2>

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
                print "<div class='box3'>";
                for ($i = 0; $i < $max; $i++) {
                    $n = $i + 1;
                    print "<div id='menu$n'>" . $p_category_name[$i] . "</div>";

                    $id = $p_id_list[$i];

                    $sql = "SELECT name FROM c_menu WHERE p_id=?";
                    $stmt = $dbh->prepare($sql);
                    $data[] = $id;
                    $stmt->execute($data);

                    print "<ul class='side_ul'>";

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
            }
            print "</div>";
            print "</div>";

            print "<div class='box2'>";
            print "<h2>メニュー</h2>";

            $sql = "SELECT title, id FROM kotei WHERE1";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            while (true) {
                $rec3 = $stmt->fetch(PDO::FETCH_ASSOC);
                if (empty($rec3["title"]) === true) {
                    break;
                }
                $id2[] = $rec3["id"];
                $title2[] = $rec3["title"];
            }

            if (isset($id2) === true) {
                $max2 = count($id2);
                print "<div class='box3'>";
                for ($i = 0; $i < $max2; $i++) {
                    print "<a href='kotei.php?kotei=" . $id2[$i] . "'>";
                    print strip_tags($title2[$i]);
                    print "</a>";
                    print "<br>";
                }
                print "</div>";
            }
            print "</div>";

            $sql = "SELECT * FROM profile WHERE1";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            print "<h2>管理人</h2>";
            if (isset($rec["name"]) === true) {
                print "<div class='box'>";
                print "<h3>" . $rec['name'] . "</h3>";
                print "<div class='img'>";
                print "<img src='cms/img/" . $rec['img'] . "'>";
                print "</div>";
                print $rec["body"];
                print "</div>";
            }

            print "<h2>最近の投稿</h2>";

            $sql = "SELECT title, img, category, created_at, id FROM post ORDER BY id DESC LIMIT 0, 3";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            while (true) {
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if (empty($rec["title"]) === true) {
                    break;
                }
                print "<div id='blog_card'>";
                print "<a class='card' href='post.php?id=" . $rec['id'] . "'>";
                print "<div id='main_img'>";
                print "<img src='cms/img/" . $rec['img'] . "'>";
                print "</div>";
                print "<div id='main_text'>";
                print "カテゴリ　" . $rec["category"] . "<br>";
                print "更新日時　" . $rec["created_at"] . "<br>";
                print strip_tags($rec["title"]) . "<br>";
                print "</div>";
                print "</a>";
                print "</div>";
            }

        } catch (Exception $e) {
            print "異常";
            print $e;
            exit();
        }
        ?>
</aside>
</wrapper>
