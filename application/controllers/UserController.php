<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->helper('url');
        $this->load->model('UserModel');
        $this->load->model('PostModel');
        $this->load->model('LikeModel');
        $this->load->model('TagModel');
    }

    //Redirects user to the home page if user is logged in or to the login page if not logged in
	public function index()
	{
        $this->load->library('session');
        if($this->session->userdata('user')){
			redirect('home');
		}
		else{
			$this->load->view('loginView');
		}
	}

    //Submits user data to signUp method in UserModel
    public function submitUserData(){
        $this->input->server('REQUEST_METHOD') == 'POST'; 
		$data = $this->decode_data($this->input->raw_input_stream);
        $fullName = $data['fullName'];
        $userName = $data['userName'];
        $emailAddress = $data['emailAddress'];
        $password = $data['password'];
        $dateCreated = date('Y-m-d H:i:s');
        $user = $this->UserModel->signUp($fullName,$userName,$emailAddress,$password, $dateCreated);
        echo json_encode($user);
    }

     //This method loads the signUpView view instead.
    public function signUp(){
        $this->load->view("signUpView");
    }

    //This method loads the loginView view instead.
    public function loginView(){
        $this->load->view("loginView");
    }

    public function home(){
        //load session library
		$this->load->library('session');        
		//restrict users to go to home if not logged in
		if($this->session->userdata('user')){
            $postData = $this->PostModel->getAllPost();
            $tagData = $this->TagModel->getAllTags();
            $this->load->view('homeView', ['postData'=>$postData,'tagData'=> $tagData]);
        }else{
			redirect('/');
		}
    }

    // The login() method handles user authentication by accepting user input for an email address and password, 
    // then passing that information to a UserModel to verify the credentials against a database. 
    // If the login is successful, the user's data is stored in a session variable, otherwise, a flash message is set and the user is redirected to the login page. 
    public function login()
    {
        $this->load->library('session');
        $emailAddress = $this->input->post('emailAddress');
        $password = $this->input->post('password');
        $this->load->model('UserModel');
        $data = $this->UserModel->login($emailAddress, $password);
       
         if($data){
            $this->session->emailAddress = $emailAddress;
            $this->session->password = $password;
            $this->session->set_userdata('user', $data);
        }else{
            $this->session->set_flashdata('Mess age' , "Username/password incorrect.  Please re-try");
            redirect('/');
           
        }
    }

    //This method ends the user's session and redirects them to the login page.
    public function logout()
    {
        $this->load->library('session');
        $this->session->set_flashdata('Message' , "");
		$this->session->unset_userdata('user');
		redirect('/');
        
    }
    
    //This method decodes the JSON data into an array 
	private function decode_data($data)
	{
		$d = $this->security->xss_clean($data);
		$request = json_decode($d,true);
		return $request;
	}
}