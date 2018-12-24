<?php
class rubro_model extends MY_Model {
	
	public function getCuentas( $cuentaId=false )
	{
		$this->db->select('*, rubro_cuenta.nombre as nombre');
	
		$this->db->from('rubro_cuenta');
		
		$this->db->join('rubro_persona', 'rubro_cuenta.id = rubro_persona.id');
		
		// If
		$this->db->where('rubro_cuenta.status = ' . 1);

		if ( $cuentaId )
			$this->db->where('rubro_persona_id = ' . $cuentaId);

		// Order
		$this->db->order_by('rubro_cuenta.nombre', 'ASC');

		$query = $this->db->get();
		
		return $query->result();
	}

	public function getPersona()
	{
		$this->db->select('*');
	
		$this->db->from('rubro_persona');
		
		$this->db->where('status = ' . 1);
		
		$this->db->order_by('nombre', 'ASC');

		$query = $this->db->get();
		
		return $query->result();
	}
}