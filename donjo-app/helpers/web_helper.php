<?php



use App\Models\TeksBerjalan;

if (! function_exists('teks_berjalan')) {
    /**
     * Ambil data teks berjalan
     *
     * @param int $tipe
     * @param int $limit
     */
    function teks_berjalan($tipe = null, $limit = null)
    {
        $teks = TeksBerjalan::status(1);

        if ($tipe) {
            $teks = $teks->tipe(3);
        }

        if ($limit) {
            $teks = $teks->limit($limit);
        }

        return $teks->get();
    }
}

if (! function_exists('menu_anjungan')) {
    /**
     * Ambil data teks berjalan
     *
     * @param int $tipe
     * @param int $limit
     */
    function menu_anjungan($tipe = null, $limit = null)
    {
        $teks = TeksBerjalan::status(1);

        if ($tipe) {
            $teks = $teks->tipe(3);
        }

        if ($limit) {
            $teks = $teks->limit($limit);
        }

        return $teks->get();
    }
}

/**
 * icon menu anjungan
 *
 * Mengembalikan path lengkap untuk icon menu anjungan
 *
 * @param mixed $nama_file
 *
 * @return string
 */
function icon_menu_anjungan($nama_file)
{
    if (is_file(FCPATH . LOKASI_ICON_MENU_ANJUNGAN . $nama_file)) {
        return base_url() . LOKASI_ICON_MENU_ANJUNGAN . $nama_file;
    }

    return base_url() . LOKASI_ICON_MENU_ANJUNGAN_DEFAULT . 'menu.png';
}
