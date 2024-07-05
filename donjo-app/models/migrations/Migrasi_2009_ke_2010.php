<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2009_ke_2010 extends MY_model
{
    public function up()
    {
        $hasil = true;

        // Migrasi fitur premium
        $hasil = $hasil && $this->jalankan_migrasi('migrasi_fitur_premium_2010');

        // Sesuaikan panjang judul dokumen menjadi 200
        $this->db->query('ALTER TABLE `dokumen` CHANGE COLUMN `nama` `nama` VARCHAR(200) NOT NULL');
        // Bolehkan C-Desa berbeda berisi nama kepemilikan sama
        $hasil = $hasil && $this->hapus_indeks('cdesa', 'nama_kepemilikan');
        // Key di setting_aplikasi seharusnya unik
        $hasil = $hasil && $this->tambahIndeks('setting_aplikasi', 'key');
        $hasil = $hasil && $this->db->query("INSERT INTO setting_aplikasi (`key`,value,keterangan) VALUES ('sebutan_nip_desa','NIPD','Pengganti sebutan label niap/nipd')
							ON DUPLICATE KEY UPDATE
							value = VALUES(value),
							keterangan = VALUES(keterangan)
							");

        return $hasil && $this->db->query('ALTER TABLE tweb_desa_pamong MODIFY COLUMN pamong_niap varchar(25) default 0');
    }
}
