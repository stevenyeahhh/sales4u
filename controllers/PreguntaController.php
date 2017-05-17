<?php

class IndexController extends Controller {

    private $usuario; //los modelos se guardan en models/[nombre modelo]

    public function __construct() {
        parent::__construct();
//        if ($this->sesionIniciada()) {
//             header("Location:" . BASE .  'index/initsession');            
//        }
    }

    public function index() {

        $title = "Bienvenido a PreguntApp";
        $renderize = "index";
        $this->view->setTitle($title);
        $this->view->renderize($renderize);
    }

    public function iniciar() {
        $title = "Bienvenido a PreguntApp";
        $renderize = "iniciar";

        if ($_POST) {
            $_SESSION['session'] = $_POST['session'];
            $title = 'Inició sesión';
            $renderize = 'initsession';
        }
        if ($this->sesionIniciada()) {
            $title = 'Inició sesión';
            $renderize = 'initsession';
        }
        $this->view->setTitle($title);
        $this->view->renderize($renderize);
    }

//    public function desactivarIndex() {
//    Funci? para deshabilitar registros a trav? de la tabla con el bootstrap.switch ejemplo en views/index/index.phtml
//        extract($_POST);//        
//        die($this->bodega->cambiarEstado($usuario,$estado)? "?ito al " . (($estado) ? "activar" : "desactivar") . "  la bodega '$usuario'" : "No se pudo actualizar la bodega");
//        
//    }
    public function reporte($excel = false) {
        $data = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
        if ($excel == 1) {
            $this->exportExcel($data, "Título", "Nombre del archivo"); //La funci? exportExcel, permite exportar arreglos tal y como se env?
        } else {
            $this->view->setParams(json_encode($data), "json_object");
            $this->view->renderize('report');
        }
    }

}
