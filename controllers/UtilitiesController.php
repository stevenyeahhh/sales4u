<?php

class UtilitiesController extends Controller {

    private $utilities;

    public function __construct() {
        $this->utilities = $this->loadModel("Utilities");
        parent::__construct();
    }

    public function index() {
        $this->view->renderize("index");
    }

    public function functionName($param) {
        
    }

    public function map() {
        $this->view->renderize("map", false);
    }

    public function angucomplete_template() {
        $this->view->renderize("angucomplete_template", false);
    }

    public function getCiudades($idPais) {

        echo json_encode($this->utilities->getCiudades($idPais)->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
    }

    public function logout() {
        session_destroy();
        header("Location:" . BASE  . 'index' . DS);
    }

}
