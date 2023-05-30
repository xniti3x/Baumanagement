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
 * Class Bauvorhaben
 */
class Bauvorhaben extends Admin_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('mdl_bauvorhaben');
    }

    public function index() {
        $data['bauvorhaben'] = $this->mdl_bauvorhaben->getAll();
         $this->layout->set($data);
        $this->layout->buffer("content","bauvorhaben/index");
        $this->layout->render();

    }
    /*
    function for  add Bauvorhaben get
    created by your name
    created at 08-03-21.
    */
    public function add() {
        $this->layout->buffer("content","bauvorhaben/add");
        $this->layout->render();
    }
    /*
    function for add Bauvorhaben post
    created by your name
    created at 08-03-21.
    */
    public function addPost() {
        $data['bezeichnung'] = $this->input->post('bezeichnung');
    $this->mdl_bauvorhaben->insert($data);
        redirect('bauvorhaben/index');
    }
    /*
    function for edit Bauvorhaben get
    returns  Bauvorhaben by id.
    created by your name
    created at 08-03-21.
    */
    public function edit($bauvorhaben_id) {
        $data['bauvorhaben_id'] = $bauvorhaben_id;
        $data['bauvorhaben'] = $this->mdl_bauvorhaben->getDataById($bauvorhaben_id);

        $this->layout->buffer("content","bauvorhaben/edit",$data);
        $this->layout->render();

    }
    /*
    function for edit Bauvorhaben post
    created by your name
    created at 08-03-21.
    */
    public function editPost() {
        if($this->input->post('btn_submit')){
            echo $this->input->post('bezeichnung');
        }
        $bauvorhaben_id = $this->input->post('bauvorhaben_id');
        $bauvorhaben = $this->mdl_bauvorhaben->getDataById($bauvorhaben_id);
        $data['bezeichnung'] = $this->input->post('bezeichnung');
        $this->mdl_bauvorhaben->update($bauvorhaben_id,$data);
        redirect('bauvorhaben/index');

    }

    /*
    function for delete Bauvorhaben    created by your name
    created at 08-03-21.
    */
    public function delete($bauvorhaben_id) {
        $this->mdl_bauvorhaben->delete($bauvorhaben_id);
        redirect('bauvorhaben/index');
    }
}
