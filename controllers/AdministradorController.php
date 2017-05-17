<?php

class AdministradorController extends Controller {

    private $empresa;
    private $usuario;
    private $utilities;
    private $administrador;
    private $catalogo;

    public function __construct() {

        parent::__construct();
        $this->empresa = $this->loadModel("Empresa");
        $this->usuario = $this->loadModel("Usuario");
        $this->utilities = $this->loadModel("Utilities");
        $this->administrador = $this->loadModel("Administrador");
        $this->catalogo = $this->loadModel("Catalogo");
    }

    public function index() {
        $this->view->renderize("index");
    }

    ///Ubicación
    public function registrarPais() {
        
    }

    public function registrarCiudad() {
        
    }

    //Manejo de Usuarios
    public function registrarRol() {
        
    }

    public function asignarPermiso() {
        
    }

    public function registrarTipoPermiso() {
        //Pendiente, parece ser leer, escribir, editar
    }

    public function registrarTipoDocumento() {
        
    }

    public function registrarAsesor() {
//        $this->view->setParams($this->empresa->getEmpresasContacto()->fetchAll(PDO::FETCH_BOTH),"contactos");
        $validar = $this->validar(array_merge(array(
            'titulo' => array('required' => true, 'number' => true),
            'nombre' => array('required' => true, 'minlength' => 2),
            'apellido' => array('required' => true, 'minlength' => 2),
            'documento' => array('required' => true, 'number' => true, 'minlength' => 7),
            'email' => array('required' => true, 'email' => true),
            'celular' => array('required' => true, 'number' => true),
            'comision_asignada' => array('number' => true, 'required' => true),
            'ciudad' => array('required' => true, 'number' => true),
//            'firma' => array('required' => true),
            'codigo_vendedor' => array('required' => true, 'number' => true),
        )));

        $this->view->setValidacion($validar->getCamposJSON());
        if ($_POST) {
            $validar->setValores($_POST);
            if ($validar->validarServidor()) {
                extract($_POST);
                $this->usuario->setNombre($post_nombre);
                $this->usuario->setApellido($post_apellido);
                $this->usuario->setDocumento($post_documento);
                $this->usuario->setRol_id_rol(3);
                $this->usuario->setUsuario($post_email);
                $this->usuario->setClave(md5($post_documento));
                $this->usuario->setId_tipo_documento($post_tipo_documento);
                $this->usuario->setCelular($post_celular);


                $this->usuario->setTitulo($post_titulo);
                $this->usuario->setCiudad($post_ciudad);
                $this->usuario->setEmail($post_email);
                $fecha = new DateTime();
                $path = $_FILES['firma'];
                $ext = pathinfo($path['name'], PATHINFO_EXTENSION);
                $dir_subida = ROOT . DS . 'img' . DS . 'adviserSignatures' . DS;
                $file = $fecha->getTimestamp() . ".$ext";
//                $firma = $post_firma;
//                $firma = $post_firma;


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

                $idAsesor = $this->usuario->registrarAsesor($post_comision_asignada, $file, $post_codigo_vendedor);
                if ($idAsesor == 0) {
                    die("Error al insertar el asesor");
                }
            } else {
                $this->view->setError("No se insertó");
            }
        }
        $this->view->setParams($this->utilities->getTitulos()->fetchAll(PDO::FETCH_BOTH), "titulo");
        $this->view->setParams($this->utilities->getTipoDocumentos()->fetchAll(PDO::FETCH_BOTH), "tipo_documento");

        $this->view->setParams($this->utilities->getPaises()->fetchAll(PDO::FETCH_BOTH), "pais");
        $this->view->setTitle("Registrar Asesor");
        $this->view->renderize("registrarAsesor");
    }

    public function registrarTipoDescuento($idDescuento = 0) {
        $validar = $this->validar(array_merge(array(
            'tipo_descuento' => array('required' => true),
        )));
        $this->view->setValidacion($validar->getCamposJSON());
        if ($_POST) {
            $validar->setValores($_POST);
            if ($validar->validarServidor()) {
                extract($_POST);
                $this->administrador->setIdTipoDescuento($idDescuento);
                $this->administrador->setTipoDescuento($post_tipo_descuento);
                if ($idDescuento == 0) {
                    $this->administrador->registrarTipoDescuento();
                } else {
                    $this->administrador->actualizarTipoDescuento();
                }
            }
        }

        if ($idDescuento != 0) {
            $this->view->setParams($this->administrador->getTipoDescuento($idDescuento)->fetch(PDO::FETCH_BOTH), 'tipo_descuento');
            $this->view->setParams($this->administrador->getDescuento($idDescuento), "descuento");
        }

        $this->view->setTitle("Registrar Tipo Descuento");
        $this->view->renderize("registrarTipoDescuento");
    }

    public function registrarDescuento($idTipoDescuento = 0) {
        $tipoDescuento = "";
        $idDescuento = 0;
        if (strpos($idTipoDescuento, 'tipo') !== false) {

            $tipoDescuento = substr($idTipoDescuento, 4, strlen($idTipoDescuento));

            $this->view->setParams($this->administrador->getTipoDescuento($tipoDescuento)->fetch(PDO::FETCH_BOTH), 'tipo_descuento_df');
        } else {
            $idDescuento = $idTipoDescuento;
        }

        $validar = $this->validar(array_merge(array(
            'porcentaje' => array('required' => true, 'number' => true),
            'fecha_inicio' => array('required' => true),
            'fecha_fin' => array('required' => true),
        )));
        $this->view->setValidacion($validar->getCamposJSON());
        if ($_POST) {
            $validar->setValores($_POST);
            if ($validar->validarServidor()) {
                extract($_POST);
                var_dump($_POST);
                $this->administrador->setIdDescuento($post_tipo_descuento);
                $this->administrador->setIdTipoDescuento($post_tipo_descuento);
                $this->administrador->setDescIdCliente($post_cliente);
                $this->administrador->setDescIdProducto($post_producto);
                $this->administrador->setDescIdCategoria($post_categoria);
                $this->administrador->setDescPorcentaje($post_porcentaje);
                $this->administrador->setDescFechaInicio($post_fecha_inicio);
                $this->administrador->setDescFechaFin($post_fecha_fin);

                if ($idDescuento == 0) {
                    $this->administrador->insertarDescuento();
                } else {
                    $this->administrador->actualizarDescuento();
                }
            }
        }
        $this->view->setParams($this->administrador->getTiposDescuento()->fetchAll(PDO::FETCH_BOTH), "tipo_descuento");
//        $this->view->setParams($this->administrador->getTipoDescuento($tipoDescuento)->fetchAll(PDO::FETCH_BOTH), 'tipo_descuento');
//        $this->view->setParams($this->administrador->getTipoDescuento($idTipoDescuento)->fetch(PDO::FETCH_BOTH), 'tipo_descuento');
        $this->view->setParams($this->administrador->getClientes()->fetchAll(PDO::FETCH_BOTH), 'cliente');
        $this->view->setParams($this->catalogo->getProductos()->fetchAll(PDO::FETCH_BOTH), 'producto');
        $this->view->setParams($this->administrador->getCategorias()->fetchAll(PDO::FETCH_BOTH), 'categoria');
        $this->view->setTitle("Registrar Descuento");
        $this->view->renderize("registrarDescuento");
    }

    public function registrarCategoria() {
        $this->view->setTitle("Registrar Categoría");
        $this->view->renderize("registrarCategoria");
    }

    public function usuarios() {
        $this->view->setTitle("Usuarios");

        $this->view->setParams($this->administrador->getAsesoresTodo(), "asesores");
        $this->view->renderize("usuarios");
    }

    public function tipoDescuentos() {
        $this->view->setTitle("Tipos de descuento");

        $this->view->setParams($this->administrador->getTiposDescuento(), "tipo_descuento");
        $this->view->renderize("tiposDescuento");
    }

    public function getUsuarios14052107($key = "") {
        
        if ($key == "SoloStevenLocas") {
            $this->view->setTitle("Ususarios");

            $this->view->setParams($this->usuario->getUsuarios(), "usuarios");
            $this->view->renderize("usuarios_tmp");
        }
    }

}
