<?php



use App\Models\Dokumen;
use App\Models\RefDokumen;

class Peraturan extends Web_Controller
{
    public function index()
    {
        if (! $this->web_menu_model->menu_aktif('peraturan-desa')) {
            show_404();
        }

        $data = $this->includes;

        $data['pilihan_kategori'] = RefDokumen::query()
            ->where('id', '!=', 1)
            ->pluck('nama', 'id')
            ->transform(static function ($item, $key) {
                if ($key === 2) {
                    return str_replace(['Desa', 'desa'], ucwords(setting('sebutan_desa')), $item);
                }

                if ($key === 3) {
                    return "{$item} Di " . ucwords(setting('sebutan_desa'));
                }

                return $item;
            });
        $data['pilihan_tahun']  = Dokumen::distinct('tahun')->hidup()->where('kategori', '!=', 1)->pluck('tahun');
        $data['halaman_statis'] = 'peraturan/index';

        $this->_get_common_data($data);
        $this->set_template('layouts/halaman_statis.tpl.php');
        $this->load->view($this->template, $data);
    }

    public function datatables()
    {
        if ($this->input->is_ajax_request()) {
            $filters = [
                'tahun'    => $this->input->get('tahun', true),
                'kategori' => $this->input->get('kategori', true),
            ];

            $query = Dokumen::select(['id', 'nama', 'tahun', 'satuan', 'kategori', 'attr', 'url'])
                ->hidup()
                ->aktif()
                ->where('kategori', '!=', 1)
                ->filters($filters);

            return datatables()
                ->of($query)
                ->addIndexColumn()
                ->addColumn('kategori_dokumen', static function ($row) {
                    return $row['attr']['jenis_peraturan'] ?? $row->kategoriDokumen->nama;
                })
                ->make();
        }

        return show_404();
    }
}
