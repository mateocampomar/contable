<?php
class cotizaciones_model extends MY_Model {
	
	private		$tabla			= "cotizaciones";
	protected	$monedaReturn	= null;
	
	public function __construct( $monedaReturn=null )
	{
		if ( $monedaReturn )	$this->monedaReturn = $monedaReturn;
	}

	public function nueva($cotizacion)
	{
		$data = array(
			'fecha'		=> date('Y-m-d'),
			'USD'		=> $cotizacion,
			'UYU'		=> 1 / $cotizacion,
		);

		if ( $this->db->insert($this->tabla, $data) )
		{
			$insertId = $this->db->insert_id();

			return $insertId;
		}

		return false;
	}
	
	public function hoyArray()
	{
		$this->db->select('*');
	
		$this->db->from( $this->tabla );
		
		$this->db->order_by( $this->tabla . '.fecha', 'DESC');
		
		$this->db->limit(1);

		$query = $this->db->get();
		
		//echo $this->db->last_query() . ";\n";
		
		$result = $query->result();
		
		return $result[0];
	}
	
	public function hoy( $monedaReturn=null )
	{
		if ( $monedaReturn === null )	$monedaReturn = $this->monedaReturn;
		
		if ( $monedaReturn )
		{			
			return $this->hoyArray()->$monedaReturn;
		}
		
		echo "especifique una moneda para hoy()";
		die;
	}
	
	public function getByFecha( $fecha, $monedaReturn=null )
	{
		if ( $monedaReturn === null )	$monedaReturn = $this->monedaReturn;
		
		if ( $monedaReturn )
		{			
			return $this->getByFechaArray( $fecha )->$monedaReturn;
		}
		
		echo "especifique una moneda para hoy()";
		die;
	}
	
	public function getByFechaArray( $fecha )
	{
		$this->db->select('*');
	
		$this->db->from( $this->tabla );
		
		$this->db->where( $this->tabla . ".fecha <= '" . $fecha . "'" );
		
		$this->db->order_by( $this->tabla . '.fecha', 'DESC');
		
		$this->db->limit(1);

		$query = $this->db->get();
		
		//echo $this->db->last_query() . ";\n";
		
		$result = $query->result();

		return $result[0];
	}
	
	public function getMonedasDisponibles()
	{
		return	array('USD', 'UYU');
	}
	
	public function opositMoneda( $monedaReturn )
	{
		if ( $monedaReturn == 'USD' )	return 'UYU';
		else							return 'USD';
	}
}