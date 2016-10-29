<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carts extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('profile_model');
		$this->load->model('carts_model');
	}

	public function index()
	{
		$user = null;
		if ($this->session->userdata('user')) {
			$ses_user = $this->session->userdata('user');			
			$user = $this->profile_model->get_user($ses_user['id_user']);																
		}

		$data = array(
			'title' => "Sewania - Sewa Peralatan Pesta Online",
			'content' => "front/cart", 
			'user' => $user,			
			);
					
		$this->load->view('layout/wrapper', $data);
	}

	public function delete($rowid){
		$this->cartsewania->remove($rowid);
		redirect('carts','refresh');
	}

	public function update(){
		redirect('carts','refresh');
	}

}

/* End of file Cart.php */
/* Location: ./application/controllers/Cart.php */ ?>