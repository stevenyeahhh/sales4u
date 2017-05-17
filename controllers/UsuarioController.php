<?php
/**
 * Esto será más para la aplicación de celular.
 */
class UsuarioController extends Controller {


    public function __construct() {

        parent::__construct();

    }

    public function index() {
        $this->view->renderize("index");
    }

    public function registrarVisitaSistema() { 
        
    }
    public function registrarLogDesplazamiento($lat,$long,$idUsuario) {
        
    }
}
