<?php
class parser_model extends MY_Model {
	
	public function itauWeb( $cuentaId, $inputTxt )
	{
		$cuentaModel	= new Cuenta_model();


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
			
			//echo $saldo . " != " . ( $cuentaObj->saldo + $credito - $debito) . "\n" ;
			
			//echo $saldo - $cuentaObj->saldo - $credito;
			
			if ( round($saldo, 2) != round( $cuentaObj->saldo + $credito - $debito, 2 ) )
			{
				//echo floatval($saldo) . " != " . floatval( $cuentaObj->saldo + $credito - $debito );
				
				$return['error'] = "Hay diferencia de saldo.";
				return $return;
			}

			// Ingresar Movimiento.
			if ( !$cuentaModel->ingresarMovimiento( $cuentaId, $fecha, $concepto, $credito, $debito, $saldo) )
			{
				$return['error'] = "No se pudo ingresar el movimiento en la db.";
				return $return;
			}
		}


		return true;
	}

}