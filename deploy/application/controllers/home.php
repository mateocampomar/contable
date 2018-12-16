<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index()
	{
		$this->load->view('templates/html_open',	$this->data);
		$this->load->view('templates/html_close',	$this->data);
	}
}