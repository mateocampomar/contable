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
			
			//print_r($columnArray);
			// Validación: if (count($columnArray) != 5 )	retrun false;
			
			list($dia, $mes, $ano)	= explode("-", $columnArray[0]);
			
			$fecha 		= "20" . $ano . "-" . $mes . "-" . $dia;
			$concepto	= $columnArray[1];
			$credito	= str_replace(",", ".", str_replace(".", "", $columnArray[2] ));
			$debito		= str_replace(",", ".", str_replace(".", "", $columnArray[3] ));
			$saldo		= str_replace(",", ".", str_replace(".", "", $columnArray[4] ));
			
			
			if ( !$cuentaModel->ingresarMovimiento( $cuentaId, $fecha, $concepto, $credito, $debito, $saldo) )
			{
				return false;
			}
		}


		return true;
	}

}