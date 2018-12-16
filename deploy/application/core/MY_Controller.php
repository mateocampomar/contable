<?php defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
		
		$cuentaModel	= new Cuenta_model();
		
		$this->data = array();
		$this->data['listCuentas'] = $cuentaModel->listCuentas();
    }
}