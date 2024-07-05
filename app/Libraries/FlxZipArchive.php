<?php



namespace App\Libraries;

use Carbon\Carbon;
use ZipArchive;

defined('BASEPATH') || exit('No direct script access allowed');

// Compress keseluruhan folder, seperti folder desa
// https://stackoverflow.com/questions/4914750/how-to-zip-a-whole-folder-using-php
class FlxZipArchive extends ZipArchive
{
    public $tmp_file;
    public $waktu_backup_terakhir;

    public function read_dir($backup_folder, $waktu_backup_terakhir = null, $archive = null)
    {
        // Simpan di temp file
        if ($waktu_backup_terakhir != null) {
            if ($archive != null) {
                $this->tmp_file = tempnam(BACKUPPATH, $waktu_backup_terakhir);
            } else {
                $this->tmp_file = tempnam(sys_get_temp_dir(), $waktu_backup_terakhir);
            }
        } else {
            $this->tmp_file = tempnam(sys_get_temp_dir(), '');
        }

        $this->waktu_backup_terakhir = ($waktu_backup_terakhir == null) ? null : Carbon::parse($waktu_backup_terakhir);
        $res                         = $this->open($this->tmp_file, ZipArchive::CREATE);
        if ($res === true) {
            $this->addDir($backup_folder, basename($backup_folder));
            $this->close();

            return $this->tmp_file;
        }
        echo 'Could not create a zip archive';
    }

    public function download($nama_file)
    {
        // Unduh berkas zip
        header('Content-Description: File Transfer');
        header('Content-disposition: attachment; filename=' . $nama_file);
        header('Content-type: application/zip');
        flush();
        readfile_chunked($this->tmp_file);

        exit();
    }

    public function addDir($location, $name)
    {
        $this->addEmptyDir($name);
        $this->addDirDo($location, $name);
    }

    private function addDirDo($location, $name)
    {
        $name     .= '/';
        $location .= '/';
        $dir = opendir($location);

        while ($file = readdir($dir)) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $do        = (filetype($location . $file) == 'dir') ? 'addDir' : 'addFile';
            $file_info = get_file_info($location . $file);

            if ($this->waktu_backup_terakhir != null) {
                if ($do == 'addFile' && ! Carbon::createFromTimestamp($file_info['date'])->gt($this->waktu_backup_terakhir)) {
                    continue;
                }
            }

            $this->{$do}($location . $file, $name . $file);
        }
    }
}
