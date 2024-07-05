<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Paging
{
    public $page;
    public $per_page;
    public $num_rows;
    public $num_page;
    public $offset;
    public $prev;
    public $next;
    public $start_link;
    public $start;
    public $end;
    public $end_link;
    public $suffix;
    public $num_links = 10;

    public function __construct($props = [])
    {
        if (count($props) > 0) {
            $this->init($props);
        }
    }

    public function init($input = [])
    {
        if (isset($input['page'])) {
            $this->page = (int) $input['page'];
        }
        if (isset($input['per_page'])) {
            $this->per_page = (int) $input['per_page'];
        }
        if (isset($input['num_rows'])) {
            $this->num_rows = (int) $input['num_rows'];
        }
        if (isset($input['suffix'])) {
            $this->suffix = (string) $input['suffix'];
        }
        if (isset($input['num_links'])) {
            $this->num_links = (int) $input['num_links'];
        }

        //Sanitizing Input
        if ($this->page < 1) {
            $this->page = 1;
        }
        if ($this->per_page < 1) {
            $this->per_page = 50;
        }
        if ($this->num_rows < 1) {
            $my_num_rows = 1;
        } else {
            $my_num_rows = $this->num_rows;
        }

        $this->num_page = (int) ((($my_num_rows - 1) / $this->per_page) + 1);
        $this->offset   = (int) (($this->page - 1) * $this->per_page);

        $this->prev = $this->page - 1;
        $this->next = $this->page + 1;
        if ($this->next > $this->num_page) {
            $this->next = 0;
        }

        //Create Paging Link
        if ($this->page < $this->num_links) {
            $start = 1;
            $end   = min($this->num_links, $this->num_page);
            /** Aslinya sbb:
             * if($this->num_page > (int)($this->num_links * 1.5)) // 30
             * $end=$this->num_links;
             * else $end=$this->num_page;
             */
        } elseif ($this->page > $this->num_page - $this->num_links) {
            $start = (int) ($this->num_page - $this->num_links);
            $end   = (int) $this->num_page;
        } else {
            $start = (int) ($this->page - (($this->num_links / 2) - 1)); // 9
            $end   = (int) ($this->page + ($this->num_links / 2)); // 10
        }
        $this->start      = 1;
        $this->end        = $this->num_page;
        $this->start_link = $start;
        $this->end_link   = $end;
    }
}
