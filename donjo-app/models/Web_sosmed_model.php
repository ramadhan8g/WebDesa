<?php



class Web_sosmed_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_sosmed($sosmed)
    {
        $id = $this->get_id($sosmed);

        return $this->db->where('id', $id)->get('media_sosial')->row_array();
    }

    public function list_sosmed()
    {
        return $this->db->get('media_sosial')->result_array();
    }

    public function get_id($sosmed)
    {
        $list_sosmed = $this->list_sosmed();

        foreach ($list_sosmed as $list) {
            $nama = str_replace(' ', '-', strtolower($list['nama']));

            if ($nama == $sosmed) {
                return $list['id'];
            }
        }
    }

    public function update($sosmed)
    {
        $id = $this->get_id($sosmed);

        $data = $this->input->post();
        $link = trim(strip_tags($this->input->post('link')));

        // untuk youtube validasi dilakukan khusus
        if ($id === '4') {
            $data['link'] = $this->link_sosmed($id, $link);
        } else {
            $data['link'] = $link;
        }

        $this->db->where('id', $id);
        $outp = $this->db->update('media_sosial', $data);

        status_sukses($outp); //Tampilkan Pesan
    }

    // Penanganan khusus sesuai jenis sosmed
    public function link_sosmed($id = 0, $link = '', $tipe = 1)
    {
        if (empty($link)) {
            return $link;
        }

        // list domain yang akan digunakan untuk ditambahkan protokol https
        // ini digunakan untuk cek apakah mengandung string domain dibawah atau tidak
        // jika $link tidak ada protokol http/https maka akan ditambahkan terlebih dahulu
        $list_domain = [
            'facebook.com',
            'instagram.com',
            't.me',
            'telegram.me',
            'twitter.com',
            'whatsapp.com',
            'youtube.com',
        ];

        foreach ($list_domain as $key) {
            if (strpos($link, $key) !== false) {
                // tambahkan https di awal link
                $link = preg_replace('/^http:/i', 'https:', prep_url($link));
            }
        }

        // validasi nickname youtube
        if ($id === '4' && str_contains($link, '@')) {
            /**
             * https://support.google.com/youtube/answer/11585688?hl=id&p=handles_info&rd=1
             * 24 Januari 2023
             * - Berisi antara 3-30 karakter
             * - Terdiri atas karakter alfanumerik (A–Z, a–z, 0–9)
             * - Nama sebutan channel Anda juga dapat menyertakan garis bawah (_), tanda hubung (-), dan titik (.)
             * - Tidak menyerupai URL atau nomor telepon
             */
            $pattern = '/@[A-Za-z][A-Za-z0-9_\\-.]{2,29}/i';
            if (preg_match_all($pattern, $link, $matches)) {
                $nickname = array_shift(array_shift($matches));
                $link     = 'https://www.youtube.com/' . $nickname;
            } else {
                $link = '';
            }

            return $link;
        }
        // Remove all illegal characters from a url
        // remove `@` with ''
        $link = str_replace('@', '', $link);
        $link = filter_var($link, FILTER_SANITIZE_URL);

        // validasi link
        $valid_link = filter_var($link, FILTER_VALIDATE_URL);

        switch (true) {
            case $id === '1' && $tipe === '1':
                $link = ($valid_link ? $link : 'https://web.facebook.com/' . $link);
                break;

            case $id === '1' && $tipe === '2':
                $link = ($valid_link !== false ? $link : 'https://web.facebook.com/groups/' . $link);
                break;

            case $id === '2':
                $link = ($valid_link !== false ? $link : 'https://twitter.com/' . $link);
                break;

            case $id === '4':
                $link = ($valid_link !== false ? $link : 'https://www.youtube.com/channel/' . $link);
                break;

            case $id === '5':
                $link = ($valid_link !== false ? $link : 'https://www.instagram.com/' . $link . '/');
                break;

            case $id === '6' && $tipe === '1':
                $link = ($valid_link !== false ? $link : 'https://api.whatsapp.com/send?phone=' . $link);
                $link = str_replace('phone=0', 'phone=62', $link);
                break;

            case $id === '6' && $tipe === '2':
                $link = ($valid_link !== false ? $link : 'https://chat.whatsapp.com/' . $link);
                break;

            case $id === '7' && $tipe === '1':
                $link = ($valid_link !== false ? $link : 'https://t.me/' . $link);
                break;

            case $id === '7' && $tipe === '2':
                $link = ($valid_link !== false ? $link : 'https://t.me/joinchat/' . $link);
                break;

            default:
        }

        return $link;
    }
}
