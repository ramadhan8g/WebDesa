<?php



header('Content-type: application/xls');
header('Content-Disposition: attachment; filename=rtm_' . date('Y-m-d') . '.xls');
header('Pragma: no-cache');
header('Expires: 0');

$this->load->view('rtm/rtm_cetak');
