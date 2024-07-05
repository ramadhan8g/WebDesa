<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Lapor_model extends CI_Model
{
    // Dipakai di penduduk, surat master dan surat fmandiri
    public function get_surat_ref_all()
    {
        $this->db->select('*')
            ->from('ref_syarat_surat');
        $query = $this->db->get();

        return $query->result_array();
    }

    // Dipakai di surat master
    public function update_syarat_surat($surat_format_id, $syarat_surat, $mandiri = 0)
    {
        if (empty($surat_format_id)) {
            return false;
        }

        if ($mandiri == 1) {
            // Update syarat baru yg dipilih
            $this->db
                ->where('id', $surat_format_id)
                ->update('tweb_surat_format', ['syarat_surat' => json_encode($syarat_surat)]);
        }
    }
}
