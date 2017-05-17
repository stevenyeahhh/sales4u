<?php

class VentaController extends Controller {

    private $empresa;
    private $venta;
    private $administrador;

    public function __construct() {
        $this->empresa = $this->loadModel("Empresa");
        $this->venta = $this->loadModel("Venta");
        $this->administrador = $this->loadModel("Administrador");
        parent::__construct();
    }

    public function index() {
        $this->view->renderize("index");
    }

    public function ordenesPedidoPendientes() {
        
    }

    public function cotizaciones() {
        $this->view->setTitle("Cotizaciones");
        $this->view->setParams($this->venta->getCotizaciones(), "cotizaciones");
//        $this->view->renderize("cotizacion");
        $this->view->renderize("cotizaciones");
    }

    public function crearCotizacion($idEmpresa = 0) {
        $this->view->setAngularRequires("angucomplete-alt");
        if ($idEmpresa == 0) {
            $this->view->setTitle("Registrar Cotización");
            $this->view->renderize("empresa");
        } else {
            var_dump($_POST);
            
            $this->view->setAngularRequires("dialogService");
            $this->view->setParams($this->empresa->getEmpresa($idEmpresa)->fetch(PDO::FETCH_BOTH), "empresa");
            $this->view->setParams($this->empresa->getContactos($idEmpresa)->fetchAll(PDO::FETCH_BOTH), "contactos");
            $this->view->setParams($this->administrador->getVendedorData($this->getSesionVar("id_usuario"))->fetch(PDO::FETCH_BOTH), "vendedor");
            
            $this->view->setTitle("Registrar Cotización");
            $this->view->renderize("cotizacion");
        }
//        $this->view->renderize("cotizacion_1");
    }

    public function crearFactura() {
        $this->view->setTitle("Registrar Factura");
        $this->view->renderize("factura");
    }

    public function obtenerVisitas() {
        
    }

    public function registrarVendedor() {
        $this->view->renderize("vendedor");
    }

    public function obtenerOrdenesEntregadas() {
        $this->view->renderize("ordenesEntregadas");
    }

    public function crearOrden() {
        $this->view->setTitle("Crear orden pedido");
        $this->view->renderize("ordenPedido");
    }

}
