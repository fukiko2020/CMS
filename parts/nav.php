<!-- <nav id="menu" class="close"> -->
<div id="hamburger" class="menu-btn close"><span></span></div>
<nav id="nav">
    <h3>カテゴリー!!!</h3>

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

            print "<ul class='slidebar__wrapper>";

            for ($i = 0; $i < $max; $i++) {
                $n = $i + 1;
                print "<li id='slidebar$n'>" . $p_category_name[$i] . "</li>";

                $id = $p_id_list[$i];

                // $p_category_name[$i] の子メニュー取得
                $sql = "SELECT name FROM c_menu WHERE p_id=?";
                $stmt = $dbh->prepare($sql);
                $data[] = $id;
                $stmt->execute($data);

                print "<ul id='slide-bar_open$id'>";

                while (true) {
                    $rec2 = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (empty($rec2["name"]) === false) {
                        //print "<li>".$rec2['name']."</li>";
                        print "<li class='bar-child'><a href='category.php?category=" . $rec2['name'] . "'>";
                        print $rec2['name'] . "</a></li>";
                    } else {
                        // print "</ul>";
                        // $data = array();
                        break 1;
                    }
                }
                $data = array();
                print "</ul>";
            }
            print "</li>";
            $p_category_name = array();
            $p_id_list = array();
        } else {
            $maxval = json_encode(999);
        }

        print "<h3>固定ページ</h3>";
        $sql = "SELECT title, id FROM kotei WHERE1";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        while (true) {
            $rec3 = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($rec3["title"]) === true) {
                break;
            }
            $max += 1;
            print "<li id=slidebar$max class='nav-parent'><a href='kotei.php?kotei=" . $rec3['id'] . "'>";
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

    <script type="text/javascript">
        let maxval = JSON.parse("<?php echo $maxval; ?>");
    </script>

</nav>

<div id="back" class="white"></div>
<div id="scrolltop" class="st">⇧</div>
<div id="scrollmenu" class="sm">MENU</div>
<br><br>
