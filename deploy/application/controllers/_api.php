<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _api extends MY_Controller {

	public function dolarHoy()
	{
		//echo $this->GetBCUUltimoCierre();
		
		$cotizacionesModel		= new Cotizaciones_model();
		$dolar					= $this->GetCotizacion($this->GetBCUUltimoCierre(), 2225, 0);

		if ( $cotizacionesModel->nueva( $dolar ) )
		{
			echo 'ok';
			die;
		}
		
		echo "error";
	}
	
	function GetBCUUltimoCierre(){

        $opts = array(
            'ssl'   => array(
                'verify_peer'          => false,
                'allow_self-signed' => true,
                'ciphers' => "SHA1"
            )
        );
        $streamContext = stream_context_create($opts);

        $params = array(
            //'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
            'stream_context'     => $streamContext,
            'cache_wsdl' => NULL,
        );

        //WebService
        try{
            $clienteSOAP = new SoapClient('https://cotizaciones.bcu.gub.uy/wscotizaciones/servlet/awsultimocierre?WSDL',$params);
            $consulta    = $clienteSOAP->Execute();

            return $consulta->Salida->Fecha;
        }
        catch(SoapFault $e){
            var_dump($e);
        }

    }	

	private function GetCotizacion($fecha,$moneda,$grupo)
	{	
		$opts = array(
			'ssl'   => array(
				'verify_peer'			=> false,
				'allow_self-signed' 	=> true,
				'ciphers' => "SHA1"
			)
		);
	
		$streamContext = stream_context_create($opts);
		
		$params = array(
			//'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
			'stream_context'	=> $streamContext,
			'cache_wsdl'		=> NULL,
		);
		
		//Datos de envio
		$envio = array(
			'Entrada'=> array(
				'Moneda'  => array('item'=> $moneda)
				,'FechaDesde' => $fecha
				,'FechaHasta' => $fecha
				,'Grupo'      => $grupo
			)
		);
		
		//WebService
		try
		{
			$clienteSOAP = new SoapClient('https://cotizaciones.bcu.gub.uy/wscotizaciones/servlet/awsbcucotizaciones?WSDL',$params);
			$consulta    = $clienteSOAP->Execute($envio);
			$consulta    = (array) $consulta->Salida->datoscotizaciones;
			
			return $consulta['datoscotizaciones.dato']->TCC;
		}
		catch(SoapFault $e)
		{
			var_dump($e);
		}
	}
}