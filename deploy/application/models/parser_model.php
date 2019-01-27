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
			if (count($columnArray) != 5 )
			{
				$return['error'] = "El número de columnas no es 5.";
				return $return;
			}
			
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
	
	public function acsaWeb ( $cuentaId, $inputTxt )
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
			if (count($columnArray) != 6 )
			{
				$return['error'] = "El número de columnas no es 6.";
				return $return;
			}
			
			list($dia, $mes, $ano)	= explode("-", $columnArray[0]);
			
			$fecha 		= $ano . "-" . $mes . "-" . $dia;
			$concepto	= $columnArray[2];
			$movimiento	= str_replace(",", ".", str_replace(".", "", $columnArray[4] ));
			if ( $movimiento > 0 ) {
				$credito	=$movimiento;
				$debito		= 0;
			} else  {
				$credito	=	0;
				$debito		= -$movimiento;
			}
			$saldo		= str_replace(",", ".", str_replace(".", "", $columnArray[5] ));
			
			// Validación del saldo para saber si es efectivamente el próximo movimiento.
			$cuentaObj = $cuentaModel->getCuenta( $cuentaId );
			
			//echo round($saldo, 2) . " != " . round( $cuentaObj->saldo + $credito - $debito, 2 ) . "/";
			
			if ( $fisrtRow )
			{
				if ( round($saldo, 2) != round( $cuentaObj->saldo + $credito - $debito, 2 ) )
				{
					$return['error'] = "Hay diferencia de saldo. Saldo: " . round($cuentaObj->saldo, 2) . " Nuevo: " . round( $saldo - $credito + $debito, 2 ) . " (D:" . $debito . " / C:" . $credito . ")";
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

	public function visaIatu ( $cuentaId, $inputTxt )
	{
		$cuentaModel	= new Cuenta_model();
		$cuentaObj = $cuentaModel->getCuenta( $cuentaId );

		$return		= array();

		$rowsArray = explode("\n", $inputTxt);


		list($cta1, $cta2)	= explode(",", $cuentaObj->parser_asoc );


		foreach($rowsArray as $row ) 
		{
			$columnArray = explode("	", $row );

			
			//Validación
			// [todo] Esto anda mal.

			//if ( count($columnArray) == 6 || count($columnArray) == 7 )
			//{
			//	$return['error'] = "Deben de ser 6 o 7 columnas.";
			//	return $return;
			//}

			list($dia, $mes, $ano)	= explode("/", $columnArray[3]);
			$fecha 		= "20" . $ano . "-" . $mes . "-" . $dia;
			
			$concepto	= $columnArray[1];

			$movimiento	= str_replace(",", ".", str_replace(".", "", $columnArray[5] ));
			if ( $movimiento < 0 ) {
				$credito	= -$movimiento;
				$debito		= 0;
			} else  {
				$credito	=	0;
				$debito		= $movimiento;
			}
			
			$txt_otros	= $columnArray[0];
			
			$cuentaId = ( $columnArray[4] == 'Pesos' )	? $cta1 : $cta2;


			/*
				[todo] Validación de la fecha de los movimientos.
			*/

			$return[] = array(
							'fecha'		=> $fecha,
							'concepto'	=> $concepto,
							'debito'	=> $debito,
							'credito'	=> $credito,
							'saldo'		=> null,
							'txt_otros'	=> $txt_otros,
							'cuenta_id'	=> $cuentaId
					);
		}

		return $return;
	}
}