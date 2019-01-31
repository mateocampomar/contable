<?php defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->data				= array();
        $saldoSinRubrarArray	= array();
		$menuCuentas			= array();
		
		$cuentaModel	= new Cuenta_model();
		$rubroModel		= new Rubro_model();
		

		$listCuentas = $cuentaModel->listCuentas();
		foreach ( $listCuentas as $cuentaObj )
		{
			$saldoSinRubrarArray[$cuentaObj->id] = $rubroModel->getTotalSinRubrar( $cuentaObj->id );
			
			if ( !isset( $menuCuentas[$cuentaObj->moneda] ) )
			{
				$menuCuentas[$cuentaObj->moneda]				= array();
				$menuCuentas[$cuentaObj->moneda]['saldoTotal']	= 0;
			}
			
			$menuCuentas[$cuentaObj->moneda][]	= $cuentaObj;
			
			$menuCuentas[$cuentaObj->moneda]['saldoTotal']	+= $cuentaObj->saldo;
		}
		
		$this->data['menuCuentas']			= $menuCuentas;
		$this->data['saldoSinRubrarArray']	= $saldoSinRubrarArray;
		$this->data['listCuentas']			= $listCuentas;
    }
}