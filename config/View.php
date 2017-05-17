<?php

class View {

//Responsabilidad: Encargarse de de mostrar los diferentes elementos que pertenecen a cada vista como lo son:
// menús, títulos, tablas, etcétera. 
    private $controller;
    private $title;
    private $jsScripts;
    private $viewPath;
    private $controllerPath;
    private $error;
    private $params;
    private $mensaje;
    private $barmenu;
    private $barmenu2;
    private $tablas;
    private $msgBienvenida;
    private $angularRequires;
    private $tableoptionone;
    private $tableoptionmul;

    public function setTableoptionone($tableoptionone) {
        $this->tableoptionone = $tableoptionone;
    }

    public function setTableoptionmul($tableoptionmul) {
        $this->tableoptionmul = $tableoptionmul;
    }

    public function __construct($controller) {
        $this->controller = strtolower($controller);
        $this->jsScripts = array();
        $this->barmenu2 = array();
        $this->angularRequires = array();
        $this->tableoptionmul = array();
        $this->tableoptionone = array();
    }

    public function setAngularRequires($param) {
        $this->angularRequires[] = $param;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function setMsgBienvenida($msgBienvenida) {
        $this->msgBienvenida = $msgBienvenida;
    }

    public function setError($error) {
        $this->error = $error;
    }

    public function renderize($view, $headers = true) {

        $this->controllerPath = BASE . DS . $this->controller . '/';
        $this->viewPath = BASE . 'views' . DS . $this->controller . DS;
        $paramsPath = ROOT . 'views/layout/' . DEFAULT_LAYOUT . '/';
        $layout = array(
            'css' => $paramsPath . 'css/',
            'img' => $paramsPath . 'img/',
            'js' => $paramsPath . 'js/'
        );

        $viewPath = ROOT . 'views' . DS . $this->controller . DS . $view . '.phtml';
//        echo $viewPath;

        if (is_readable($viewPath)) {
            if ($headers) {
                include_once ROOT . 'views' . DS . 'layout' . DS . 'header.phtml';
            }
            include_once $viewPath;
            if ($headers) {
                include_once ROOT . 'views' . DS . 'layout' . DS . 'footer.phtml';
            }
        }
    }

    public function setJs(array $js) {
        $this->jsScripts = $js;
    }

    public function setParams($param, $name) {
        $this->params[$name] = $param;
    }

    public function setMenu($menu) {
        $this->barmenu = $menu;
    }

    public function quitarMenu() {
        $this->barmenu2 = array();
    }

    public function setMenu2($menu) {
        if (count($this->barmenu2) == 0) {
            $this->barmenu2 = $menu;
        } else {
            $size = count($this->barmenu2);
            for ($i = 0; $i < count($menu); $i++) {
                $this->barmenu2 [$i + $size] = $menu[$i];
            }
        }
    }

    public function agregarTabla($tabla, array $columnas, $nombreTabla, $both) {
        $this->tablas[] = array("tabla" => $tabla, "columnas" => $columnas, "NOMBRE_TABLA" => $nombreTabla, "ENC" => $both);
    }

    public function crearTabla($pdoStatement, array $columnas, $nombreTabla, array $opciones) {

        $urlConsultar = $opciones[urlConsultar];
        $urlAjax = $opciones[urlAjax];
        $isWithSlide = $opciones[isWithSlide];
        $create = $opciones[create];
//        var_dump($opciones);
        echo '<script>$(document).ready(function() {
                crearBootstrapSwitch(".slider-tabla", "' . $urlAjax . '")
            })</script>';
//        echo '<div class="table-options" style="display: none">';
        echo '<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Opciones
  <span class="caret"></span></button>
  <ul class="dropdown-menu">';
        if ($create) {
            echo '<li ><a href="' . BASE . $create . '">Nuevo</a></li>';
            echo '<li role="presentation" class="divider"></li>';
        }
        for ($i = 0; $i < count($this->tableoptionone); $i++) {
            echo '<li class="table-options-one" style="display:none"><a href="' . BASE . $this->tableoptionone[$i][url] . '">' . $this->tableoptionone[$i][desc] . '</a></li>';
        }
        for ($i = 0; $i < count($this->tableoptionmul); $i++) {
            echo '<li class="table-options-mult" style="display:none"><a href="' . BASE . $this->tableoptionmul[$i][url] . '">' . $this->tableoptionmul[$i][desc] . '</a></li>';
        }
        echo '</ul></div>';
        echo '<div >';

//        echo '</div><div class="table-options-mult">';
//        echo '<div class="dropdown" style="display:none">
//  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Opciones
//  <span class="caret"></span></button>
//  <ul class="dropdown-menu">';
//          for ($i = 0; $i < count($this->tableoptionmul); $i++) {
//            echo '<li><a href="'.BASE.$this->tableoptionmul[$i][url] .'">'.$this->tableoptionmul[$i][desc].'</a></li>';
//        }
//    echo '
//  </ul>
//</div>';

        echo '</div>';
        echo "<div class='table-responsive'>";
        echo "<table class='table table-hover '>";
        $tablaDatos = $pdoStatement;
        $columnasNumero = count($tablaDatos, COUNT_RECURSIVE);
        $totalColumnas = $tablaDatos->columnCount();
        echo "<tr>";
        echo "<th></th>";
        for ($j = 0; $j < $totalColumnas; $j++) {
            echo "<th>";
            if (isset($columnas[$j])) {
                echo $columnas[$j];
            } else {
//                echo "-";
                echo $tablaDatos->getColumnMeta($j)["name"];
            }
            echo "</th>";
        }
        echo "</tr>";
        $tablaDatos = $tablaDatos->fetchAll(PDO::FETCH_NUM);
        $totalFilas = count($tablaDatos);
        for ($p = 0; $p < count($tablaDatos); $p++):
            echo "<tr>";
            echo "<td><input type='checkbox' name='' class='row-table' data-val='" . $tablaDatos[$p][0] . "' /></td>";
            for ($h = 0; $h < $totalColumnas; $h++):
                echo "<td>";

//                if ($h == 0) {
//                    echo "<a href='http://$_SERVER[HTTP_HOST]/$urlConsultar/" . $tablaDatos[$p][0] . "'>" . ($p + 1) . "</a>";
//                    echo "<a href='".BASE."$urlConsultar/" . $tablaDatos[$p][0] . "'>" . ($p + 1) . "</a>";
//                } else {
                if ($h === ($totalColumnas - 1)) {
                    if ($isWithSlide) {

                        echo "<input type='checkbox' class='slider-tabla'  " . (( $tablaDatos[$p][$h] == 1) ? "checked" : "") . " value='" . $tablaDatos[$p][0] . "'/>";
                    } else {
                        if (is_numeric($tablaDatos[$p][$h])) {
                            echo $tablaDatos[$p][$h] ? "SI" : "NO";
                        } else {
//                                echo "<a href='http://$_SERVER[HTTP_HOST]/$urlConsultar/" . $tablaDatos[$p][0] . "'>" . $tablaDatos[$p][$h] . "</a>";
                            echo "<a href='" . BASE . "$urlConsultar/" . $tablaDatos[$p][0] . "'>" . $tablaDatos[$p][$h] . "</a>";
                        }
                    }
                } else {
                    echo "<a href='" . BASE . "$urlConsultar/" . $tablaDatos[$p][0] . "'>" . $tablaDatos[$p][$h] . "</a>";
//                        echo "<a href='http://$_SERVER[HTTP_HOST]/$urlConsultar/" . $tablaDatos[$p][0] . "'>" . $tablaDatos[$p][$h] . "</a>";
                }
//                }
                echo "</td>";
            endfor;
            echo "</tr>";
        endfor;


        echo "</table>";
        echo "</div>";
    }

    public function crearTablaRegistroUnico($pdoStatement, array $columnas, $nombreTabla, $valoresQuitar = false) {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-hover '>";
        $tablaDatos = $pdoStatement;
//        $tablaDatos=$tablaDatos->fetch(PDO::FETCH_ASSOC);
        if (!empty($nombreTabla)) {
            echo "<tr><th colspan='2'>$nombreTabla</th></tr>";
        }
        foreach ($tablaDatos as $key => $value) {
            if ($valoresQuitar == false) {
                echo "<tr>";
                echo "<th>$key</th>";
                echo "<td>$value</td>";
                echo "</tr>";
            } else {
                if (!array_key_exists($key, $valoresQuitar)) {

                    echo "<tr>";
                    echo "<th>$key</th>";
                    echo "<td>$value</td>";
                    echo "</tr>";
                }
            }
        }
        echo "</table>";
        echo "</div>";
    }

    public function crearTablaRegistroUnicoActualizar($pdoStatement, array $columnas, $valoresReemplazar = false, $valoresSelect = false) {
        echo "<form method='post'>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-hover '>";
        $tablaDatos = $pdoStatement;
//        $tablaDatos=$tablaDatos->fetch(PDO::FETCH_ASSOC);        

        foreach ($tablaDatos as $key => $value) {
            if ($key == "ESTADO") {
                echo "<tr>";
                echo "<th>$key</th>";
                echo "<td>$value</td>";
                echo "</tr>";
            } else {
                if ($valoresReemplazar) {
                    if ($valoresSelect) {
                        if (array_key_exists($key, $valoresSelect)) {
                            echo "<tr>";
                            echo "<th>$key</th>";
                            echo "<td><select class='form-control' name='" . preg_replace_callback("|\_[a-z]|", function($rep) {
                                for ($i = 0; $i < count($rep); $i++) {
                                    return strtoupper(str_replace("_", "", $rep[$i]));
                                }
                            }, strtolower($key)) . "'>";
                            foreach ($valoresSelect[$key] as $key2 => $value2) {
                                $selected = "";
                                if ($value2[$key] == $value) {
                                    $selected = "selected";
                                }
                                echo "<option $selected value='$value2[$key]'>" . $value2['DESCRIPCION'] . "</option>";
                            }
                            echo "</select></td> ";
                            echo "</tr>";
                        } else {
                            if (!array_key_exists($key, $valoresReemplazar)) {
                                echo "<tr>";
                                echo "<th>$key</th>";
                                echo "<td><input class='form-control' name='" . preg_replace_callback("|\_[a-z]|", function($rep) {
                                    for ($i = 0; $i < count($rep); $i++) {
                                        return strtoupper(str_replace("_", "", $rep[$i]));
                                    }
                                }, strtolower($key)) . "' value='$value'/></td>";
                                echo "</tr>";
                            }
                        }
                    } else {
                        if (!array_key_exists($key, $valoresReemplazar)) {
                            echo "<tr>";
                            echo "<th>$key</th>";
                            echo "<td><input class='form-control' name='" . preg_replace_callback("|\_[a-z]|", function($rep) {
                                for ($i = 0; $i < count($rep); $i++) {
                                    return strtoupper(str_replace("_", "", $rep[$i]));
                                }
                            }, strtolower($key)) . "' value='$value'/></td>";
                            echo "</tr>";
                        }
                    }
                } else {
                    if ($valoresSelect) {
                        if (array_key_exists($key, $valoresSelect)) {
                            echo "<tr>";
                            echo "<th>$key</th>";
                            echo "<td><select class='form-control' name='" . preg_replace_callback("|\_[a-z]|", function($rep) {
                                for ($i = 0; $i < count($rep); $i++) {
                                    return strtoupper(str_replace("_", "", $rep[$i]));
                                }
                            }, strtolower($key)) . "'>";
                            foreach ($valoresSelect[$key] as $key2 => $value2) {
                                $selected = "";
                                if ($value2[$key] == $value) {
                                    $selected = "selected";
                                }
                                echo "<option $selected value='$value2[$key]'>" . $value2['DESCRIPCION'] . "</option>";
                            }
                            echo "</select></td> ";
                            echo "</tr>";
                        } else {
                            if (!array_key_exists($key, $valoresReemplazar)) {
                                echo "<tr>";
                                echo "<th>$key</th>";
                                echo "<td><input class='form-control' name='" . preg_replace_callback("|\_[a-z]|", function($rep) {
                                    for ($i = 0; $i < count($rep); $i++) {
                                        return strtoupper(str_replace("_", "", $rep[$i]));
                                    }
                                }, strtolower($key)) . "' value='$value'/></td>";
                                echo "</tr>";
                            }
                        }
                    } else {
                        echo "<tr>";
                        echo "<th>$key</th>";
                        echo "<td><input class='form-control' name='" . preg_replace_callback("|\_[a-z]|", function($rep) {
                            for ($i = 0; $i < count($rep); $i++) {
                                return strtoupper(str_replace("_", "", $rep[$i]));
                            }
                        }, strtolower($key)) . "' value='$value'/></td>";
                        echo "</tr>";
                    }
                }
            }
        }

        echo "</table>";
        echo "</div>";
        echo "<input type='submit' value='actualizar' class='btn btn-info'/>";
        echo "</form>";
    }

    public function setValidacion($validacion) {
        $this->validacion = $validacion;
//        $this->barmenu2 = array();
    }

    public function createField($name, $title, $type, $value = "", $ro = "") {
        echo "<div class='row form-group form-inline'>";
        echo "<label for='$name' class='col-xs-4'>$title:</label>";
        $data = $this->params[$name];
        switch ($type) {
            case "text": case "number":case "email":case "password":case "file":case "date":
                $currentValue = $_POST[POSTSUFIX . $name];
                if ($type == "file")
                    $onselect = "on-file-change='onselect$name'";
                if ($value != "")
                    $currentValue = $value;

//                var_dump($data);
                if (is_array($data)) {

                    $options = array_keys($data)[2];

                    $currentValue = "{{ng$name.$options}}";
//                    echo $currentValue;
                    $otherOption = "ng-init='$name=ng$name.$options'";
                }else{
                    $otherOption = "ng-init='$name=ng$name'";
                    $currentValue = "{{ng$name}}";
                }

//                var_dump($currentValue);
                echo "<input $otherOption $onselect ng-model='$name' ng-change='ch$name(this)' $ro  title='$title' type='$type' class='form-control col-xs-8' id='$name' name='$name' value='" . $currentValue . "'> ";
                break;
            case "select":
//                echo "<pre>";
//                var_dump($data);
//                echo "</pre>";
                if (is_array($data[0])) {
                    $options = array_keys($data[0])[2];
                    $options1 = array_keys($data[0])[0];
                }
//                echo "<div ng-init='ng$name =".json_encode($data)."'></div>";
//                echo "<div ng-init='ng$name =".json_encode($data)."'></div>";
                if ($value !== false) {
                    $ngInit = "ng-init='$name=ng$name" . '[0]' . "'";
                }
                if (isset($this->params[$name . "_df"])) {
                    $ngInit = "ng-init='$name=ng" . $name . "_df'";
                }
//                var_dump($options1);

                $options_1 = ($options1 == "" ? "" : "ng-options='x.$options for x in ng$name track by x.$options1'");
                echo "<select ng-change='ch$name(this)' $ngInit $options_1  ng-model='$name' $ro class='form-control col-xs-8' id='$name' name='$name' title='$title'>";
//                echo "<select  ng-model='$name' $ro class='form-control col-xs-8' id='$name' name='$name' title='$title'>";
//                echo "<option ng-repeat='options in $name' value='{{options.$options1}}'>{{options.$options}}</option>";
                if ($value !== false) {
//                    echo "<option value=''></option>";    
                    echo '<option value="" style="display: none"></option>';
                } else {
                    echo '<option ng-selected="true" value="">---Select---</option>';
                }
//                foreach ($data as $key):
////                    var_dump($key);
////                    $extradata="";
//                    foreach($key as $kvalue=>$value){
////                        if(!is_numeric($kvalue))
////                        echo $kvalue."-".$value."\n";
//                    }
//                    
////                    echo "<option value='$key[0]' >" . $key[1] . "</option>";
//                endforeach;
                echo '</select>';
                break;
            case "checkbox":

                foreach ($data as $key):
                    echo "<input ng-change='ch$name(this)' ng-model='$name' $ro  title='$title' type='$type' class='form-control col-xs-8' id='$name' name='$name' value='$key[0]'>" . $key[1];
                endforeach;

                break;
            case "textarea":
                echo "<textarea ng-change='ch$name(this)' ng-model='$name' $ro class='form-control col-xs-8' title='$title' rows='5' id='$name' name='$name'></textarea>";

                break;
            default:
                break;
        }
        echo "</div>";
    }

}
