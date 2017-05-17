<?php

abstract class Controller {

    protected $view;

    abstract public function index();

    public function __construct() {
//        var_dump($_POST);
        foreach ($_POST as $key => $value) {
            $sanitize = FILTER_SANITIZE_SPECIAL_CHARS;
            $options = "";
            switch (true) {
                case stristr($key, 'email'):
                    $sanitize = FILTER_SANITIZE_EMAIL;
                    break;
                case stristr($key, 'nf'):
                    $sanitize = FILTER_SANITIZE_NUMBER_FLOAT;
                    $options = FILTER_FLAG_ALLOW_FRACTION;
                    break;
                case stristr($key, 'ni'):
                    $sanitize = FILTER_SANITIZE_NUMBER_INT;
                    break;

                default:
                    break;
            }
            if (is_array($value)) {
//                foreach ($value as $key2 => $value2) {
//                    if ($options != "") {

                $_POST[POSTSUFIX . $key] = filter_input(INPUT_POST, $key, $sanitize, array(FILTER_REQUIRE_ARRAY, $options));
//                    } else {
                $_POST[POSTSUFIX . $key] = filter_input(INPUT_POST, $key, $sanitize, FILTER_REQUIRE_ARRAY);
//                    }
//                }
            } else {
                if ($options != "") {
                    $_POST[POSTSUFIX . $key] = filter_input(INPUT_POST, $key, $sanitize, $options);
                } else {
                    $_POST[POSTSUFIX . $key] = filter_input(INPUT_POST, $key, $sanitize);
                }
            }
            unset($_POST[$key]);
        }
        session_start();
        $this->view = new View(Singleton::getInstance()->r->getController());
        $menu = array();
        if ($this->sesionIniciada()) {
            switch ($this->getRol()) {
                case ROL_ADMINISTRADOR:
                    break;

                default:
                    break;
            }
            $this->crearMenu($menu, "administrador/usuarios", 'Usuarios');
            $this->crearMenu($menu, "administrador/tipoDescuentos", 'Tipos de descuento');
            $this->crearMenu($menu, "empresa/", 'Empresas');
            $this->crearMenu($menu, "catalogo/productos", 'Productos');
            $this->crearMenu($menu, "venta/cotizaciones", 'Cotizaciones');
            $this->crearMenu($menu, "utilities/logout", 'Cerrar sesión ');
        } else {


            $this->crearMenu($menu, "index/iniciar", 'Iniciar sesión');
        }
//        Singleton::getInstance()->db->
        $this->view->setMenu($menu);
    }

    public function loadModel($model) {

        $model = $model . 'Model';
        if (is_readable($controllerPath = ROOT . 'models' . DS . $model . '.php')) {
            include_once $controllerPath = ROOT . 'models' . DS . $model . '.php';
            return new $model;
        }
    }

    public function sesionIniciada() {
        return isset($_SESSION['session']);
    }

    public function getSesionVar($name) {
        return $_SESSION[$name];
    }

    public function cerrarSesion() {
        session_destroy();
    }

    public function getRol() {
        return $_SESSION["idRol"];
    }

    public function crearMenu(&$menu, $url, $descripcion) {
        $menu[] = array('url' => BASE . $url,
            'descripcion' => $descripcion);
    }

    public function showConstructMsg() {
        die("En construcción");
    }

    public function redirigirARol() {
        switch ($this->getSesionVar("ID_ROL")) {
            case ROL_ADMINISTRADOR:
                header("Location:" . BASE . DS . 'administrador' . DS);
                break;
            case ROL_CLIENTE:
                header("Location:" . BASE . DS . 'cliente' . DS);
                break;
            case ROL_REPARTIDOR:
                header("Location:" . BASE . DS . 'repartidor' . DS);
                break;

            default:
                header("Location:" . BASE . DS . 'index' . DS);

                break;
        }
    }

    public function validar($data) {
        include ROOT . 'config' . DS . 'Validador.php';
        $validador = new Validador();
        $validador->setCampos($data);
        return $validador;
    }

    public function exportExcel($data, $title, $filename) {
        /**
         * Funci�n para exportar a excel a partir de un excel
         * @param array $data <b>Arreglo con la informaci�n que va a ir en el excel
         * </b>
         */
        $hoy = new DateTime();
        ob_clean();
        include ROOT . 'config' . DS . 'Classes' . DS . 'PHPExcel.php';
        header('Content-Disposition: attachment; filename="' . $filename . ($hoy->getTimestamp()) . '.xls"');
        header('Content-Type: application/vnd.ms-excel');
        $objPHPExcel = new PHPExcel;
        $objPHPExcel = new PHPExcel();
        $worksheet = $objPHPExcel->getActiveSheet();
        $worksheet->setCellValueByColumnAndRow(0, 1, "Hola ");
        $worksheet->setCellValueByColumnAndRow(0, 1, "$title: ");
        $worksheet->getStyle("A1")->getFont()->setBold(true)->setSize(16);
        foreach (range('A', "Z") as $col) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow();
        $row = 3; //Column names
        foreach ($data as $key => $value) {
            $columnHeader = 0;
            foreach ($value as $key2 => $value2) {
                $worksheet->setCellValueByColumnAndRow($columnHeader, $row, $key2);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnHeader, $row)->getFont()->setBold(true);
                $columnHeader++;
            }
        }
        $row = 4; //Data
        foreach ($data as $key => $value) {
            $column = 0;
            foreach ($value as $key2 => $value2) {
                $worksheet->setCellValueByColumnAndRow($column, $row, $value2);
                $column++;
            }
            $row++;
        }
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function redirigir($url) {
        echo "<script>window.location.href='$url'</script>";
    }

}
