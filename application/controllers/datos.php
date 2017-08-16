<?php
/**
* 
*/
class Datos extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function getdatos(){
		$resultado = $this->db->get('entries');
		echo json_encode($resultado->result());
	}
}