<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->helper('url');
        $this->load->model('PostModel');
        $this->load->model('CommentModel');
        $this->load->model('LikeModel');
        $this->load->model('TagModel');
    }

    // This method calls the getAllTags() method from the TagModel to get data for all tags 
    // and then loads the createPostView view, passing in the tag data as an array.
    public function index()
	{
        $tagData = $this->TagModel->getAllTags();
        $this->load->view("createPostView",array('tagData' => $tagData));       
	}

    //This method loads the searchResultsView view.
    public function searchResultsView()
	{
        $tagData = $this->TagModel->getAllTags();
        $this->load->view("searchResultsView",array('tagData' => $tagData));       
	}

    // This method handles the creation of new posts. It first loads the session library, 
    // gets the email address of the current user from the session data, and then gets the post description and tag from the user input. 
    // It separates the tag from the post description and gets the current date and time. 
    // It then passes these values to the createPost() method in the PostModel to create the new post in the database.
    public function createPost(){
        $this->load->library('session');
        $emailAddress= $this->session->userdata('emailAddress');
        $postDescription= $this->input->post('postDescription');
        $separateTag= explode("#", $postDescription);
        $tagname = $separateTag[1];
        $dateCreated = date('Y-m-d H:i:s');
        $this->PostModel->createPost($postDescription,$dateCreated,$tagname);
        
    }

    //This method handles the request to view the details of a specific post. It gets the post ID from the user input and calls the getPostDetails() 
    // and getCommentsByPostID() methods from the PostModel to get the data for the post and its comments. 
    // It also calls the getAllTags() method from the TagModel to get the data for all tags. 
    // The postDetailsView view is loaded and passed the post, comment and tag data as arrays.
    public function getPostDetails(){
        $postID= $this->input->get('postID');
        $postData = $this->PostModel->getPostDetails($postID);
        $commentData = $this->PostModel->getCommentsByPostID($postID);
        $tagData = $this->TagModel->getAllTags();
        $this->load->view('postDetailsView', ['postData'=>$postData,'commentData'=> $commentData,'tagData'=> $tagData]);
    } 

    // This method handles requests to filter posts by a specific tag. It gets the tag name from user input, 
    // calls the getPostByFilterSearch() method from the PostModel to get the data for all posts associated with the tag, 
    // and returns the data in JSON format.
    public function getPostByFilterSearch()
    {
        $tagName= $this->input->get('tagName');
        $postData= $this->PostModel->getPostByFilterSearch($tagName);
    
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($postData));
    }     
}