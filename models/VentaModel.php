<?php

class VentaModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getCotizaciones() {
        return $this->getDb()->selectQuery(
                        "cotizacion c ", "*", "");
    }

}
