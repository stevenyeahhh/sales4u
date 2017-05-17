<?php

class IndexController extends Controller {

    private $usuario;

    public function __construct() {
        parent::__construct();
        $this->usuario = $this->loadModel("Usuario");
    }

    public function index() {

        $this->view->renderize("index");
    }

    public function iniciar() {

        $validar = $this->validar(array_merge(array(
            'usuario' => array('required' => true),
            'clave' => array('required' => true),
        )));

        $this->view->setValidacion($validar->getCamposJSON());
        if ($_POST) {
            $validar->setValores($_POST);
            if ($validar->validarServidor()) {
                extract($_POST);
                if ($_POST) {
                    if ($post_session != "") {
                        if ($user = $this->usuario->inciarSesion($post_usuario, $post_clave)->fetch(PDO::FETCH_ASSOC)) {
                            $_SESSION["id_usuario"] = $user["id_usuario"];
                            $_SESSION["nombre"] = $user["nombre"];
                            $_SESSION["apellido"] = $user["apellido"];
                            $_SESSION["documento"] = $user["documento"];
                            $_SESSION["idRol"] = $user["rol_id_rol"];
                            $_SESSION["titulo"] = $user["titulo"];
                            $_SESSION["correo"] = $user["correo"];
                            $_SESSION["celular"] = $user["celular"];
                            $_SESSION["session"] = $post_session;
                            header("Location:" . BASE  . 'index' . DS);
                        }
                    }
                }
            }
        }
        var_dump($_SESSION);
        $this->view->renderize("iniciar");
    }

    public function map() {
        $this->view->renderize("map", false);
    }

}
