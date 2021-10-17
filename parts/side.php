<div class="side__wrapper">
    <div class="side__box">
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
                print "<div class='side-box__content'>";
                for ($i = 0; $i < $max; $i++) {
                    $n = $i + 1;
                    print "<div class='side__category'>" . $p_category_name[$i] . "</div>";

                    $id = $p_id_list[$i];

                    $sql = "SELECT name FROM c_menu WHERE p_id=?";
                    $stmt = $dbh->prepare($sql);
                    $data[] = $id;
                    $stmt->execute($data);

                    print "<ul class='side-box__content'>";

                    while (true) {
                        $rec2 = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (empty($rec2["name"]) === false) {
                            print "<li><a href='category.php?category=" . $rec2['name'] . "'>";
                            print $rec2['name'] . "</a></li>";
                        } else {
                            break 1;
                        }
                    }
                    $data = array();
                    print "</ul>";
                }
                print "</div>";
            }
            print "</div>";

            print "<div class='side__box'>";
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
                print "<div class='side-box__content'>";
                for ($i = 0; $i < $max2; $i++) {
                    print "<a href='kotei.php?kotei=" . $id2[$i] . "'>";
                    print strip_tags($title2[$i]);
                    print "</a>";
                    // print "<br>";
                }
                print "</div>";
            }
            print "</div>";

            $sql = "SELECT * FROM profile WHERE1";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            print "<div class='side__box'>";
            print "<h2>管理人</h2>";
            if (isset($rec["name"]) === true) {
                print "<div class='side__selfintro'>";
                print "<div class='side__selfintro--img'>";
                print "<img src='cms/img/" . $rec['img'] . "'>";
                print "</div>";
                print "<div class='side__selfintro--str'>";
                print "<h3>" . $rec['name'] . "</h3>";
                print "<p>" . $rec["body"] . "</p>";
                print "</div>";
                print "</div>";
            }
            print "</div>";

            print"<div class='side__box'>";
            print "<h2>最近の投稿</h2>";

            $sql = "SELECT title, category, created_at, id FROM post ORDER BY id DESC LIMIT 0, 3";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            while (true) {
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if (empty($rec["title"]) === true) {
                    break;
                }
                print "<div id='blog_card' class='side__blog-card'>";
                print "<a class='card' href='post.php?id=" . $rec['id'] . "'>";
                print "<div>" . strip_tags($rec["title"]) . "</div>";
                print "<div id='side__card-text' class='side__card-text'>";
                print "<span>#" . $rec["category"] . "</span>";
                print "<span>" . $rec["created_at"] . "</span>";
                print "</div>";
                print "</a>";
                print "</div>";
            }
            print "</div>";

        } catch (Exception $e) {
            print "異常";
            print $e;
            exit();
        }
        ?>
</div>  <!-- side-wrapper -->
</wrapper>
