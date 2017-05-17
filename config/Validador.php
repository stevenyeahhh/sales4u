<?php

class Validador {

    private $campos;
    private $valores;
    private $valoresQuitados;

    public function __construct() {
        $this->campos = array();
        $this->valoresQuitados = array();
    }

    public function setValores($valores) {
        $this->valores = $valores;
    }

    public function setCampos(array $campos) {
        $this->campos = $campos;
    }

    public function getCamposJSON() {
        return json_encode($this->campos);
    }

    public function quitarValidacionesServidor($valores) {
        $this->valoresQuitados = $valores;
    }

    public function validarServidor() {
        $isValid = false;

        foreach ($this->campos as $key => $value) {
            foreach ($value as $validacion => $valor) {
                if (!array_key_exists($key, $this->valoresQuitados)) {
                    $strValue = $this->valores[POSTSUFIX . $key];
//                    echo $strValue . "-----" . $validacion . "<br/>";
                    if ($validacion === "required") {

                        if (!empty($strValue)) {
                            $isValid = true;
                        } else {
                            $isValid = false;
                            return $isValid;
                        }
                    }
                    if ($validacion === "number") {
                        var_dump($strValue);
                        if (is_numeric($strValue)) {
                            $isValid = true;
                        } else {
                            $isValid = false;
                            return $isValid;
                        }
                    }
                    if ($validacion === "minlength") {
                        if (strlen($strValue) >= $valor) {
                            $isValid = true;
                        } else {
                            $isValid = false;
                            return $isValid;
                        }
                    }
                    if ($validacion === "maxlength") {
                        if (strlen($strValue) <= $valor) {
                            $isValid = true;
                        } else {
                            $isValid = false;
                            return $isValid;
                        }
                    }

                    if ($validacion === "max") {
                        if ($strValue <= $valor) {
                            $isValid = true;
                        } else {
                            $isValid = false;
                            return $isValid;
                        }
                    }
                    if ($validacion === "min") {
                        if ($strValue >= $valor) {
                            $isValid = true;
                        } else {
                            $isValid = false;
                            return $isValid;
                        }
                    }
                    if ($validacion === "regexp") {
                        if (preg_match("/^$valor$/", $strValue) == 1) {
                            $isValid = true;
                        } else {
                            $isValid = false;
                            return $isValid;
                        }
                    }
                    if ($validacion === "email") {
                        echo "hola1";
                        if (filter_var($strValue, FILTER_VALIDATE_EMAIL)) {
                            echo "hola2";
                            $isValid = true;
                        } else {
                            echo "hola3";
                            $isValid = false;
                            return $isValid;
                        }
                    }
                    if ($validacion === "depends") {
                        $depends = explode("$", $valor);
                        $boolTemp=false;
                        for ($i = 1; $i < count($depends); $i++) {
                            echo $_POST[POSTSUFIX . $depends[0]]."................<br/>";
                            echo  $depends[$i]."----------<br/>";
                            if (!$_POST[POSTSUFIX . $depends[0]] == $depends[$i]) {
                                $boolTemp=true;
                            }
                            
                        }
                        if(!$boolTemp){
                            break 1;
                        }
                        $isValid = true;
                    }
                }
            }
        }
        return $isValid;
    }

    public function validarData() {
//        foreach()
    }

}
