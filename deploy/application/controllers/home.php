<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index()
	{
		if ( $this->input->post('email') == 'mateoc@gmail.com' && $this->input->post('password') == 'hHTL2514' )
		{
			$this->login();
			redirect('/cuentas/ver/1', 'location');
		}
		else
		{
			$this->data['email']	=	$this->input->post('email');
			$this->data['password']	=	$this->input->post('password');
			
			$this->load->view('templates/html_open',	$this->data);
			$this->load->view('home',					$this->data);
			$this->load->view('templates/html_close',	$this->data);
		}
	}
	
	private function login()
	{
		$filtrosModel	= new filtros_model();
		
		$filtrosModel->setAllPersonas();
		
		$this->session->set_userdata( 'login_user', true );
	}
	
	public function logout()
	{
		$this->session->set_userdata( 'login_user', false );
		
		redirect('/home/index/', 'location');
		
		die;		
	}
}