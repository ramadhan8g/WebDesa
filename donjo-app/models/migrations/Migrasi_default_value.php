<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_default_value extends CI_model
{
    public function up()
    {
        $this->dbforge->modify_column('tweb_penduduk', ['id_rtm' => ['id_rtm', 'type' => 'VARCHAR(30)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['rtm_level' => ['rtm_level', 'type' => 'INT(11)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['tempatlahir' => ['tempatlahir', 'type' => 'VARCHAR(100)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['agama_id' => ['agama_id', 'type' => 'INT(1)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['pendidikan_kk_id' => ['pendidikan_kk_id', 'type' => 'INT(1)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['pendidikan_sedang_id' => ['pendidikan_sedang_id', 'type' => 'INT(1)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['pekerjaan_id' => ['pekerjaan_id', 'type' => 'INT(1)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['status_kawin' => ['status_kawin', 'type' => 'TINYINT', 'null' => true]]);
        $this->dbforge->modify_column('tweb_penduduk', ['ayah_nik' => ['ayah_nik', 'type' => 'VARCHAR(16)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['ibu_nik' => ['ibu_nik', 'type' => 'VARCHAR(16)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['nama_ayah' => ['nama_ayah', 'type' => 'VARCHAR(100)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['nama_ibu' => ['nama_ibu', 'type' => 'VARCHAR(100)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['foto' => ['foto', 'type' => 'VARCHAR(100)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['golongan_darah_id' => ['golongan_darah_id', 'type' => 'INT(11)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['alamat_sebelumnya' => ['alamat_sebelumnya', 'type' => 'VARCHAR(200)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['alamat_sekarang' => ['alamat_sekarang', 'type' => 'VARCHAR(200)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['akta_lahir' => ['akta_lahir', 'type' => 'VARCHAR(40)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['akta_perkawinan' => ['akta_perkawinan', 'type' => 'VARCHAR(40)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['akta_perceraian' => ['akta_perceraian', 'type' => 'VARCHAR(40)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk', ['waktu_lahir' => ['waktu_lahir', 'type' => 'VARCHAR(5)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk_agama', ['nama' => ['nama', 'type' => 'VARCHAR(100)', 'null' => false]]);
        $this->dbforge->modify_column('tweb_penduduk_asuransi', ['nama' => ['nama', 'type' => 'VARCHAR(50)', 'null' => false]]);
        $this->dbforge->modify_column('tweb_penduduk_hubungan', ['nama' => ['nama', 'type' => 'VARCHAR(100)', 'null' => false]]);
        $this->dbforge->modify_column('tweb_penduduk_kawin', ['nama' => ['nama', 'type' => 'VARCHAR(100)', 'null' => false]]);
        $this->dbforge->modify_column('tweb_penduduk_mandiri', ['pin' => ['pin', 'type' => 'CHAR(32)', 'null' => false]]);
        $this->dbforge->modify_column('tweb_penduduk_map', ['id' => ['id', 'type' => 'INT(11)', 'null' => false]]);
        $this->dbforge->modify_column('tweb_penduduk_map', ['lat' => ['lat', 'type' => 'VARCHAR(24)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk_map', ['lng' => ['lng', 'type' => 'VARCHAR(24)', 'null' => true, 'default' => null]]);
        $this->dbforge->modify_column('tweb_penduduk_pendidikan', ['nama' => ['nama', 'type' => 'VARCHAR(50)', 'null' => false]]);
        $this->dbforge->modify_column('tweb_penduduk_pendidikan_kk', ['nama' => ['nama', 'type' => 'VARCHAR(50)', 'null' => false]]);
        $this->dbforge->modify_column('tweb_rtm', ['kelas_sosial' => ['kelas_sosial', 'type' => 'INT(11)', 'null' => true, 'default' => null]]);
    }
}
