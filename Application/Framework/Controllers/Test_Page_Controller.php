<?php

class Test_Page_Controller extends APP_Controller {

    public function __construct(){
        parent::__construct();

       // $this->Load_Model();
        $data['titolo'] = "(MyCMS) Future Framework";
        $this->Load_View($data);
    }

    //public function Load_Model() {
   // }

    public function Load_View($data){
        $this->Load->_view('Test_Page_Views', $data);
    }

}