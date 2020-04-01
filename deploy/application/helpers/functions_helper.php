<?

function formatNumberCustom( $number, $decimales=2 )
{
	
	if ( $number == '0.00' )	$output	= '';
	else
	{
		$output = number_format($number, $decimales, ',', '.');
	}
	
	return $output;
}

function fecha_format_SqltoPrint( $fecha )
{
	$fechaExp = explode('-', $fecha);
	
	return $fechaExp[2] . '-' . $fechaExp[1] . '-' . $fechaExp[0];
}