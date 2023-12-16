<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //This method is called when a new user is signing up. It takes in the user's full name, user name, email address, password, 
    // and date created as input. It then hashes the user's password using the password_hash() function 
    // and stores it in the database along with the other user information. It returns True if the insertion is successful, False otherwise.
    function signUp($fullName,$userName,$emailAddress,$password, $dateCreated){
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
        if ($this->db->insert('user',array('fullName' => $fullName,'userName' => $userName,'emailAddress' => $emailAddress,'password' => $hashed_password,'dateCreated'=> $dateCreated)))
        {
            return True;
        }
        else {
            return False;
        }

    }

    //Compares the user input of email address and password with some of the credentials in the database
    function login($emailAddress,$password)
    {   

        $res = $this->db->get_where('user',array('emailAddress' => $emailAddress));
        if ($res->num_rows() != 1) {
            return false;
        }   
        else {
            $row = $res->row();
            $hashed_password = $row ->password;
            if (password_verify($password,$hashed_password)) {
                return true;
            }
            else {
                return false;
            }
        }
    }
}
