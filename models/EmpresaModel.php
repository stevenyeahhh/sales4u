<?php

class EmpresaModel extends Model {

    private $id_empresa;
    private $tipoEmpresa;
    private $idAsesor;
    private $nit_empresa;
    private $nombre;
    private $telefono;
    private $fax;
    private $correo;
    private $direccion;
    private $id_tipo_empresa;
    private $margen_utilidad;
    private $costo_transporte_productos;
    private $costo_administracion;
    private $factor_costo;
    private $comision;
    private $plus;
    private $costo;
    private $longitud;
    private $latitud;
    private $ciudad_id_ciudad;
    private $fecha_registro;
    private $estado;
    ///////
    private $contactoTitulo;
    private $contactoNombre;
    private $contactoApellido;
    private $contactoDocumento;
    private $contactoEmail;
    private $contactoCiudad;
    private $contactoTipoDocumento;
    private $contactoAsesor;
    private $contactoCelular;

    public function setContactoCelular($contactoCelular) {
        $this->contactoCelular = $contactoCelular;
    }

    public function setContactoAsesor($contactoAsesor) {
        $this->contactoAsesor = $contactoAsesor;
    }

    public function setTipoEmpresa($tipoEmpresa) {
        $this->tipoEmpresa = $tipoEmpresa;
    }

    public function setContactoTipoDocumento($contactoTipoDocumento) {
        $this->contactoTipoDocumento = $contactoTipoDocumento;
    }

    public function setIdAsesor($idAsesor) {
        $this->idAsesor = $idAsesor;
    }

    public function setContactoDocumento($contactoDocumento) {
        $this->contactoDocumento = $contactoDocumento;
    }

    public function setContactoTitulo($contactoTitulo) {
        $this->contactoTitulo = $contactoTitulo;
    }

    public function setContactoNombre($contactoNombre) {
        $this->contactoNombre = $contactoNombre;
    }

    public function setContactoApellido($contactoApellido) {
        $this->contactoApellido = $contactoApellido;
    }

    public function setContactoEmail($contactoEmail) {
        $this->contactoEmail = $contactoEmail;
    }

    public function setContactoCiudad($contactoCiudad) {
        $this->contactoCiudad = $contactoCiudad;
    }

    public function setId_empresa($id_empresa) {
        $this->id_empresa = $id_empresa;
    }

    public function setNit_empresa($nit_empresa) {
        $this->nit_empresa = $nit_empresa;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setFax($fax) {
        $this->fax = $fax;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setId_tipo_empresa($id_tipo_empresa) {
        $this->id_tipo_empresa = $id_tipo_empresa;
    }

    public function setMargen_utilidad($margen_utilidad) {
        $this->margen_utilidad = $margen_utilidad;
    }

    public function setCosto_transporte_productos($costo_transporte_productos) {
        $this->costo_transporte_productos = $costo_transporte_productos;
    }

    public function setCosto_administracion($costo_administracion) {
        $this->costo_administracion = $costo_administracion;
    }

    public function setFactor_costo($factor_costo) {
        $this->factor_costo = $factor_costo;
    }

    public function setComision($comision) {
        $this->comision = $comision;
    }

    public function setPlus($plus) {
        $this->plus = $plus;
    }

    public function setCosto($costo) {
        $this->costo = $costo;
    }

    public function setLongitud($longitud) {
        $this->longitud = $longitud;
    }

    public function setLatitud($latitud) {
        $this->latitud = $latitud;
    }

    public function setCiudad_id_ciudad($ciudad_id_ciudad) {
        $this->ciudad_id_ciudad = $ciudad_id_ciudad;
    }

    public function setFecha_registro($fecha_registro) {
        $this->fecha_registro = $fecha_registro;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function __construct() {
        parent::__construct();
    }

    public function getTipoEmpresas() {
        return $this->getDb()->selectQuery(
                        "tipo_empresa", "*");
    }

    public function getEmpresas($nombre = null) {
        
        if ($nombre != null) {
            $nombre = strtoupper($nombre);
            return $this->getDb()->selectQuery(
                            "empresa e", " e.id_empresa,e.nit_empresa,e.nombre,e.estado ", "UPPER(e.nombre) LIKE '%$nombre%'");
        } else {
            return $this->getDb()->selectQuery(
                            "empresa e", " e.id_empresa,e.nit_empresa,e.nombre,e.estado ");
        }
    }

    public function getEmpresasNombre() {
        return $this->getDb()->selectQuery(
                        "empresa e", " e.id_empresa,e.nombre,e.estado ");
    }

    public function getEmpresasContacto() {
        return $this->getDb()->selectQuery(
                        "empresa e JOIN contacto c "
                        . "  ON c.empresa_id_empresa=e.id_empresa"
                        . " JOIN usuario u "
                        . "  ON u.id_usuario=c.usuario_id_usuario", "c.id_cliente, CONCAT( e.nombre,  ' - ', u.nombre ) ", "", "");
    }

    public function insertar() {
        include_once ROOT . 'models' . DS . 'UsuarioModel.php';
        $idEmpresa = $this->getDb()->insertQuery("empresa", "nit_empresa,nombre,telefono,fax,correo,direccion,id_tipo_empresa,margen_utilidad,costo_transporte_productos,costo_administracion,factor_costo,comision,plus,costo,longitud,latitud,ciudad_id_ciudad", "'$this->nit_empresa','$this->nombre','$this->telefono','$this->fax','$this->correo','$this->direccion','$this->id_tipo_empresa','$this->margen_utilidad','$this->costo_transporte_productos','$this->costo_administracion','$this->factor_costo','$this->comision','$this->plus','$this->costo','$this->longitud','$this->latitud','$this->ciudad_id_ciudad'");
        if ($idEmpresa == 0) {
            die("Error, no se insertó la empresa");
        }


        foreach ($this->contactoNombre as $key => $n) {

            $usuario = new UsuarioModel();
            $usuario->setTitulo($this->contactoTitulo[$key]);
            $usuario->setNombre($this->contactoNombre[$key]);
            $usuario->setApellido($this->contactoApellido[$key]);
            $usuario->setDocumento($this->contactoDocumento[$key]);
            $usuario->setRol_id_rol(2);
            $usuario->setEmail($this->contactoEmail[$key]);
            $usuario->setUsuario($this->contactoEmail[$key]);
            $usuario->setClave(md5($this->contactoDocumento[$key]));
            $usuario->setCiudad($this->contactoCiudad[$key]);
            $usuario->setId_tipo_documento($this->contactoTipoDocumento[$key]);
            $usuario->setCelular($this->contactoCelular[$key]);

            $idContactoAsesor = $this->contactoAsesor[$key] == "" ? "null" : "'" . $this->contactoAsesor[$key] . "'";

//            var_dump($this->contactoAsesor[$key]=="");

            $idUsuario = $usuario->registrar();
            if ($idUsuario == 0) {
                die("No se insertó el usuario");
            }


            $idContacto = $this->getDb()->insertQuery("contacto", "usuario_id_usuario,empresa_id_empresa,vendedor_id_vendedor", "'$idUsuario','$idEmpresa',$idContactoAsesor");
            if ($idContacto == 0) {
                die("No se insertó el contacto");
            }
        }


        return true;
    }

    public function getEmpresa($idEmpresa) {
//        var_dump($this->getDb());
        return $this->getDb()->selectQuery("empresa e JOIN ciudad c ON c.id_ciudad=e.ciudad_id_ciudad JOIN pais p ON p.id_pais=c.pais_id_pais ", "e.*,p.id_pais,c.id_ciudad", "id_empresa='$idEmpresa'");
    }

    public function getContactos($idEmpresa) {
        return $this->getDb()->selectQuery("contacto c "
                        . " JOIN usuario u ON u.id_usuario=c.usuario_id_usuario JOIN titulo t ON t.id_titulo=u.titulo_id_titulo"
                        . " JOIN ciudad ci ON ci.id_ciudad=u.ciudad_id_ciudad "
                        . " JOIN pais p ON p.id_pais=ci.pais_id_pais", "c.id_cliente,CONCAT(u.nombre,' ',u.apellido ) nombre, t.titulo,u.celular,u.correo,ci.ciudad,p.pais"
                        , "c.empresa_id_empresa='$idEmpresa'");
    }

}
