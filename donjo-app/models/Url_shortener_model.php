<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Url_shortener_model extends CI_Model
{
    public function url_pendek($log_surat = [])
    {
        $urls_id = $log_surat['urls_id'];

        if ($urls_id) {
            $id = $urls_id;
        } else {
            $url = site_url("c1/{$log_surat['id']}");
            $id  = $this->add_url($url);
        }
        $urlData = $this->getUrlById($id);

        return [
            'isiqr'   => site_url('v/' . $urlData->alias),
            'urls_id' => $id,
        ];
    }

    public function add_url($url)
    {
        $data = [
            'url'     => (string) $url,
            'alias'   => (string) $this->random_code(6),
            'created' => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('urls', $data);

        return $this->db->insert_id();
    }

    public function getUrlById($id)
    {
        return $this->db->get_where('urls', ['id' => (int) $id])->row();
    }

    public function get_url($alias)
    {
        $this->db->select('*');
        $this->db->from('urls');
        $this->db->where('alias', (string) $alias);
        $result = $this->db->get()->row_object();

        return (count($result) > 0) ? $result : false;
    }

    public function random_code($length)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
    }

    public function encode_id($plainText)
    {
        $key         = $this->config->item('encryption_url') . time();
        $random_code = $this->random_code(20);
        $base64      = base64_encode($random_code . ',' . $plainText . ',' . $key . ',' . $plainText);
        $base64url   = strtr($base64, '+/=', '-  ');

        return trim($base64url);
    }

    public function decode_id($plainText)
    {
        $base64url = strtr($plainText, '-  ', '+/=');
        $base64    = base64_decode($base64url, true);
        $exp       = explode(',', $base64);

        return ($exp[1] != $exp[3]) ? $plainText : $exp[1];
    }
}
