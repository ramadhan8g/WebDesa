<?php



defined('BASEPATH') || exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
    public function __construct($rules = [])
    {
        parent::__construct($rules);
    }

    /**
     * Overwrite is_unique method.
     *
     * Check if the input value doesn't already exist
     * in the specified database field.
     *
     * ```php
     * $this->form_validation->set_rules('username', 'Username', 'is_unique[user.username,id,{id}]');
     * // or
     * $this->form_validation->set_rules('username', 'Username', 'is_unique[user.username]');
     * ```
     *
     * @param string $str
     * @param string $field
     *
     * @return bool
     */
    public function is_unique($str, $field)
    {
        [$field, $ignoreField, $ignoreValue] = array_pad(explode(',', $field), 3, null);

        sscanf($field, '%[^.].%[^.]', $table, $field);

        if (! isset($this->CI->db)) {
            return false;
        }

        /** @var \CI_DB_query_builder */
        $row = $this->CI->db
            ->from($table)
            ->select('1')
            ->where($field, $str)
            ->limit(1);

        if (! empty($ignoreField) && ! empty($ignoreValue) && ! preg_match('/^\{(\w+)\}$/', $ignoreValue)) {
            $row = $row->where("{$ignoreField} !=", $ignoreValue);
        }

        return $row->get()->row() === null;
    }
}
