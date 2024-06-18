<?php

class DataManager extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getPrimaryKey($table) {
        $fields = $this->db->field_data($table);
        foreach ($fields as $field) {
            if ($field->primary_key) {
                return $field->name;
            }
        }
        return null;
    }


    public function insert($data, $table) {
        return $this->db->insert($table, $data);
    }


    public function update($data, $table, $key = false) {
        if (!$key) $key = $this->getPrimaryKey($table);
        $this->db->where($key, $data[$key]);
        return $this->db->update($table, $data);
    }


    public function delete($id, $table, $key = false) {
        if (!$key) $key = $this->getPrimaryKey($table);
        $this->db->where($key, $id);
        return $this->db->delete($table);
    }


    public function get($val, $table, $key = false) {
        if (!$key) $key = $this->getPrimaryKey($table);
        $this->db->where($key, $val);
        $query = $this->db->get($table);
        return $query->row_array();
    }


    public function getAll($table, $val = false,  $key = false, $order = "") {
        if ($val && $key) {
            $this->db->where($key, $val);
        }
        if ($order) {
            $this->db->order_by($order);
        }
        $query = $this->db->get($table);
        return $query->result_array();
    }


    public function getLastItem($table, $key = "date") {
        $this->db->order_by($key, "DESC");
        $query = $this->db->get($table, 1);
        return $query->row_array();
    }
}

