<?php defined('BASEPATH') OR exit('No direct script access allowed');

class My_Model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }


	function whereCuentas( $cuentaId, $column='cuentaId' )
	{
		if ( is_array($cuentaId) )
		{
			$where = "";

			foreach( $cuentaId as $cuentaIdParaWhere )
			{
				$where .= $column . ' = ' . $cuentaIdParaWhere . " OR ";
			}
			
			$where = substr( $where, 0, -4 );
			
			$this->db->where("(" . $where . ")");
		}
		else
		{
			$this->db->where('$column = ' . $cuentaId );
		}
	}
}