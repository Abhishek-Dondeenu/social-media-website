<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TagModel extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //This method retrieves all the tags available in the 'tags' table of the database.
    function getAllTags()
    {
        $query = $this->db->get('tags');
        return $query->result();
    }
   
}