<?php defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        // User Login Authentification
        if ( $this->router->fetch_class() != 'home' && $this->router->fetch_class() != '_api' && $this->session->userdata( 'login_user' ) != true )
        {
			redirect('/home/index/', 'refresh');
		}

		// Declare
	    $this->data				= array();
	    $saldoSinRubrarArray	= array();
		$menuCuentas			= array();
		
		$cuentaModel		= new Cuenta_model();
		$rubroModel			= new Rubro_model();
		$cotizacionesModel	= new Cotizaciones_model();
		
		$saldoTotalDolares = 0;
		
	
		// Manejo de Fechas
		$_config_year = ( $this->session->userdata('config_year') ) ? $this->session->userdata('config_year') : date('Y');
		define('_CONFIG_YEAR', $_config_year);

		if ( _CONFIG_YEAR == 2019 )		$_config_start_date		= '2019-11-01';
		else							$_config_start_date		= _CONFIG_YEAR . '-01-01';
		define('_CONFIG_START_DATE', $_config_start_date);

		$_config_end_date		= (_CONFIG_YEAR == date('Y', time() ) ) ? date('Y-m-d', time() ) : _CONFIG_YEAR . '-12-31';
		define('_CONFIG_END_DATE', $_config_end_date);
		
		define('_DOLAR_HOY', $cotizacionesModel->hoy('USD'));


		// Otros
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
			
			
			if ( $cuentaObj->moneda == 'USD' )		$saldoTotalDolares += $cuentaObj->saldo;
			else									$saldoTotalDolares += $cuentaObj->saldo / _DOLAR_HOY;
		}
		
		$this->data['saldoTotalDolares']	= $saldoTotalDolares;
		$this->data['menuCuentas']			= $menuCuentas;
		$this->data['saldoSinRubrarArray']	= $saldoSinRubrarArray;
		$this->data['listCuentas']			= $listCuentas;
    }
}