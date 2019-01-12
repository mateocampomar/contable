<?php defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->data				= array();
        $saldoSinRubrarArray	= array();
		
		$cuentaModel	= new Cuenta_model();
		$rubroModel		= new Rubro_model();
		

		$listCuentas = $cuentaModel->listCuentas();
		
		foreach ( $listCuentas as $cuentaObj )
		{
			$saldoSinRubrarArray[$cuentaObj->id] = $rubroModel->getTotalSinRubrar( $cuentaObj->id );
		}
		
		$this->data['saldoSinRubrarArray']	= $saldoSinRubrarArray;
		$this->data['listCuentas']			= $listCuentas;
    }
}