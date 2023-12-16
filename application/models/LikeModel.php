<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LikeModel extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }
    
    //This method takes in two parameters: $postID, and $liked. It first gets the email address of the 
    // current user from the session data and using it it retrieves the userID of the current user. 
    // Then it checks if the user has already liked or disliked the post using the getLikeStatusForUser() method, 
    // if the user has not liked or disliked the post it inserts a new row in the likes table in the database with the provided post ID, user ID, and liked status. 
    // If the user has already liked or disliked the post it updates the existing row in the likes table.
    public function addLike($postID, $liked) {

        $emailAddress= $this->session->userdata('emailAddress');

        $queryOne = $this->db->select('userID')->from('user')->where('emailAddress',$emailAddress)->get();
      
        $userID;

        foreach ( $queryOne->result()as $u) {
            $userID = $u->userID;
        }
        
        $status = $this->getLikeStatusForUser($postID);

        if ($status == 0) {
            $data = array(
                'postID' => $postID,
                'userID' => $userID,
                'liked' => $liked
            );
            $this->db->insert('likes', $data);

            if ($liked == 1) {
                $this->db->set('likeCount', 'likeCount+1', FALSE)
                         ->where('postID', $postID)
                         ->update('post');
            } else {
                $this->db->set('likeCount', 'likeCount-1', FALSE)
                         ->where('postID', $postID)
                         ->update('post');
            }
        } 
        else{
            $data = array(
                'liked' => $liked
            );
            $this->db->where('postID', $postID)
                     ->where('userID', $userID)
                     ->update('likes', $data);

            if ($liked == 1) {
                $this->db->set('likeCount', 'likeCount+1', FALSE)
                         ->where('postID', $postID)
                         ->update('post');
            } else {
                $this->db->set('likeCount', 'likeCount-1', FALSE)
                         ->where('postID', $postID)
                         ->update('post');
            }
        }
    }

    //This method takes in a $postID parameter and returns the number of likes for the specified post.
    public function getLikesForPost($postID) {
        $this->db->select('likeCount')
                 ->from('post')
                 ->where('postID', $postID)
                 ->limit(1);
        $query = $this->db->get();
        return $query->row()->likeCount;
    }

    //This method takes in a $postID parameter, it first gets the email address of the current user from the session data and using it 
    // retrieves the userID of the current user. 
    // It then checks if the user has already liked or disliked the post and returns the value.
    public function getLikeStatusForUser($postID) {
        
        $emailAddress= $this->session->userdata('emailAddress');

        $queryOne = $this->db->select('userID')->from('user')->where('emailAddress',$emailAddress)->get();
      
        $userID;

        foreach ( $queryOne->result()as $u) {
            $userID = $u->userID;
        }

        $this->db->select('liked')
                 ->from('likes')
                 ->where('postID', $postID)
                 ->where('userID', $userID)
                 ->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->liked;
        } else {
            return 0;
        }
    }
}

