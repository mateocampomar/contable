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