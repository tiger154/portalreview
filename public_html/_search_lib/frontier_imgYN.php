<?php

//$mysqli = new mysqli("121.189.18.73", "revu39", "revu39#1212!", "revu39");
//
///* check connection */
//if (mysqli_connect_errno()) {
//    printf("Connect failed: %s\n", mysqli_connect_error());
//    exit();
//}
//
//$query = "SELECT frid FROM Ru_frontier_orinfo ORDER by frno DESC ";
//
//if ($result = $mysqli->query($query)) {
//
//    /* fetch associative array */
//    while ($row = $result->fetch_assoc()) {
//        printf ("%s \n", $row["frid"]);
//    }
//
//    /* free result set */
//    $result->free();
//}
//
///* close connection */
//$mysqli->close();
echo mb_strimwidth("Hello World", 0, 10, "");
//echo mb_strimwidth("[라떼킹]서울숲 라떼킹에서 수다를", 0, 10, "...");

?>
