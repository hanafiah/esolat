<?php
include('esolat.php');
?>

<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Esolat Jakim</title>
    </head>
    <style>
        *{
            font-family: 'courier';
            font-size: 10px;
        }
    </style>
    <body>
        <h3>Usage</h3>
        <ul>
            <li><a href="http://localhost/esolat/?code=jhr02&display=year">http://localhost/esolat/?code=jhr02&display=year</a></li>
            <li><a href="http://localhost/esolat/?code=jhr02&display=month&month=4">http://localhost/esolat/?code=jhr02&display=month&month=4</a></li>
            <li><a href="http://localhost/esolat/?code=jhr02&display=day&day=3&month=4">http://localhost/esolat/?code=jhr02&display=day&day=3&month=4</a></li>
        </ul>
        <hr>
        <?php
        $code = isset($_GET['code']) ? $_GET['code'] : 'jhr2';
        $display = isset($_GET['display']) ? $_GET['display'] : 'year';
        $day = isset($_GET['day']) ? $_GET['day'] : '1';
        $month = isset($_GET['month']) ? $_GET['month'] : '1';


        switch ($display) {

            case 'year':
                year($code);
                break;
            case 'month':
                month($code, $month);
                break;
            case 'day':
                day($code, $day, $month);
                break;
            default:
                year($code);
        }

        function year($code) {
            $test = new Esolat($code);

            $today = date('d-m-Y');
            $data = $test->getYear();
            echo $data['info']['title'], '<br/>';
            echo $data['info']['location'], '<br/>';
            echo 'Kiblat : ', $data['info']['qibla'], '<br/>';

            echo str_repeat('-', 110), '<br/>';
            foreach ($data['meta'] as $row) {
                echo str_replace(" ", "&nbsp;", str_pad($row, 12, " "));
            }
            echo '<br/>';
            echo str_repeat('-', 110), '<br/>';
            foreach ($data['data'] as $key => $rows) {
                echo '<strong>', date("F", mktime(0, 0, 0, ($key + 1))), '</strong><br/>';
                foreach ($rows as $row) {
                    echo '<span ';
                    if ($row[0] == $today) {
                        echo 'style="color:red;"';
                    }
                    echo '>';
                    foreach ($row as $data) {
                        echo str_replace(" ", "&nbsp;", str_pad($data, 12, " "));
                    }
                    echo '</span>';
                    echo '<br/>';
                }
                echo '<br/>';
            }
        }

        function month($code, $month) {
            $test = new Esolat($code);

            $today = date('d-m-Y');
            $data = $test->getMonth($month);
            echo $data['info']['title'], '<br/>';
            echo $data['info']['location'], '<br/>';
            echo 'Kiblat : ', $data['info']['qibla'], '<br/>';

            echo str_repeat('-', 110), '<br/>';
            foreach ($data['meta'] as $row) {
                echo str_replace(" ", "&nbsp;", str_pad($row, 12, " "));
            }
            echo '<br/>';
            echo str_repeat('-', 110), '<br/>';
            foreach ($data['data'] as $key => $rows) {
                echo '<span ';
                if ($rows[0] == $today) {
                    echo 'style="color:red;"';
                }
                echo '>';
                foreach ($rows as $row) {

                    echo str_replace(" ", "&nbsp;", str_pad($row, 12, " "));
                }
                echo '</span>';
                echo '<br/>';
            }
        }

        function day($code, $day, $month) {
            $test = new Esolat($code);

            $today = date('d-m-Y');
            $data = $test->getDay($day, $month);

            echo $data['info']['title'], '<br/>';
            echo $data['info']['location'], '<br/>';
            echo 'Kiblat : ', $data['info']['qibla'], '<br/>';

            echo str_repeat('-', 110), '<br/>';
            foreach ($data['meta'] as $row) {
                echo str_replace(" ", "&nbsp;", str_pad($row, 12, " "));
            }
            echo '<br/>';
            echo str_repeat('-', 110), '<br/>';
            foreach ($data['data'] as $key => $row) {


                echo str_replace(" ", "&nbsp;", str_pad($row, 12, " "));
            }
            echo '<br/>';
        }
        ?>

    </body>
</html>

