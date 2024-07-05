<?php



namespace App\Traits;

use App\Observers\AuthorObserver;

defined('BASEPATH') || exit('No direct script access allowed');

trait Author
{
    public static function bootAuthor()
    {
        static::observe(AuthorObserver::class);
    }
}
