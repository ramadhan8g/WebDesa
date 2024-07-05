<?php



defined('BASEPATH') || exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Konfigurasi aplikasi di simpan di tabel setting_aplikasi dan dibaca di
| setting_aplikasi.php.
| File ini berisi setting khusus yang tidak disimpan di database.
| Untuk mengubah letakkan setting yang diinginkan di desa/config/config.php
|--------------------------------------------------------------------------
*/
// Ambil setting SID khusus
define('LOKASI_SID_INI', 'desa/config/');

/*
|--------------------------------------------------------------------------
| Ambil setting konfigurasi dari database
|--------------------------------------------------------------------------
*/
$config['useDatabaseConfig'] = true;

/*
    Uncomment baris berikut untuk menampilkan setting development
    di halaman setting aplikasi.
    Perlu di-setting di sini karena index.php dijalankan
    sesudah pembacaan konfigurasi dari database di setting_model.php
*/
// $config["environment"] = "development";

// Untuk situs yang digunakan untuk demo, seperti https://demosid.opendesa.id
$config['demo_mode'] = false;

// Data id penduduk dan pin layanan mandiri yang digunakan sebagai default akun demo
$config['demo_akun'] = [
    1 => '123456',
    2 => '234561',
    3 => '345612',
];

$config['demo_user'] = [
    'username' => 'admin',
    'password' => 'sid304',
];

// Delay kirim pesan layanan mandiri web, dalam satuan detik
$config['rentang_kirim_pesan'] = 60;

// ==========================================================================

// Konfigurasi tambahan untuk aplikasi
$extra_app_config = FCPATH . LOKASI_SID_INI . 'config.php';
if (is_file($extra_app_config)) {
    require_once $extra_app_config;
} else {
    // Harus ada config. Config ini tidak dipakai.
    $config['ini'] = '';
}

/**
 * Hapus index.php dari url bila ditemukan .htaccess
 * Untuk menggunakan fitur ini, pastikan konfigurasi apache di server SID
 * mengizinkan penggunaan .htaccess
 */
if (file_exists(FCPATH . '.htaccess') && ENVIRONMENT != 'development') {
    $config['index_page'] = '';
}

// End of file sid_ini.php
// Location: ./application/config/sid_ini.php
