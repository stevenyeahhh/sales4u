<?php

class CatalogoController extends Controller {

    private $empresa;
    private $utilities;
    private $catalogo;

    public function __construct() {

        parent::__construct();
        $this->empresa = $this->loadModel("Empresa");
        $this->utilities = $this->loadModel("Utilities");
        $this->catalogo = $this->loadModel("Catalogo");
    }

    public function index() {
        $this->view->renderize("index");
    }

    public function registrarTipoMoneda() {
        
    }

    public function registrarCategoria() {
        
    }

    public function productos() {
        $this->view->setParams($this->catalogo->getProductos(), "producto");
        $this->view->setTitle("Productos");
        $this->view->renderize("productos");
    }

    public function registrarProducto($idEmpresa = 0) {
        if ($idEmpresa == 0) {
            $this->view->setParams($this->empresa->getEmpresasNombre()->fetchAll(PDO::FETCH_BOTH), "empresas");
        }else{
            $this->view->setParams($this->empresa->getEmpresa($idEmpresa)->fetch(PDO::FETCH_BOTH), "empresa");            
        }

        echo "<pre>";
        var_dump($_POST);
        var_dump($_FILES);



        echo "</pre>";
        $validar = $this->validar(array_merge(array(
            'nombre' => array('required' => true, 'minlength' => 3),
            'descripcion' => array('required' => true, 'minlength' => 7),
//            'foto' => array('required' => true),
            'peso' => array('required' => true, 'number' => true),
            'volumen' => array('required' => true, 'number' => true),
            'referencia' => array('required' => true),
            'presentacion' => array('required' => true),
            'referencia_local' => array('required' => true),
            'tipos_moneda' => array('required' => true, 'number' => true),
            'costo' => array('required' => true, 'number' => true),
            'iva' => array('required' => true, 'number' => true)
//            'okposition'=>array('required'=>true)
        )));

        $this->view->setValidacion($validar->getCamposJSON());
        if ($_POST) {
            $validar->setValores($_POST);
            if ($validar->validarServidor()) {
                extract($_POST);
                $tasaCambio = $this->utilities->getTipoMonedaId($post_tipos_moneda)->fetch(PDO::FETCH_ASSOC)[tasa_cambio];
                $costoInicial = $post_costo / $tasaCambio;
                $fecha = new DateTime();
                $path = $_FILES['foto'];
                $ext = pathinfo($path['name'], PATHINFO_EXTENSION);
                $dir_subida = ROOT . DS . 'img' . DS . 'productImages' . DS;
                $file = $fecha->getTimestamp() . ".$ext";
                $fichero_subido = $dir_subida . $file;

                if (is_uploaded_file($path['tmp_name'])) {
                    if (!move_uploaded_file($path['tmp_name'], $fichero_subido)) {
                        $this->setError("No se pudo subir el archivo, intente subir el archivo más tarde");

                        $file = "";
                    }
                } else {
                    $this->setError("No hay archivo válido");

                    $file = "";
                }
                if($idEmpresa==0){
                    $idEmpresa=$post_empresas;
                }


                $this->catalogo->setIdEmpresa($idEmpresa);
                $this->catalogo->setNombre($post_nombre);
                $this->catalogo->setDescripcion($post_descripcion);
                $this->catalogo->setFoto($file);
                $this->catalogo->setPeso($post_peso);
                $this->catalogo->setVolumen($post_volumen);
                $this->catalogo->setReferencia($post_referencia);
                $this->catalogo->setPresentacion($post_presentacion);
                $this->catalogo->setReferenciaLocal($post_referencia_local);
                $this->catalogo->setIdTipoMoneda($post_tipos_moneda);
                $this->catalogo->setCosto($post_costo);
                $this->catalogo->setCostoInicial($costoInicial);
                $this->catalogo->setCostoReal($costoInicial);
                $this->catalogo->setIva($post_iva);
                if ($this->catalogo->insertarProducto() == 0) {
                    $this->view->setError("No se insertó producto");
                } else {
                    $this->view->setMensaje("Se insertó correctamente");
                }
            }
        }

        
        $this->view->setParams($this->utilities->getTipoMoneda()->fetchAll(PDO::FETCH_BOTH), "tipos_moneda");
        $this->view->setParams(array(array("id" => 1, "0" => 1, "valor" => "No", "1" => "No"),
            array("id" => 2, "0" => 2, "valor" => "Si", "1" => "Si")), "iva");
        $this->view->setTitle("Registrar Producto");
//        $this->view->renderize("registrarProducto_1");
        $this->view->renderize("registrarProducto");
    }

    public function registrarDisponibilidad($idProducto = 0) {

        $validar = $this->validar(array_merge(array(
            'cantidad' => array('required' => true, 'number' => 3),
        )));

        $this->view->setValidacion($validar->getCamposJSON());
        if ($_POST) {
            $validar->setValores($_POST);
            if ($validar->validarServidor()) {
                extract($_POST);
                $this->catalogo->setCantidad($post_cantidad);
                $this->catalogo->setIdProducto($idProducto);
                $this->catalogo->setDisponibilidad($post_cantidad);

                if ($this->catalogo->insertarDisponibilidad() == 0) {
                    $this->view->setError("No se insertó");
                } else {
                    $this->view->setMensaje("Éxito");
                }
            }
        }



        $this->view->setParams($this->catalogo->getProducto($idProducto)->fetchAll(PDO::FETCH_BOTH), "producto");
        $this->view->setTitle("Registrar Disponibilidad");
        $this->view->renderize("registrarDisponibilidad");
    }

    public function getProductoLocalRef($localRef='') {
        echo json_encode($this->catalogo->getProductoLocalRef($localRef)->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
//        echo json_encode($this->catalogo->getProductoLocalRef($_POST[s])->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
    }

}
