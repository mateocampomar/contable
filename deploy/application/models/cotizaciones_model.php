<?php
class cotizaciones_model extends MY_Model {
	
	private $tabla = "cotizaciones";
	
	public function nueva($moneda, $cotizacion)
	{
		$data = array(
			'moneda'		=> $moneda,
			'cotizacion'	=> $cotizacion
		);

		if ( $this->db->insert($this->tabla, $data) )
		{
			$insertId = $this->db->insert_id();

			return $insertId;
		}

		return false;
	}
}