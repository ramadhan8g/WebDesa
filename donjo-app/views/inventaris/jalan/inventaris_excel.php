<?php



$tgl = date('d_m_Y');
header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename=Jalan_Irigasi_Jaringan_' . $tgl . '.xls');
header('Pragma: no-cache');
header('Expires: 0');

include 'donjo-app/views/inventaris/jalan/inventaris_print.php';
