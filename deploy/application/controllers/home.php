<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index()
	{
		$this->load->view('templates/html_open',	$this->data);
		$this->load->view('templates/html_close',	$this->data);
	}
	
	public function login()
	{
		$filtrosModel	= new filtros_model();
		
		$filtrosModel->setAllPersonas();
		
		//$this->session->set_userdata($personaName, true);
		
		redirect('/home/index/', 'location');
	}
}
