<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * InvoicePlane
 *
 * @author		InvoicePlane Developers & Contributors
 * @copyright	Copyright (c) 2012 - 2018 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 */

/**
 * Class Mdl_Bauvorhaben
 */
class Mdl_Bauvorhaben extends Response_Model
{
    public $table = 'ip_bauvorhaben';
    public $primary_key = 'ip_baovrhaben.id';


    public function getAll() {
        return $this->db->get($this->table)->result();
    }
    /*
    function for create Bauvorhaben.
    return Bauvorhaben inserted id.
    created by your name
    created at 08-03-21.
    */
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    /*
    return Bauvorhaben by id.
    created by your name
    created at 08-03-21.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->result();
    }
    public function getById($id){
       return $this->db->query("select * from ip_bauvorhaben where id=".$id)->result();
    }
    /*
    function for update $this->table.
    return true.
    created by your name
    created at 08-03-21.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return true;
    }
    /*
    function for delete Bauvorhaben.
    return true.
    created by your name
    created at 08-03-21.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        return true;
    }

}
