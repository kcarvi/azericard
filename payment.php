<html>
<head>
  <title>Payment</title>
</head>
<body>

    <form ACTION="https://testmpi.3dsecure.az/cgi-bin/cgi_link" METHOD="POST">


      <?php

        // error_reporting(E_ALL);
        // ini_set("display_errors", 1);

        $AMOUNT = '100';
        $CURRENCY = 'AZN';
        $ORDER = gmdate("YmdHis");
        
        $DESC = 'Description';
        $MERCH_NAME = 'Company';
        $MERCH_URL = 'https://www.example.com';
        $TERMINAL = '00000000';
        $EMAIL = 'mail@example.com';
        $TRTYPE = '1';
        $COUNTRY = 'AZ';
        $MERCH_GMT = '+4';
        $BACKREF = 'www.example.com';
        $LANG = 'AZ';
        $TIMESTAMP = gmdate("YmdHis");
        $NONCE = substr(md5(rand()),0,16);


        echo "
          <input name=\"AMOUNT\" value=\"{$AMOUNT}\" type=\"hidden\">
          <input name=\"CURRENCY\" value=\"{$CURRENCY}\" type=\"hidden\">
          <input name=\"ORDER\" value=\"{$ORDER}\" type=\"hidden\">
          <input name=\"DESC\" value=\"{$DESC}\" type=\"hidden\">
          <input name=\"MERCH_NAME\" value=\"{$MERCH_NAME}\" type=\"hidden\">
          <input name=\"MERCH_URL\" value=\"{$MERCH_URL}\" type=\"hidden\">
          <input name=\"MERCH_GMT\" value=\"{$MERCH_GMT}\" type=\"hidden\"> 
          <input name=\"TERMINAL\" value=\"{$TERMINAL}\" type=\"hidden\">
          <input name=\"EMAIL\" value=\"{$EMAIL}\" type=\"hidden\">
          <input name=\"TRTYPE\" value=\"{$TRTYPE}\" type=\"hidden\">    
          <input name=\"COUNTRY\" value=\"{$COUNTRY}\" type=\"hidden\"> 
          <input name=\"TIMESTAMP\" value=\"{$TIMESTAMP}\" type=\"hidden\">
          <input name=\"NONCE\" value=\"{$NONCE}\" type=\"hidden\">
          <input name=\"BACKREF\" value=\"{$BACKREF}\" type=\"hidden\">
          <input name=\"LANG\" value=\"{$LANG}\" type=\"hidden\">
        ";


        $privateKey = file_get_contents('/path/to/merchant_private_key.pem');
        $publicKey = file_get_contents('/path/to/merchant_public_key.pem');

        $to_sign = strlen($AMOUNT).$AMOUNT
              .strlen($CURRENCY).$CURRENCY
              .strlen($TERMINAL).$TERMINAL
              .strlen($TRTYPE).$TRTYPE
              .strlen($TIMESTAMP).$TIMESTAMP
              .strlen($NONCE).$NONCE
              .strlen($MERCH_URL).$MERCH_URL;


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