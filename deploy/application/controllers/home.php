<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index()
	{
		$this->load->view('templates/html_open',	$this->data);
		$this->load->view('templates/html_close',	$this->data);
		
		print_r( $this->session->userdata( "filter_rubros" ) );
	}
	
	public function login()
	{
		$filtrosModel	= new filtros_model();
		
		$filtrosModel->setAllPersonas();
		
		redirect('/home/index/', 'location');
	}
}
