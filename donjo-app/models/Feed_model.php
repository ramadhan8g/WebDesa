<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Feed_model extends CI_Model
{
    public const STATIS = 999;
    public const AGENDA = 1000;
    public const ENABLE = 1;

    public function list_feeds()
    {
        $this->db->select('a.*, u.nama AS owner, k.kategori, k.slug AS kat_slug, YEAR(tgl_upload) AS thn, MONTH(tgl_upload) AS bln, DAY(tgl_upload) AS hri')
            ->from('artikel a')
            ->join('user u', 'a.id_user = u.id', 'left')
            ->join('kategori k', 'a.id_kategori = k.id', 'left')
            ->where('a.enabled', static::ENABLE)
            ->where('tgl_upload < NOW()') // jangan tampilkan yg belum di-publish
            ->where_not_in('a.id_kategori', [static::STATIS, static::AGENDA])
            ->order_by('a.tgl_upload', 'DESC')
            ->limit('50');

        return $this->db->get()->result();
    }
}
