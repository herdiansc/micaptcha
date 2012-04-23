<?php
define('CAPTCHA_TITLE','CAPTCHA');
define('CAPTCHA_HELP_HINT','Keterangan.&#10;- Susun potongan gambar dengan urutan dari 1 s.d. 4.&#10;- Dari kiri ke kanan.&#10;- Dari atas ke bawah.');


define('CAPTCHA_ROW',2);
define('CAPTCHA_COL',2);
define('CAPTCHA_IS_WATERMARK',true);
define('CAPTCHA_SHOW_TITLE',true);

/*
 *
 * Diisi null maka lebar dan tinggi gambar akan dibagi dua dari lebar dan tinggi aslinya
 *
 **/
define('CAPTCHA_WIDTH',200);
define('CAPTCHA_HEIGHT',200);

define('CAPTCHA_SALT',sha1('key'));
?>
