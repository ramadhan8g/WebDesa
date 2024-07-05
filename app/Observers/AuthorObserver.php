<?php



namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

defined('BASEPATH') || exit('No direct script access allowed');

class AuthorObserver
{
    public function creating(Model $model)
    {
        $model->created_by = auth()->id;
        $model->updated_by = auth()->id;
    }

    public function updating(Model $model)
    {
        $model->updated_by = auth()->id;
    }
}
