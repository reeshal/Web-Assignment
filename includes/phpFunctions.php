<?php
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function dateformatter($date){
    $date = str_replace('/', '-', $date );
    $newDate = date("Y-m-d", strtotime($date));
    return $newDate;
}
?>