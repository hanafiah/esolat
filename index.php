<?php
include('esolat.php');
?>

<!DOCTYPE>
<html>
    <head>
        <title>Esolat Jakim</title>
    </head>
    <style>
        *{
            font-family: 'courier';
            font-size: 10px;
        }
    </style>
    <body>
        <?php
        
$test = new Esolat('jhr02');



$data = $test->getYear();
echo 'Year ', '<br/>';
echo str_repeat('-', 110), '<br/>';
foreach ($data['meta'] as $row) {
    echo str_replace(" ", "&nbsp;",str_pad($row,12," "));
}
echo '<br/>';
echo str_repeat('-', 110), '<br/>';
foreach ($data['data'] as $key => $rows) {
    echo '<strong>', date("F", mktime(0, 0, 0, ($key + 1))), '</strong><br/>';
    foreach ($rows as $row) {
        foreach ($row as $data) {
            echo str_replace(" ", "&nbsp;",str_pad($data,12," "));
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

?>
        
    </body>
</html>

