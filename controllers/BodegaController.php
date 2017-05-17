<?php

class IndexController extends Controller {


    public function __construct() {

        parent::__construct();

    }

    public function index() {
        $this->view->renderize("index");
    }

    public function functionName($param) {
        
    }
    public function map() {
        $this->view->renderize("map",false);
    }
}
