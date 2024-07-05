<?php



namespace App\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

defined('BASEPATH') || exit('No direct script access allowed');

class BaseModel extends Model
{
    /**
     * {@inheritDoc}
     */
    public static function findOrFail($id, $columns = ['*'])
    {
        $result = self::find($id, $columns);

        $id = $id instanceof Arrayable ? $id->toArray() : $id;

        if (is_array($id)) {
            if (count($result) === count(array_unique($id))) {
                return $result;
            }
        } elseif (null !== $result) {
            return $result;
        }

        return show_404();
    }

    /**
     * {@inheritDoc}
     */
    public static function firstOrFail($columns = ['*'])
    {
        if (null !== ($model = self::first($columns))) {
            return $model;
        }

        return show_404();
    }
}
