<?php



defined('BASEPATH') || exit('No direct script access allowed');

class MY_Security extends CI_Security
{
    /**
     * {@inheritDoc}
     */
    public function csrf_show_error()
    {
        // ==== Uncomment berikut untuk debugging masalah CSRF
        // print("<pre>".print_r(getallheaders(),true)."</pre>");
        // print("<pre>".print_r($_POST, true)."</pre>");
        // die();

        show_error(
            "Verifikasi CSRF Gagal. <br><br>
            Kembali ke halaman sebelumnya di <a href='{$_SERVER['HTTP_REFERER']}'>sini</a>, dan ulangi.<br><br>
            Kalau masih error, coba clear cache dan cookies di browser anda, dan login kembali.<br><br>
            Kalau masih bermasalah, silakan laporkan.",
            403,
            'Bad Request'
        );
    }
}
