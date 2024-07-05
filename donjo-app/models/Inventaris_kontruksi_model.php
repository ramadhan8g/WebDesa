<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Inventaris_kontruksi_model extends CI_Model
{
    protected $table        = 'inventaris_kontruksi';
    protected $table_mutasi = 'mutasi_inventaris_kontruksi';

    public function __construct()
    {
        parent::__construct();
    }

    public function list_inventaris()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($this->table . '.visible', 1);

        return $this->db->get()->result();
    }

    public function sum_inventaris()
    {
        $this->db->select_sum('harga');
        $this->db->where($this->table . '.visible', 1);
        $this->db->where($this->table . '.status', 0);
        $result = $this->db->get($this->table)->row();

        return $result->harga;
    }

    public function sum_print($tahun)
    {
        $this->db->select_sum('harga');
        $this->db->where($this->table . '.visible', 1);
        $this->db->where($this->table . '.status', 0);
        if ($tahun != 1) {
            $this->db->where('year(tanggal_dokument)', $tahun);
        }
        $result = $this->db->get($this->table)->row();

        return $result->harga;
    }

    public function list_mutasi_inventaris()
    {
        $this->db->select('mutasi_inventaris_kontruksi.id as id,mutasi_inventaris_kontruksi.*, inventaris_kontruksi.nama_barang, inventaris_kontruksi.kode_barang, inventaris_kontruksi.tanggal_dokument');
        $this->db->from($this->table_mutasi);
        $this->db->where($this->table_mutasi . '.visible', 1);
        // $this->db->where('status_mutasi', 'Hapus');
        $this->db->join($this->table, $this->table . '.id = ' . $this->table_mutasi . '.id_inventaris_kontruksi', 'left');

        return $this->db->get()->result();
    }

    public function add($data)
    {
        $this->db->insert($this->table, array_filter($data));
        $id = $this->db->insert_id();

        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function add_mutasi($data)
    {
        $this->db->insert($this->table_mutasi, array_filter($data));
        $id = $this->db->insert_id();
        $this->db->update($this->table, ['status' => 1], ['id' => $data['id_inventaris_kontruksi']]);

        return $this->db->get_where($this->table_mutasi, ['id' => $id])->row();
    }

    public function view($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($this->table . '.id', $id);

        return $this->db->get()->row();
    }

    public function view_mutasi($id)
    {
        $this->db->select('mutasi_inventaris_kontruksi.id as id,mutasi_inventaris_kontruksi.*, inventaris_kontruksi.nama_barang, inventaris_kontruksi.kode_barang, inventaris_kontruksi.tanggal_dokument, inventaris_kontruksi.register');
        $this->db->from($this->table_mutasi);
        $this->db->where($this->table_mutasi . '.id', $id);
        $this->db->join($this->table, $this->table . '.id = ' . $this->table_mutasi . '.id_inventaris_kontruksi', 'left');

        return $this->db->get()->row();
    }

    public function edit_mutasi($id)
    {
        $this->db->select('mutasi_inventaris_kontruksi.id as id,mutasi_inventaris_kontruksi.*, inventaris_kontruksi.nama_barang, inventaris_kontruksi.kode_barang, inventaris_kontruksi.tanggal_dokument, inventaris_kontruksi.register');
        $this->db->from($this->table_mutasi);
        $this->db->where($this->table_mutasi . '.id', $id);
        $this->db->join($this->table, $this->table . '.id = ' . $this->table_mutasi . '.id_inventaris_kontruksi', 'left');

        return $this->db->get()->row();
    }

    public function delete($id)
    {
        return $this->db->update($this->table, ['visible' => 0], ['id' => $id]);
    }

    public function delete_mutasi($id)
    {
        return $this->db->update($this->table_mutasi, ['visible' => 0], ['id' => $id]);
    }

    public function update($id, $data)
    {
        $id = $this->input->post('id');

        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function update_mutasi($id, $data)
    {
        $id = $this->input->post('id');

        return $this->db->update($this->table_mutasi, $data, ['id' => $id]);
    }

    public function cetak($tahun)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($this->table . '.status', 0);
        $this->db->where($this->table . '.visible', 1);
        if ($tahun != 1) {
            $this->db->where('year(tanggal_dokument)', $tahun);
        }
        $this->db->order_by('year(tanggal_dokument)', 'asc');

        return $this->db->get()->result();
    }
}
