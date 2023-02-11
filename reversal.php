<html>
<head>
  <title>Reversal</title>
</head>
<body>

    <form ACTION="https://testmpi.3dsecure.az/cgi-bin/cgi_link" METHOD="POST">


      <?php

        // error_reporting(E_ALL);
        // ini_set("display_errors", 1);

        $AMOUNT = '100';
        $CURRENCY = 'AZN';
        $ORDER = '0000000';
        $RRN = '000000000000';
        $INT_REF = '0000000000000000';
        $TERMINAL = '00000000';
        $TRTYPE = '22';
        $TIMESTAMP = gmdate("YmdHis");
        $NONCE = substr(md5(rand()),0,16);


        echo "
          <input name=\"ORDER\" value=\"{$ORDER}\" type=\"hidden\">
          <input name=\"AMOUNT\" value=\"{$AMOUNT}\" type=\"hidden\">
          <input name=\"CURRENCY\" value=\"{$CURRENCY}\" type=\"hidden\">
          <input name=\"RRN\" value=\"{$RRN}\" type=\"hidden\">
          <input name=\"INT_REF\" value=\"{$INT_REF}\" type=\"hidden\">
          <input name=\"TRTYPE\" value=\"{$TRTYPE}\" type=\"hidden\">
          <input name=\"TERMINAL\" value=\"{$TERMINAL}\" type=\"hidden\">
          <input name=\"TIMESTAMP\" value=\"{$TIMESTAMP}\" type=\"hidden\">
          <input name=\"NONCE\" value=\"{$NONCE}\" type=\"hidden\">
        ";


        $privateKey = file_get_contents('/path/to/merchant_private_key.pem');
        $publicKey = file_get_contents('/path/to/merchant_public_key.pem');

        
        $to_sign = strlen($AMOUNT).$AMOUNT
              .strlen($CURRENCY).$CURRENCY
              .strlen($TERMINAL).$TERMINAL
              .strlen($TRTYPE).$TRTYPE
              .strlen($ORDER).$ORDER
              .strlen($RRN).$RRN
              .strlen($INT_REF).$INT_REF;
              
        $MAC = $to_sign;

        $P_SIGN = '';
        openssl_sign($to_sign, $P_SIGN, $privateKey, OPENSSL_ALGO_SHA256);

        $ok = openssl_verify($to_sign, $P_SIGN, $publicKey, OPENSSL_ALGO_SHA256);

        $P_SIGN = bin2hex($P_SIGN);

        echo "<input name=\"P_SIGN\" value=\"{$P_SIGN}\" type=\"hidden\">";

      ?>

      <input alt="Submit" type="submit">

    </form> 

  </body>
</html>