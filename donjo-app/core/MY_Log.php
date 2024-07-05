<?php



class MY_Log extends CI_Log
{
    /**
     * {@inheritDoc}
     */
    protected $_levels = [
        'ERROR'  => 1,
        'DEBUG'  => 2,
        'INFO'   => 3,
        'ALL'    => 4,
        'NOTICE' => 5,
    ];
}
