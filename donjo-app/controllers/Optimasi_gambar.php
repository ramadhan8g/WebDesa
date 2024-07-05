<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Optimasi_gambar extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->modul_ini          = 'pengaturan';
        $this->sub_modul_ini      = 'optimasi-gambar';
        $this->header['kategori'] = 'Optimasi';
    }

    public function index()
    {
        $judul   = 'Optimasi Gambar';
        $folders = $this->get_folders(LOKASI_UPLOAD);

        return view('admin.optimasi_gambar.index', compact('folders'));
    }

    public function get_image($dir = null)
    {
        if (! $dir) {
            $folders = $this->get_folders(LOKASI_UPLOAD)->map(static fn ($dir) => LOKASI_UPLOAD . $dir);
        } else {
            $folders = [LOKASI_UPLOAD . $dir];
        }
        $files = collect();

        foreach ($folders as $path) {
            $images = collect(array_diff(scandir($path), ['.', '..']))->filter(static function ($file) use ($path) {
                $image_size = getimagesize($path . DIRECTORY_SEPARATOR . $file);
                if ($image_size != false && ($image_size[0] > '880' || $image_size[1] > '880')) {
                    return $file;
                }
            })->map(static fn ($file) => $path . DIRECTORY_SEPARATOR . $file);
            $files = $files->merge($images);
        }

        return json([
            'status' => true,
            'data'   => $files,
        ]);
    }

    public function get_folders($path)
    {
        return collect(array_diff(scandir($path), ['.', '..']))
            ->filter(static fn ($dir) => is_dir($path . DIRECTORY_SEPARATOR . $dir));
    }

    public function resize()
    {
        try {
            $request = $this->input->post();
            ResizeGambar($request['file'], $request['file'], ['width' => 880, 'height' => 880]);
        } catch (Exception $e) {
            return json([
                'status'  => false,
                'message' => $e->getMessage(),
            ]);
        }

        return json([
            'status'  => true,
            'message' => 'berhasil',
        ]);
    }
}

// End of file Optimasi_gambar.php
// Location: .//D/kerjoan/web/opendesa/premium/donjo-app/controllers/Optimasi_gambar.php
