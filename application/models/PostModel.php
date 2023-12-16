<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostModel extends CI_Model {
   
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // This method takes in three parameters: $postDescription, $dateCreated, and $tag. 
    // It first loads the session library and gets the email address of the current user from the session data.
    // It then runs three separate SQL queries to get the userID, userName, and tagID associated with the current user and the input tag. 
    // These values are then used to insert a new post into the post table in the database with the provided post description, date created, user ID, and tag ID.
    function createPost($postDescription,$dateCreated,$tag){
        $this->load->library('session');
        $emailAddress= $this->session->userdata('emailAddress');
        
        $queryOne = $this->db->select('userID')->from('user')->where('emailAddress',$emailAddress)->get();
      
        $userID;

        $queryTwo = $this->db->select('userName')->from('user')->where('emailAddress',$emailAddress)->get();
        
        $userName;

        $queryThree = $this->db->select('tagID')->from('tags')->where('tagName',$tag)->get();
        
        $tagID;
        
        foreach ( $queryOne->result()as $u) {
            $userID = $u->userID;
        }
        
        foreach ($queryTwo->result() as $u) {
            $userName = $u->userName;
        }
        foreach ($queryThree->result() as $u) {
            $tagID = $u->tagID;
        }
       
        $this->db->insert('post',array('postDescription' => $postDescription ,'userName' =>$userName ,'dateCreated' => $dateCreated,'userID' => $userID,'tagID' => $tagID));

    }

    //This method takes in a $postID parameter and returns an array of data for the post with the matching ID.
    function getPostDetails($postID){
    
        $query = $this->db->get_where('post', array('postID' => $postID));
        return $query->result_array();
    }

    //This method returns an array of data for all posts in the post table.
    function getAllPost(){
        $query = $this->db->get('post');
        return $query->result_array();
    }

    //This method takes in a $postID parameter and returns an array of data for all comments associated with the post.
    function getCommentsByPostID($postID){
        $query = $this->db->get_where('comment', array('postID' => $postID));
        return $query->result_array();
    }
    
    // This method takes in a $tagName parameter and returns an array of data for all posts associated with the input tag. 
    // It first runs a query to get the tagID associated with the input tag, 
    // and then runs a query to get all posts with that tag ID. If no rows are found, it returns an empty array.
    function getPostByFilterSearch($tagName)
    {
        $queryOne = $this->db->select('tagID')->from('tags')->where('tagName',$tagName)->get();
        $tagID;
        foreach ( $queryOne->result()as $u) {
            $tagID = $u->tagID;
        }
    
        if ($queryOne->num_rows() > 0 ) {
            
            $query = $this->db->get_where('post', array('tagID' => $tagID));
            if($query->num_rows() > 0){
                
                return $query->result_array();
            } else {
                return false;
            }  
        } 
        
    }
}