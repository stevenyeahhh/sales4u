<?php

class AdministradorModel extends Model {

    private $tipoDescuento;
    private $idTipoDescuento;
    private $descIdCliente;
    private $descIdProducto;
    private $descIdCategoria;
    private $descPorcentaje;
    private $descFechaInicio;
    private $descFechaFin;
    private $idDescuento;

    public function setIdDescuento($idDescuento) {
        $this->idDescuento = $idDescuento;
    }

    public function setDescIdCliente($descIdCliente) {
        $this->descIdCliente = $descIdCliente;
    }

    public function setDescIdProducto($descIdProducto) {
        $this->descIdProducto = $descIdProducto;
    }

    public function setDescIdCategoria($descIdCategoria) {
        $this->descIdCategoria = $descIdCategoria;
    }

    public function setDescPorcentaje($descPorcentaje) {
        $this->descPorcentaje = $descPorcentaje;
    }

    public function setDescFechaInicio($descFechaInicio) {
        $this->descFechaInicio = $descFechaInicio;
    }

    public function setDescFechaFin($descFechaFin) {
        $this->descFechaFin = $descFechaFin;
    }

    public function setIdTipoDescuento($idTipoDescuento) {
        $this->idTipoDescuento = $idTipoDescuento;
    }

    public function setTipoDescuento($tipoDescuento) {
        $this->tipoDescuento = $tipoDescuento;
    }

    public function __construct() {
        parent::__construct();
    }

    public function getAsesores() {
        return $this->getDb()->selectQuery(
                        "usuario u", "u.id_usuario, CONCAT( u.nombre,  ' - ', u.apellido ) asesores", "rol_id_rol='3' AND estado='1'", "");
    }

    public function getClientes() {
        return $this->getDb()->selectQuery(
                        "usuario u JOIN contacto c ON c.usuario_id_usuario=u.id_usuario", "c.id_cliente, CONCAT( u.nombre,  ' - ', u.apellido ) asesores", "u.rol_id_rol='2' AND u.estado='1'", "");
    }

    public function getAsesoresTodo() {
        return $this->getDb()->selectQuery(
                        "usuario u  JOIN titulo ti ON ti.id_titulo=u.titulo_id_titulo JOIN ciudad ci ON ci.id_ciudad=u.ciudad_id_ciudad JOIN pais p ON p.id_pais=ci.pais_id_pais JOIN tipo_documento td ON td.id_tipo_documento=u.id_tipo_documento", "u.id_usuario,p.pais,ci.ciudad,ti.titulo,u.nombre,u.apellido,u.correo,td.tipo_documento,u.documento,u.celular,u.fecha_registro,u.estado", "u.rol_id_rol='3' AND u.estado='1'", "");
    }

    public function getTiposDescuento() {
        return $this->getDb()->selectQuery(
                        "tipo_descuento", "id_tipo_descuento,tipo_descuento,estado", "estado='1'");
    }

    public function registrarTipoDescuento() {
        return $this->getDb()->insertQuery("tipo_descuento", "tipo_descuento", "'$this->tipoDescuento'");
    }

    public function actualizarTipoDescuento() {
        return $this->getDb()->updateQuery("tipo_descuento", "tipo_descuento='$this->tipoDescuento'", "id_tipo_descuento='$this->idTipoDescuento'");
    }

    public function getTipoDescuento($idTipoDescuento) {
        return $this->getDb()->selectQuery(
                        "tipo_descuento", "id_tipo_descuento,tipo_descuento,estado", "id_tipo_descuento='$idTipoDescuento'");
    }

    public function getDescuento($idTipoDescuento) {
        return $this->getDb()->selectQuery(
                        "descuento d LEFT JOIN contacto c ON c.id_cliente=d.id_cliente LEFT JOIN usuario u ON u.id_usuario=c.usuario_id_usuario LEFT JOIN empresa e ON e.id_empresa=c.empresa_id_empresa "
                        . " LEFT JOIN producto p ON p.id_producto=d.id_producto "
                        . " LEFT JOIN categoria_producto cp ON cp.id_categoria_producto=d.id_categoria_producto", "d.id_descuento,u.nombre,u.apellido,e.nombre nombre_empresa,p.nombre nombre_producto,cp.categoria,d.porcentaje,d.fecha_inicio,d.fecha_fin,d.estado", "d.id_tipo_descuento='$idTipoDescuento'");
    }

    public function getCategorias() {
        return $this->getDb()->selectQuery(
                        "categoria_producto", "*", "");
    }

    public function insertarDescuento() {
        $cliente = $this->descIdCliente == '' ? "null" : "'$this->descIdCliente'";
        $producto = $this->descIdProducto == '' ? "null" : "'$this->descIdProducto'";
        $categoria = $this->descIdCategoria == '' ? "null" : "'$this->descIdCategoria'";


        return $this->getDb()->insertQuery("descuento", "id_tipo_descuento,id_cliente,id_producto,id_categoria_producto,porcentaje,fecha_inicio,fecha_fin", "'$this->idTipoDescuento',$cliente,$producto,$categoria,'$this->descPorcentaje','$this->descFechaInicio','$this->descFechaFin'");
    }

    public function actualizarDescuento() {
        $cliente = $this->descIdCliente == '' ? "null" : "'$this->descIdCliente'";
        $producto = $this->descIdProducto == '' ? "null" : "'$this->descIdProducto'";
        $categoria = $this->descIdCategoria == '' ? "null" : "'$this->descIdCategoria'";

        return $this->getDb()->updateQuery("descuento", "id_tipo_descuento='$this->idTipoDescuento',
                        id_cliente=$cliente,
                        id_producto=$producto,
                        id_categoria_producto=$categoria,
                        porcentaje='$this->descPorcentaje',
                        fecha_inicio='$this->descFechaInicio',
                        fecha_fin='$this->descFechaFin'", "id_descuento='$this->idDescuento'");
    }

    public function getVendedorData($idVendedor) {
        return $this->getDb()->selectQuery(
                        "vendedor", "firma", "usuario_id_usuario='$idVendedor'");
    }

}
