<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Aset_model extends CI_Model
{
    protected $table = 'tweb_aset';

    public function list_aset($golongan = null)
    {
        return $this->db
            ->where('golongan', $golongan)
            ->get_where($this->table)
            ->result_array();
    }
}
