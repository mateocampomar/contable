<?

function formatNumberCustom( $number )
{
	
	if ( $number == '0.00' )	$output	= '';
	else
	{
		$output = number_format($number, 2, ',', '.');
	}
	
	return $output;
}

function fecha_format_SqltoPrint( $fecha )
{
	$fechaExp = explode('-', $fecha);
	
	return $fechaExp[2] . '-' . $fechaExp[1] . '-' . $fechaExp[0];
}