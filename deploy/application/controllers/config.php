<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends MY_Controller {

	public function index()
	{
		$this->load->helper('form');


		$this->data['viewLeft_menu'] = $this->load->view('templates/html_menu',		$this->data, true);

		// Views
		$this->load->view('templates/html_open',		$this->data);
		$this->load->view('_config',					$this->data);
		$this->load->view('templates/html_close',		$this->data);
	}
	
	public function set_config_year()
	{
		$year			= $this->input->post('config_year');
		$redirectUrl	= $this->input->post('redirectUrl');

		$this->session->set_userdata('config_year', $year);
		
		redirect( $redirectUrl, 'location');
	}
}