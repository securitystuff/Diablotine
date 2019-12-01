<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";
$ip = $_SERVER['REMOTE_ADDR'];
$date = date('d-m-Y H:i:s');
$dcode = $_SERVER['QUERY_STRING']; 
$dcode = preg_replace("/[^a-zA-Z0-9@-]/", "-", $dcode);
$unid = strtok($dcode, '-');
$unid = preg_replace('/\D/', '', $unid);
$output1 = preg_replace('/^[^-]*-\s*/', '', $dcode);
$name = preg_replace('/^[^-]*-\s*/', '', $output1);
preg_match('~-(.*?)-~', $dcode, $output2);
$code = $output2[1];
$connect = new mysqli($servername, $username, $password, $dbname);
$query1 = $connect->query("SELECT DISTINCT unid FROM user WHERE unid > ''");
$query2 = "INSERT INTO user (ip, date, dcode, unid) VALUES ('$ip', '$date', '$dcode', '$unid')";
$query3 = "INSERT INTO cnc (unid, date, code, name) VALUES ('$unid', '$date', '$code', '$name')";
$query4 = "UPDATE cnc SET date = '$date', code = '$code', name = '$name' WHERE unid = '$unid'";
$result = $connect->query("SELECT * FROM cnc WHERE unid = '$unid'");
if (strlen(strstr($dcode, 'UNID')) > 0) {
    while($row = mysqli_fetch_array($query1)) {
        echo $row['unid']."\n";
    }
} else {
    if( mysqli_num_rows($result) > 0) {
        $connect->query($query4);
    } else {
        $connect->query($query3);
    }
    $connect->query($query2);
    $connect->close();
    print gmdate("Y-m-d H:i:s");
}
