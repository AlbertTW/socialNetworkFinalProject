<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="http://arwen.cs.nccu.edu.tw/~stanley10603/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="http://arwen.cs.nccu.edu.tw/~stanley10603/css/final.css" rel="stylesheet" media="screen">
        <title>註冊資料 - 揪球友</title>
    </head>

    <body>

        <?php
        $ball = $_POST[ball]; // 喜好球類
        $place = $_POST[place]; // 常活動地點
        $timeslot = $_POST[timeslot]; // 常活動時段
        $userID = $_POST[userID];     // FB_ID
        $userNAME = $_POST[userNAME]; // FB_NAME
        //==========
        $ball_like = "0,0,0,0"; // 喜好球類(bool)
        $Monday = "0,0,0";
        $Tuesday = "0,0,0";  // 常活動時段(bool)
        $Wednesday = "0,0,0";
        $Thursday = "0,0,0";
        $Friday = "0,0,0";
        $Saturday = "0,0,0";
        $Sunday = "0,0,0";
        $mysqli = new mysqli("xxxxxxx", "xxxxxxx", "xxxxxxx", "xxxxxxx");
        // 主機, 帳號, 密碼, 資料庫名稱
        //==========將註冊資料存進資料庫
        if (!$place && !$userID && !$userNAME) { // 必須欄位
            printf("Error input:" . $mysqli->error);
        } else if (($place && $userID && $userNAME) != NULL) {
            $input_query = "INSERT INTO `Account` (`userID` , `userNAME` , `place`, `ball`, `Monday`, `Tuesday`, `Wednesday`, `Thursday`, `Friday`, `Saturday`, `Sunday`) VALUES ";
            //==========處理喜好球類
            for ($i = 0 ; $i < count($ball) ; $i++ ) { //使用者勾選幾種球(count)
                if ($ball[$i] == "PingPong") {
                    $ball_like[0] = 1;
                } else if ($ball[$i] == "Basketball") {
                    $ball_like[2] = 1;
                } else if ($ball[$i] == "Tennis") {
                    $ball_like[4] = 1;
                } else if ($ball[$i] == "Volley") {
                    $ball_like[6] = 1;
                }
            }
            //==========處理常活動時段
            $j = 1;
            for ( $i = 0 ; $i < count($timeslot) ; $i++ ) { //使用者勾選幾個時段(count)
                for ( ; $j <= 21 ; $j++) { // 總共21個時段
                    if ($timeslot[$i] == $j ) { // 找到有勾選的時段,開始暴力法塞資料
                        if ( $j == 1 ) {
                            $Monday[0] = 1;
                        } else if ( $j == 8 ) {
                            $Monday[2] = 1;
                        } else if ( $j == 15 ) {
                            $Monday[4] = 1;
                                } else if ( $j == 2 ) {
                                    $Tuesday[0] = 1;
                                } else if ( $j == 9 ) {
                                    $Tuesday[2] = 1;
                                } else if ( $j == 16 ) {
                                    $Tuesday[4] = 1;
                                        } else if ( $j == 3 ) {
                                            $Wednesday[0] = 1;
                                        } else if ( $j == 10 ) {
                                            $Wednesday[2] = 1;
                                        } else if ( $j == 17 ) {
                                            $Wednesday[4] = 1;
                                            } else if ( $j == 4 ) {
                                                $Thursday[0] = 1;
                                            } else if ( $j == 11 ) {
                                                $Thursday[2] = 1;
                                            } else if ( $j == 18 ) {
                                                $Thursday[4] = 1;
                                                } else if ( $j == 5 ) {
                                                    $Friday[0] = 1;
                                                } else if ( $j == 12 ) {
                                                    $Friday[2] = 1;
                                                } else if ( $j == 19 ) {
                                                    $Friday[4] = 1;
                                                    } else if ( $j == 6 ) {
                                                        $Saturday[0] = 1;
                                                    } else if ( $j == 13 ) {
                                                        $Saturday[2] = 1;
                                                    } else if ( $j == 20 ) {
                                                        $Saturday[4] = 1;
                                                        } else if ( $j == 7 ) {
                                                            $Sunday[0] = 1;
                                                        } else if ( $j == 14 ) {
                                                            $Sunday[2] = 1;
                                                        } else if ( $j == 21 ) {
                                                            $Sunday[4] = 1;
                                                        }
                        break;
                    } 
                }
            }
            //==========把資料放進query
            $input_query .= "('" . $userID . "','" . $userNAME . "','" . $place . "','" . $ball_like . "','" . $Monday . "','" . $Tuesday . "','" . $Wednesday . "','" . $Thursday . "','" . $Friday . "','" . $Saturday . "','" . $Sunday . "')";
            mysqli_query($mysqli, "SET CHARACTER SET UTF8");
            //==========check connection
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }

            if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') '
                        . $mysqli->connect_error);
            }

            if (mysqli_connect_error()) {
                die('Connect Error (' . mysqli_connect_errno() . ') '
                        . mysqli_connect_error());
            }

            $return = $mysqli->query($input_query);

            if ($return == 1) {
                echo "<br>註冊成功!!<br>";
            } else {
                echo "<br>您已經註冊過囉!!<br>";
                //echo "Errormessage: " . $mysqli->error;
            }
        }
        //==========close connection
        $mysqli->close();
        //==========close connection
        /* // 測試
        echo "ball:" . $ball . "<br>";
        echo "ball:" . $ball[0] . "<br>";
        echo "place:" . $place . "<br>";
        echo "timeslot:" . $timeslot . "<br>";

        echo "ball: <br>";
        print_r($ball);
        echo "<br>";
        echo "place: " . $place . " <br>";
        echo "timeslot: <br>";
        print_r($timeslot);
        echo "<br>";

        echo "userID:" . $userID . "<br>";
        echo "userNAME:" . $userNAME . "<br>";
        */
        //==========將註冊資料顯示於網頁
        echo "<div id='userInfo'>";
        echo "<img src='https://graph.facebook.com/" . $userID . "/picture?type=large'> <br>";
        echo "userNAME: " . $userNAME . "<br><br><br>";

        echo "</div>";

        echo "<div id='chooseBall'>";

        echo "您喜好的球類: <br>";
        for ($i = 0; $i < count($ball); $i++) {
            echo "<img width='60' height='60' src='img/" . $ball[$i] . ".png' alt='" . $ball[$i] . "' align='center'>";
            echo $ball[$i] . "  ";
        }
        echo "<br><br>";
        echo "</div>";

        echo "<div id='choosePlace'>";

        echo "您常活動的地區:<br>";

        if ($place == 1)
            echo "北部";
        elseif ($place == 2)
            echo "中部";
        elseif ($place == 3)
            echo "南部";
        elseif ($place == 4)
            echo "東部";

        echo "<br><br>";
        echo "</div>";

        echo "<div id='chooseTime'>";

        echo "您常活動的時段: <br>";
        echo "<table cellpadding='20' border='1'>";
        echo "<tbody>";

        $k = 0;
        $temp = 0;
        for ($i = 0; $i < 4; $i++) {
            echo "<tr>";

            for ($j = 0; $j <= 7; $j++) {
                if ($j == 0) {
                    if ($i == 0)
                        echo "<td></td>";
                    elseif ($i == 1)
                        echo "<td>上午</td>";
                    elseif ($i == 2)
                        echo "<td>中午</td>";
                    elseif ($i == 3)
                        echo "<td>晚上</td>";
                }
                else {
                    if ($i == 0)
                        echo "<td>" . $j . "</td>";
                    else {
                        $temp = ($i - 1) * 7 + $j;
                        echo "<td id='timeslot" . $temp . "'>";
                        if ($timeslot[$k] == $temp) {
                            echo "v";
                            //echo "v" . "位置= $k" . "值= $temp";
                            $k = $k + 1;
                        }
                        echo "</td>";
                    }
                }
            }

            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "<br><br>";
        echo "</div>";
        ?>

        <input type='button' name='backBtn' id='backBtn' value='回首頁' onclick='javascript:location.href = "index.html"' />

    </body>

</html>
