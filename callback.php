<?php

foreach ($_REQUEST as $key => $value) 
    file_put_contents($_SERVER["DOCUMENT_ROOT"].'/path/to/log.txt', $key . ' -> ' . $value ."\n", FILE_APPEND);


if($_REQUEST["ACTION"] != "" && $_REQUEST['RC'] != "") {

  $respAction = $_REQUEST['ACTION'];
  $respRc = $_REQUEST['RC'];
  $respOrder = $_REQUEST['ORDER'];
  $respAmount = $_REQUEST['AMOUNT'];

  $order_id = intval($respOrder);

  if($order_id > 0) {
    if($respAction == "0" && $respRc == "00") {

      // change order status
      
    }
  }
}

?>