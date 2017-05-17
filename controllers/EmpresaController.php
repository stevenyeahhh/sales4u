<?php

class EmpresaController extends Controller {

    private $empresa;
    private $utilities;
    private $administrador;

    public function __construct() {

        parent::__construct();
        $this->empresa = $this->loadModel("Empresa");
        $this->utilities = $this->loadModel("Utilities");
        $this->administrador = $this->loadModel("Administrador");
    }

    public function index() {
        $this->view->setTableoptionone(
                array(
                    array('url' => 'Venta/crearCotizacion/', 
                        'desc' => 'Crear cotización'), 
                    array('url' => 'Vendedor/registrarVisitaComercial/', 
                        'desc' => 'Registrar Visita comercial'),
                    array(
                          'url'=>'catalogo/registrarProducto/',
                        'desc'=>'Registrar productos')));
        $this->view->setTableoptionmul(array());
        $this->view->setParams($this->empresa->getEmpresas(), "empresa");
        $this->view->setTitle("Empresas");
//        $this->view->renderize("registrarpend");
        $this->view->renderize("consultar");
    }

    public function getEmpresasJSON($nombre = null) {
        echo json_encode($this->empresa->getEmpresas($nombre)->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
    }

    public function registrarTipoEmpresa() {//Va a estar pre-cargado
    }

    public function registrarEmpresa($idEmpresa=0) {
        if ($idEmpresa != 0) {
//            $this->view->setParams($this->empresa->getEmpresasNombre()->fetchAll(PDO::FETCH_BOTH), "empresas");
            $empresa=$this->empresa->getEmpresa($idEmpresa)->fetch(PDO::FETCH_BOTH);
            foreach($empresa as $key=>$value){
                $this->view->setParams($value, $key);
            }
            $this->view->setParams($empresa["id_pais"], "pais_df");
            
            
        }
        $this->view->setAngularRequires("dialogService");
//        echo "<pre>";
//        var_dump($_POST);
//        echo "</pre>";
        $validar = $this->validar(array_merge(array(
            'nitipo_empresa' => array('required' => true, 'number' => true),
            'nit_empresa' => array('required' => true, 'number' => true, 'minlength' => 9),
            'nombre' => array('required' => true, 'minlength' => 3),
            'telefono' => array('required' => true, 'number' => true, 'minlength' => 7),
            'fax' => array('number' => true, 'minlength' => 7),
            'correo' => array('required' => true, 'email' => true),
            'direccion' => array('required' => true, 'minlength' => 6),
            'pais' => array('required' => true, 'number' => true),
            'ciudad' => array('required' => true, 'number' => true),
            'margen_utilidad' => array('depends' => 'nitipo_empresa$2$3', 'required' => true, 'number' => true),
            'costo_transporte' => array('depends' => 'nitipo_empresa$2$3', 'required' => true, 'number' => true),
            'costo_administracion' => array('depends' => 'nitipo_empresa$2$3', 'required' => true, 'number' => true),
            'factor_costo' => array('depends' => 'nitipo_empresa$2$3', 'number' => true),
            'comision' => array('depends' => 'nitipo_empresa$2$3', 'required' => true, 'number' => true),
            'plus' => array('depends' => 'nitipo_empresa$2$3', 'required' => true, 'number' => true),
            'costo' => array('depends' => 'nitipo_empresa$2$3', 'required' => true, 'number' => true),
//            'okposition'=>array('required'=>true)
        )));

        $this->view->setValidacion($validar->getCamposJSON());
        if ($_POST) {
            $validar->setValores($_POST);
            if ($validar->validarServidor()) {
                extract($_POST);

                $this->empresa->setNit_empresa($post_nit_empresa);
                $this->empresa->setIdAsesor($post_asesor);
                $this->empresa->setNombre($post_nombre);
                $this->empresa->setTelefono($post_telefono);
                $this->empresa->setFax($post_fax);
                $this->empresa->setCorreo($post_correo);
                $this->empresa->setDireccion($post_direccion);
                $this->empresa->setId_tipo_empresa($post_nitipo_empresa);
                $this->empresa->setMargen_utilidad($post_margen_utilidad);
                $this->empresa->setCosto_transporte_productos($post_costo_transporte);
                $this->empresa->setCosto_administracion($post_costo_administracion);
                $this->empresa->setFactor_costo($post_factor_costo);
                $this->empresa->setComision($post_comision);
                $this->empresa->setPlus($post_plus);
                $this->empresa->setCosto($post_costo);
                $this->empresa->setLongitud($post_lng);
                $this->empresa->setLatitud($post_lat);
                $this->empresa->setCiudad_id_ciudad($post_ciudad);

                $this->empresa->setContactoNombre($_POST[post_nombre]);
                $this->empresa->setContactoApellido($_POST[post_apellido]);
                $this->empresa->setContactoDocumento($_POST[post_documento]);
                $this->empresa->setContactoTipoDocumento($_POST[post_tipo_documento]);

                $this->empresa->setContactoCelular($_POST[post_celular]);

                $this->empresa->setContactoTitulo($_POST[post_titulo]);
                $this->empresa->setContactoCiudad($_POST[post_ciudad_contacto]);
                $this->empresa->setContactoEmail($_POST[post_email]);
                $this->empresa->setContactoAsesor($_POST[post_asesor]);

                $this->empresa->insertar();
            } else {
                echo "Hola.error";
            }
        }
        $pais = $this->utilities->getPaises()->fetchAll(PDO::FETCH_BOTH);

        $this->view->setParams($this->administrador->getAsesores()->fetchAll(PDO::FETCH_BOTH), "asesor_tmp");
        $this->view->setParams($this->empresa->getTipoEmpresas()->fetchAll(PDO::FETCH_BOTH), "nitipo_empresa");
        $this->view->setParams($this->utilities->getTitulos()->fetchAll(PDO::FETCH_BOTH), "titulo_tmp");
        $this->view->setParams($this->utilities->getTipoDocumentos()->fetchAll(PDO::FETCH_BOTH), "tipo_documento_tmp");

        $this->view->setParams($pais, "pais");
        $this->view->setParams($pais, "pais_contacto");
        $this->view->setTitle("Registrar empresa");
//        $this->view->renderize("registrarpend");
        $this->view->renderize("registrar");
    }

    public function registrarEmpresaCliente() {
        $this->view->setTitle("Registrar empresa cliente");
        $this->view->renderize("registrarCliente");
    }

    public function asignarContacto($idEmpresa) {
        
    }

}
