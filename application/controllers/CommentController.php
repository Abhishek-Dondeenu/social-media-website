<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommentController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->helper('url');
        $this->load->model('CommentModel');
    }

    // The method is used to handle the creation of new comments. 
    // It first loads the session library and gets the email address of the current user from the session data. 
    // Then it gets the comment description, post ID, and current date and time from the user input.
    // It then passes these values to the createComment() method in the CommentModel to create the new comment in the database.
    public function createComment(){
        $this->load->library('session');
        $emailAddress= $this->session->userdata('emailAddress');
        $commentDescription= $this->input->post('commentDescription');
        $postID= $this->input->post('postID');        
        $dateCreated = date('Y-m-d H:i:s');
       
        $this->CommentModel->createComment($commentDescription,$postID,$dateCreated);
        
    }
}