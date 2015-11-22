<?php

class Admin extends APP_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function admin(){
        $data['title'] = 'Admin';
        $this->Load->_view_template('header', $data);
        $this->Load->_view('admin/admin');
    }

    public function login(){

        if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $this->Load->_model('admin_model');
            $login = $this->admin_model->login($username, $password);
            if(!$login){
                exit( 'sbagliato' );
            } else {
                exit( 'funziona' );
            }
        }

        $data['title'] = 'Login';
        $this->Load->_view_template('header', $data);
        $this->Load->_view('admin/login');
    }

}