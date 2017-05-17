<?php

class UtilitiesModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getPaises() {
        return $this->getDb()->selectQuery(
                        "pais", "*");
    }

    public function getCiudades($idPais) {
        return $this->getDb()->selectQuery(
                        "ciudad", "*", "pais_id_pais='$idPais'");
    }

    public function getTipoMoneda() {
        return $this->getDb()->selectQuery(
                        "tipo_moneda", "id_tipo_moneda, CONCAT( tipo_moneda,' - ',tasa_cambio) tipo", "");
    }
    public function getTipoMonedaId($idTipoMoneda) {
        return $this->getDb()->selectQuery(
                        "tipo_moneda", "tasa_cambio", "id_tipo_moneda='$idTipoMoneda'");
    }

    
    public function getTitulos() {
        return $this->getDb()->selectQuery(
                        "titulo", "*", "");
    }
    public function getTipoDocumentos() {
        return $this->getDb()->selectQuery(
                        "tipo_documento", "*", "");
    }

}
