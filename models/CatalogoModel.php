<?php

class CatalogoModel extends Model {

    /**
     * Producto
     */
    private $idProducto;
    private $idEmpresa;
    private $nombre;
    private $descripcion;
    private $foto;
    private $peso;
    private $volumen;
    private $referencia;
    private $presentacion;
    private $referenciaLocal;
    private $idTipoMoneda;
    private $costoInicial;
    private $costoReal;
    private $costo;
    private $iva;


    /*     * *
     * Disponibilidad
     */
    private $cantidad;
    private $disponibilidad;

    public function setDisponibilidad($disponibilidad) {
        $this->disponibilidad = $disponibilidad;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setCosto($costo) {
        $this->costo = $costo;
    }

    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setPeso($peso) {
        $this->peso = $peso;
    }

    public function setVolumen($volumen) {
        $this->volumen = $volumen;
    }

    public function setReferencia($referencia) {
        $this->referencia = $referencia;
    }

    public function setPresentacion($presentacion) {
        $this->presentacion = $presentacion;
    }

    public function setReferenciaLocal($referenciaLocal) {
        $this->referenciaLocal = $referenciaLocal;
    }

    public function setIdTipoMoneda($idTipoMoneda) {
        $this->idTipoMoneda = $idTipoMoneda;
    }

    public function setCostoInicial($costoInicial) {
        $this->costoInicial = $costoInicial;
    }

    public function setCostoReal($costoReal) {
        $this->costoReal = $costoReal;
    }

    public function setIva($iva) {
        $this->iva = $iva;
    }

    public function __construct() {
        parent::__construct();
    }

    public function getProductos() {
        return $this->getDb()->selectQuery(
                        "producto p ", "*", "");
    }

    public function getProducto($idProducto) {
        return $this->getDb()->selectQuery(
                        "producto p LEFT JOIN disponibilidad d ON p.id_producto=d.producto_id_producto", "*", "p.id_producto='$idProducto'");
    }

    public function insertarProducto() {
        return $this->getDb()->insertQuery("producto", "id_empresa_proveedor,nombre,descripcion,foto,peso,volumen,referencia,presentacion,referencia_local,tipo_moneda_id_tipo_moneda,costo,costo_real,costo_inicial,iva", "'$this->idEmpresa','$this->nombre','$this->descripcion','$this->foto','$this->peso','$this->volumen','$this->referencia','$this->presentacion','$this->referenciaLocal','$this->idTipoMoneda','$this->costo','$this->costoReal','$this->costoInicial','$this->iva'");
    }

    public function insertarDisponibilidad() {
        return $this->getDb()->insertQuery("disponibilidad", "producto_id_producto,cantidad,disponibilidad", "'$this->idProducto','$this->cantidad','$this->disponibilidad'");
    }

    public function getProductoLocalRef($localRef) {
        $localRef = strtoupper($localRef);
        return $this->getDb()->selectQuery(
                        "producto p LEFT JOIN disponibilidad d ON p.id_producto=d.producto_id_producto AND d.estado='1'", 
                "p.id_producto, p.nombre, p.descripcion, CONCAT('".BASE."img/productImages/',p.foto) foto, p.referencia,p.referencia_local,p.costo, SUM(d.cantidad) cantidad,SUM(d.disponibilidad) disponible", 
                "UPPER(p.referencia_local) LIKE '%$localRef%' AND p.estado='1' GROUP BY p.id_producto, p.nombre, p.descripcion, CONCAT('".BASE."img/productImages/',p.foto) , p.referencia,p.referencia_local,p.costo"
                );
    }

}
