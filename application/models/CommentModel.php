<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommentModel extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // This method takes in three parameters: $commentDescription, $postID, and $dateCreated. 
    // It first loads the session library and gets the email address of the current user from the session data. 
    // It then runs two separate SQL queries to get the userID and userName associated with the current user. 
    // These values are then used to insert a new comment into the comment table in the database with the provided comment description, 
    // date created, user ID, and post ID. It also updates the post table comment count by incrementing it by 1.
    function createComment($commentDescription,$postID,$dateCreated){
        $this->load->library('session');
        $emailAddress= $this->session->userdata('emailAddress');
        
        $queryOne = $this->db->select('userID')->from('user')->where('emailAddress',$emailAddress)->get();
      
        $userID;

        $queryTwo = $this->db->select('userName')->from('user')->where('emailAddress',$emailAddress)->get();
        
        $userName;
        
        foreach ( $queryOne->result()as $u) {
            $userID = $u->userID;
        }
        
        foreach ($queryTwo->result() as $u) {
            $userName = $u->userName;
        }
        $this->db->set('commentCount', 'commentCount+1', FALSE);
        $this->db->where('postID', $postID);
        $this->db->update('post');
        $this->db->insert('comment',array('commentDescription' => $commentDescription ,'userName' =>$userName ,'dateCreated' => $dateCreated,'userID' => $userID,'postID' => $postID));

    }

    //This method takes in a $postID parameter and returns an array of data for all comments associated with the post.
    function getCommentsByPostID($postID){
        $query = $this->db->get_where('comment', array('postID' => $postID));
        return $query->result_array();
    }

}