<?php
class filtros_model extends MY_Model {
	
	private $filter_rubros = "filter_rubros";
	
	public function setAllRubros( $set=true, $personaObj=false )
	{
		$rubroModel	= new rubro_model();
		
		$filtrosRubros	= array();
		$personaId		= false;
		
		if ( $personaObj )
		{
			$personaId = $personaObj->id;
			
			$filtrosRubros = $this->session->userdata( $this->filter_rubros );
		}
		

		$getRubros		= $rubroModel->getRubros( $personaId );

		
		foreach( $getRubros as $rubroObj )
		{
			$filtrosRubros[$rubroObj->id] = $set;
		}
		
		//print_r($filtrosRubros);
		
		return $this->session->set_userdata( "filter_rubros", $filtrosRubros );
	}

	public function setAllPersonas()
	{
		$rubroModel	= new rubro_model();
		
		$personasArray	= $rubroModel->getPersona();
		
		foreach ( $personasArray as $personaObj )
		{
			$this->session->set_userdata( 'filter_' . $personaObj->unique_name, false);
		}

		// Sin Rubrar		
		$this->session->set_userdata( 'filter_sinrubrar', false);

		
		// Por defecto prendo todos los rubros también.
		$this->setAllRubros();


		return true;
	}
}