<?php
class parser_model extends MY_Model {
	
	public function itauWeb( $cuentaId, $inputTxt )
	{
		$cuentaModel	= new Cuenta_model();
		
		$fisrtRow	= true;
		$return		= array();


		$rowsArray = explode("\n", $inputTxt);
		
		//print_r( $rowsArray );
		foreach($rowsArray as $row ) 
		{
			$columnArray = explode("	", $row );
			
			//Validación
			if (count($columnArray) != 5 )	return false;
			
			list($dia, $mes, $ano)	= explode("-", $columnArray[0]);
			
			$fecha 		= "20" . $ano . "-" . $mes . "-" . $dia;
			$concepto	= $columnArray[1];
			$debito		= str_replace(",", ".", str_replace(".", "", $columnArray[2] ));
			$credito	= str_replace(",", ".", str_replace(".", "", $columnArray[3] ));
			$saldo		= str_replace(",", ".", str_replace(".", "", $columnArray[4] ));
			
			// Validación del saldo para saber si es efectivamente el próximo movimiento.
			$cuentaObj = $cuentaModel->getCuenta( $cuentaId );
			
			//echo round($saldo, 2) . " != " . round( $cuentaObj->saldo + $credito - $debito, 2 ) . "/";
			
			if ( $fisrtRow )
			{
				if ( round($saldo, 2) != round( $cuentaObj->saldo + $credito - $debito, 2 ) )
				{
					$return['error'] = "Hay diferencia de saldo.";
					return $return;
				}
				
				$fisrtRow = false;
			}

			$return[] = array(
							'fecha'		=> $fecha,
							'concepto'	=> $concepto,
							'debito'	=> $debito,
							'credito'	=> $credito,
							'saldo'		=> $saldo,
					);
		}
		
		return $return;
	}
}