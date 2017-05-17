<?php

class UsuarioModel extends Model {
    
    private $id_usuario;
    private $titulo;
    private $nombre;
    private $apellido;
    private $documento;
    private $rol_id_rol;
    private $email;
    private $usuario;
    private $clave;
    private $ciudad;
    private $id_tipo_documento;
    private $estado;
    private $fecha_registro;
    private $celular;
    
    
    
    public function setCelular($celular) {
        $this->celular = $celular;
    }

        public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }

        
    public function setId_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setDocumento($documento) {
        $this->documento = $documento;
    }

    public function setRol_id_rol($rol_id_rol) {
        $this->rol_id_rol = $rol_id_rol;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }

    public function setId_tipo_documento($id_tipo_documento) {
        $this->id_tipo_documento = $id_tipo_documento;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setFecha_registro($fecha_registro) {
        $this->fecha_registro = $fecha_registro;
    }

        
    public function __construct() {
        parent::__construct();
    }

    public function inciarSesion($usuario, $contrasena) {
        return $this->getDb()->selectQuery(
                        "usuario u JOIN titulo t ON t.id_titulo=u.titulo_id_titulo", "u.*,t.titulo", "u.usuario='$usuario' AND  u.clave='" . md5($contrasena) . "'");
    }
    public function getUsuarios() {
        return $this->getDb()->selectQuery(
                        "usuario u JOIN titulo t ON t.id_titulo=u.titulo_id_titulo JOIN rol r ON r.id_rol=u.rol_id_rol", "u.*,t.titulo,r.rol", "");
    }

    public function registrar() {
        return $this->getDb()->insertQuery("usuario", "titulo_id_titulo,nombre,apellido,documento,rol_id_rol,correo,usuario,clave,ciudad_id_ciudad,id_tipo_documento,celular", 
                "'$this->titulo','$this->nombre','$this->apellido','$this->documento','$this->rol_id_rol','$this->email','$this->usuario','$this->clave','$this->ciudad','$this->id_tipo_documento','$this->celular'");
    }
    public function registrarAsesor($comision_asignada,$firma,$codigo_vendedor) {
        $idUsuario=$this->registrar();
        return $this->getDb()->insertQuery("vendedor", "comision_asignada,firma,codigo_vendedor,usuario_id_usuario", 
                "'$comision_asignada','$firma','$codigo_vendedor','$idUsuario'");
    }

    /*
      public function actualizar() {//updateQuery($table, $columnValues, $where)
      return $this->getDb()->updateQuery("USUARIO", "nombre ='$this->nombre',
      apellidos ='$this->apellidos',
      numero_identificacion ='$this->numeroIdentificacion',
      fecha_nacimiento ='$this->fechaNacimiento',
      id_rol ='$this->idRol',
      id_tipo_identificacion ='$this->idTipoIdentificacion',
      id_genero_usuario ='$this->idGeneroUsuario',
      id_cargo_trabajo ='$this->idCargoTrabajo'", "id_usuario='$this->idUsuario'");
      }

      public function getRoles() {
      return $this->getDb()->selectQuery(
      "ROL r ", "*", "");
      }

      public function selectUsuario() {
      return $this->getDb()->query("SELECT id_usuario,nombre_usuario,contrasena,nombre,apellidos,numero_identificacion,fecha_nacimiento,id_rol,id_tipo_identificacion,id_genero_usuario,id_cargo_trabajo FROM USUARIO");
      }

      public function selectUsuariosParaHabilitar() {
      return Singleton::getInstance()->db->query("SELECT u.id_usuario as u_id_usuario,
      u.nombre as u_nombre,
      u.apellidos as u_apellidos,
      u.numero_identificacion as u_numero_identificacion,
      ct.id_cargo_trabajo as ct_id_cargo_trabajo,
      ct.nombre as ct_nombre,
      at.id_area_trabajo as at_id_area_trabajo,
      at.nombre as at_nombre
      FROM USUARIO u
      JOIN CARGO_TRABAJO ct ON ct.id_cargo_trabajo = u.id_cargo_trabajo
      JOIN AREA_TRABAJO at ON at.id_area_trabajo = ct.id_area_trabajo
      WHERE u.id_rol = 2");
      }

      public function getUsuarioPorId($id) {
      return Singleton::getInstance()->db->selectQuery("USUARIO "
      , "id_usuario,nombre_usuario,contrasena,nombre,apellidos,numero_identificacion,fecha_nacimiento,id_rol,id_tipo_identificacion,id_genero_usuario,id_cargo_trabajo"
      , "id_usuario= '$id'");
      }

      public function getUsuarioPorRol($rol) {
      return Singleton::getInstance()->db->selectQuery("USUARIO u join TIPO_IDENTIFICACION ti ON (ti.id_tipo_identificacion=u.id_tipo_identificacion) JOIN GENERO_USUARIO gu ON(gu.id_genero_usuario=u.id_genero_usuario) JOIN CARGO_TRABAJO ct ON (ct.id_cargo_trabajo=u.id_cargo_trabajo)", "u.id_usuario,u.nombre_usuario,u.nombre,u.apellidos,u.numero_identificacion,u.fecha_nacimiento,ti.nombre tipo_identificacion,gu.nombre genero_usuario,ct.nombre cargo_trabajo,u.estado "
      , " u.id_rol= '$rol'");
      }

      public function cambiarEstado($id, $estado) {
      return Singleton::getInstance()->db->updateQuery("USUARIO", "estado='$estado'", " id_usuario='$id'");
      }
     */
}
