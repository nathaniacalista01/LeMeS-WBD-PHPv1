<?php
    class RegisterController extends Controller{
        public function index(){
            return $this->view('register','index',[]);
        }
    }
?>