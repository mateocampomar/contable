<?

function formatNumberCustom( $number, $decimales=2, $mostrarCeros=false )
{
	
	if ( $number == '0.00' && $mostrarCeros==false )	return '';


	$output = number_format($number, $decimales, ',', '.');
	
	return $output;
}

function fecha_format_SqltoPrint( $fecha )
{
	$fechaExp = explode('-', $fecha);
	
	return $fechaExp[2] . '/' . $fechaExp[1] . '/' . $fechaExp[0];
}