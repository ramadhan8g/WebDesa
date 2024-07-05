<?php



namespace App\Models;

use App\Enums\StatusEnum;
use App\Models\Galery as Galeri;

defined('BASEPATH') || exit('No direct script access allowed');

class SettingAplikasi extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'setting_aplikasi';

    /**
     * The timestamps for the model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The fillable with the model.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'option' => 'json',
    ];

    public function getOptionAttribute()
    {
        if ($this->attributes['jenis'] == 'option' && $this->attributes['key'] == 'web_theme') {
            // TODO : Akan dipindahkan ke modul tema
            $list_tema  = [];
            $tema_semua = array_merge(glob('vendor/themes/*', GLOB_ONLYDIR), glob('desa/themes/*', GLOB_ONLYDIR));

            foreach ($tema_semua as $tema) {
                if (is_file(FCPATH . $tema . '/template.php')) {
                    $list_tema[] = str_replace(['vendor/', 'themes/'], '', $tema);
                }
            }

            return array_combine($list_tema, $list_tema);
        }
        if ($this->attributes['jenis'] == 'option' && $this->attributes['key'] == 'tampilan_anjungan_slider') {
            return Galeri::whereParrent(Galeri::PARRENT)->whereEnabled(StatusEnum::YA)->pluck('nama', 'id');
        }
        if ($this->attributes['jenis'] == 'boolean') {
            return [
                1 => 'Ya',
                0 => 'Tidak',
            ];
        }

        return json_decode($this->attributes['option'], true);
    }
}
