<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TagController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->helper('url');
        $this->load->model('TagModel');
    }

    //This method retrieves all the tags available in the 'tags' table of the database.
    public function getAllTags()
    {
        $this->TagModel->getAllTags();
    }  
}