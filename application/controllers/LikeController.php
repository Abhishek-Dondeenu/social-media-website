<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LikeController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->helper('url');
        $this->load->model('LikeModel');
    }

    //This method is called when a user likes or dislikes a post. It first gets the post ID and the like status from the user's input. 
    // It then calls the addLike() method from the LikeModel to add the like to the database 
    // and also getLikesForPost() method to get the total number of likes for that post. 
    // It then creates a response array with the like count and returns it as a json object to the client side.
    public function likePost() {
        $postID= $this->input->post('postID');
        $liked = $this->input->post('liked');

        $this->LikeModel->addLike($postID, $liked);
        $likeCount = $this->LikeModel->getLikesForPost($postID);

        $response = array(
            'likeCount' => $likeCount
        );
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
    }
    
    // This method is called when a user wants to know the current like status for a post. It first gets the post ID from the user's input. 
    // It then calls the getLikeStatusForUser() method from the LikeModel to get the current like status 
    // for the user for that post. It then returns the like status as a json object to the client side.
    public function getLikeStatusForUser() {
        $postID= $this->input->get('postID');
        $likeStatus = $this->LikeModel->getLikeStatusForUser($postID);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('likeStatus' => $likeStatus)));
    }

}