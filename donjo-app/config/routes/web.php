<?php



defined('BASEPATH') || exit('No direct script access allowed');

$route['data-kelompok/(:any)'] = WEB . '/kelompok/detail/$1';
$route['data-lembaga/(:any)']  = WEB . '/lembaga/detail/$1';
$route['status-idm/(:num)']    = WEB . '/idm/index/$1';
$route['status-idm/(:num)']    = WEB . '/idm/index/$1';
$route['pemerintah']           = WEB . '/pemerintah';

// SDGS
$route['status-sdgs']    = WEB . '/sdgs/index';
$route['peta']           = WEB . '/peta/index';
$route['peraturan-desa'] = WEB . '/peraturan/index';

// Tampil Assets
$route['tampil/(:any)'] = 'dokumen_web/tampil/$1';
$route['unduh/(:any)']  = 'dokumen_web/unduh/$1';
// Buku Tamu
$route['buku-tamu/jawaban/(:num)/(:num)'] = WEB . '/buku_tamu/jawaban/$1/$2';
$route['buku-tamu/kepuasan/(:num)']       = WEB . '/buku_tamu/kepuasan/$1';
$route['buku-tamu/kepuasan']              = WEB . '/buku_tamu/kepuasan';
$route['buku-tamu/registrasi']            = WEB . '/buku_tamu/registrasi';
$route['buku-tamu']                       = WEB . '/buku_tamu/index';
