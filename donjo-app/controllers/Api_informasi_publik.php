<?php



defined('BASEPATH') || exit('No direct script access allowed');

/*
 * Untuk menyediakan data informasi publik bagi pengguna eksternal.
 * Data informasi publik bebas diakses umum
 */
class Api_informasi_publik extends Api_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('web_dokumen_model');
    }

    public function index()
    {
        redirect('ppid');
    }

    public function ppid()
    {
        $this->log_request();
        $get      = $this->input->get();
        $tgl_dari = $get['tgl_dari'];
        if (! empty($tgl_dari) && ! validate_date($tgl_dari)) {
            $json_send = ['status' => 'fail',
                'data'             => ['tgl_dari' => 'tgl_dari harus tanggal dalam format d-m-Y',
                ],
            ];
        } else {
            $jenis_kirim = empty($get['tgl_dari']) ? 'semua' : 'perubahan';
            $data        = $this->web_dokumen_model->data_ppid($tgl_dari);
            $json_send   = ['status' => 'success',
                'data'               => ['ppid' => $data,
                    'tanggal'                   => date('d-m-Y h:i:s', time()),
                    'pengiriman'                => $jenis_kirim,
                    'tgl_dari'                  => $tgl_dari,
                    'total data'                => count($data),
                ],
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($json_send);
    }
}
