<?php

class ClienteController extends Controller {


    public function __construct() {

        parent::__construct();

    }

    public function index() {
        $this->view->renderize("index");
    }

    public function crearCotizacion() {
        $this->view->renderize("cotizacion");
    }
    public function solicitarVisita() {
        $this->view->renderize("visita");
    }
    public function registrarFactura($idCotizacion=null) {
        
    }
    public function consultarOrdenes() {
        $this->view->renderize("ordenes");
    }
}
