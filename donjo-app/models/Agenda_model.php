<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Agenda_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data)
    {
        return $this->db->insert('agenda', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);

        return $this->db->update('agenda', $data);
    }
}
