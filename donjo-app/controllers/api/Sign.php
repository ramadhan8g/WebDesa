<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Sign extends MY_Controller
{
    /**
     * Mock api untuk demo TTE BSrE.
     *
     * @return mixed
     */
    public function pdf()
    {
        return json([
            'status'      => true,
            'pesan'       => 'success',
            'jenis_error' => null,
        ]);
    }
}
