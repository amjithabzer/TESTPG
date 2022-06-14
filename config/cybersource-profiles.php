<?php

/* Cybersource Secure Acceptance W/M Profile Config*/
define('MERCHANT_ID', 'ni_network_aed');
define('PROFILE_ID',  '907670F3-3862-4F93-AF37-A4D6E87E56B1');
define('ACCESS_KEY',  '757c2ea8687d3ed7884d58abf1c4a1e3');
define('SECRET_KEY',  'fe72c0fe58dc4cfe87e19e6c308300e96550b75728394234ac2c47ac66d574175550d26109984d468be628ec55221a8249c76f2b50fd4b5ebe296e7d88343778d311b825f0d842b3b09bdbf08abd8c38c77754b7b9cc40bf9516212e900c2f270fba33afa696475c94fbf3ea936c3db26a52b4c15af24d0f8817ccdeb32087ed');

// define('MERCHANT_ID', 'adcb_120800000352_aed');
// define('PROFILE_ID',  '907670F3-3862-4F93-AF37-A4D6E87E56B1');
// define('ACCESS_KEY',  '757c2ea8687d3ed7884d58abf1c4a1e3');
// define('SECRET_KEY',  'fe72c0fe58dc4cfe87e19e6c308300e96550b75728394234ac2c47ac66d574175550d26109984d468be628ec55221a8249c76f2b50fd4b5ebe296e7d88343778d311b825f0d842b3b09bdbf08abd8c38c77754b7b9cc40bf9516212e900c2f270fba33afa696475c94fbf3ea936c3db26a52b4c15af24d0f8817ccdeb32087ed');

//3DS Global VAriables
define ('HMAC_SHA256', 'sha256');
define ('SECRET_KEY_3DS', 'b8346bf8-27fb-458f-b55f-9fc03c42e4b7');
define ('API_KEY_3DS', '6143b939108ea304b68fb390');
define ('ORG_ID_3DS', '5925760a8cb2c129942b0f9b');

// define ('HMAC_SHA256', 'sha256');
// define ('SECRET_KEY_3DS', '741021f6-d349-484d-8cc9-4bd325525a7c');
// define ('API_KEY_3DS', '6251992ecd8f13735d7610eb');
// define ('ORG_ID_3DS', '611e481e31be4849bdd48cfa');
//REST API KEYS
//this is the key that we need to run from website API TEST
define('REST_KEY',  '6f756c5e-e1e8-4343-810b-e38ee08fe1af');
define('REST_SECRET_KEY',  'PKdc9urH4vD/puHc7Kd07JVQRWxbgdYVbWiJjpq8O4E=');


// DF TEST: 1snn5n9w, LIVE: k8vif92e
define('DF_ORG_ID', '1snn5n9w');

// PAYMENT URL
define('CYBS_BASE_URL', 'https://testsecureacceptance.cybersource.com');

define('PAYMENT_URL', CYBS_BASE_URL . '/pay');
// define('PAYMENT_URL', '/sa-sop/debug.php');

define('TOKEN_CREATE_URL', CYBS_BASE_URL . '/token/create');
define('TOKEN_UPDATE_URL', CYBS_BASE_URL . '/token/update');

// EOF Secure Acceptance W/M

 /* Cybersource Silnet Order Profile Config*/
// define('MERCHANT_ID', ''); Merchant Id is Unique in two cases
define('PROFILE_ID_S',  '');
define('ACCESS_KEY_S',  '');
define('SECRET_KEY_S',  '');

// DF TEST: 1snn5n9w, LIVE: k8vif92e
define('DF_ORG_ID_S', '1snn5n9w');

// PAYMENT URL
define('CYBS_BASE_URL_S', 'https://testsecureacceptance.cybersource.com/silent');

define('PAYMENT_URL_S', CYBS_BASE_URL_S . '/pay');
// define('PAYMENT_URL', '/sa-sop/debug.php');

define('TOKEN_CREATE_URL_S', CYBS_BASE_URL_S . '/token/create');
define('TOKEN_UPDATE_URL_S', CYBS_BASE_URL_S . '/token/update');

// EOF Silnet Order
