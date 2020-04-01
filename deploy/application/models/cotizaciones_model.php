<?php
class cotizaciones_model extends MY_Model {
	
	private $tabla = "cotizaciones";
	
	public function nueva($cotizacion)
	{
		$data = array(
			'fecha'		=> date('Y-m-d'),
			'USD'		=> $cotizacion,
		);

		if ( $this->db->insert($this->tabla, $data) )
		{
			$insertId = $this->db->insert_id();

			return $insertId;
		}

		return false;
	}
	
	public function hoy()
	{
		$this->db->select('*');
	
		$this->db->from( $this->tabla );
		
		$this->db->order_by( $this->tabla . '.fecha', 'DESC');
		
		$this->db->limit(1);

		$query = $this->db->get();
		
		$result = $query->result();
		
		return $result[0];
	}
	
	public function getByFecha( $fecha )
	{
		$this->db->select('*');
	
		$this->db->from( $this->tabla );
		
		$this->db->where( $this->tabla . ".fecha <= '" . $fecha . "'" );
		
		$this->db->limit(1);

		$query = $this->db->get();
		
		//echo $this->db->last_query() . ";\n";
		
		$result = $query->result();
		

		return $result[0];
	}
}