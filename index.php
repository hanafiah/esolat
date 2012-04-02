<?php

include('esolat.php');



/**
 * Test data
 */
$test = new Esolat('jhr02',0);




$data = $test->getYear();
//echo '<pre>';
//print_r($data);
//echo '</pre>';
//
//exit();

echo 'Year ', '<br/>';
echo str_repeat('-', 90), '<br/>';
foreach ($data['meta'] as $row) {
    echo $row, str_repeat('&nbsp;', 5);
}
echo '<br/>';
echo str_repeat('-', 90), '<br/>';
foreach ($data['data'] as $key => $rows) {
    echo '<strong>', date("F", mktime(0, 0, 0, ($key + 1))), '</strong><br/>';
    foreach ($rows as $row) {
        foreach ($row as $data) {
            echo $data, str_repeat('&nbsp;', 10);
        }
        echo '<br/>';
    }
    echo '<br/>';
}



//echo '<hr>';
//$data = $test->getMonth();
//echo '<pre>';
//print_r($data);
//echo '</pre>';
//echo '<hr>';
//$data = $test->getDay();
//echo '<pre>';
//print_r($data);
//echo '</pre>';
//echo '<hr>';
