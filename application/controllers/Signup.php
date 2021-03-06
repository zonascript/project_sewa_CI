<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {
	/*
		Disini untuk yang signup menu.
	*/
	public function __construct()
	{
    // Call the CI_Model constructor
		parent::__construct();
		//$this->load->model('signup_model');
		//$this->load->model('profile_model');		
	}
	public function index()
	{
		$user = null;
		if ($this->session->userdata('user')) {
			$ses_user = $this->session->userdata('user');			
			$user = $this->profile_model->get_user($ses_user['id_user']);																

			if($user['admin'] === 0){
				redirect('dashboard-cus','refresh');
			}elseif ($user['admin'] === -9){
				redirect('dashboard','refresh');
			}else{
				redirect('dashboard-cus','refresh');
			}
		}

		if($this->session->userdata('data_signup')){
			$data = array(
				'title' => "Sewania - Sewa Peralatan Pesta Online",
				'content' => "front/signup", 
				'data' => $this->session->userdata('data_signup'),
				'msg_signup' => $this->session->userdata('msg_signup')
				);
		}else{
			$data = array(
				'title' => "Sewania - Sewa Peralatan Pesta Online",
				'content' => "front/signup",
				'user' => $user,
				);
		}
		
		$this->load->view('layout/wrapper', $data);
	}

	public function validation()
	{
		$first_name = $this->input->post("first_name", TRUE);
		$last_name = $this->input->post("last_name", TRUE);
		$acc_email = $this->input->post("acc_email", TRUE);
		$acc_pass = $this->input->post("acc_pass", TRUE);
		$acc_user = $this->input->post("acc_user", TRUE);
		$re_acc_pass = $this->input->post("re-acc_pass", TRUE);
		$term = $this->input->post("term", TRUE);
		$tlp = $this->input->post("acc_tlp",TRUE);

		// captcha google kang
		$captcha_answer = $this->input->post('g-recaptcha-response');
		$captcha_response = $this->recaptcha->verifyResponse($captcha_answer);

		if ($captcha_response['success']) {

			if($term === "on"){

				if (!empty($first_name)) {
					
					if (!empty($last_name)) {
						
						if(!empty($acc_user)){
							if ($this->signup_model->cek_username($acc_user)) {
								
								if(!empty($acc_email)){
									if ($this->signup_model->cek_email($acc_email)) {
										
										if (!empty($acc_pass)) {											
											if(!empty($re_acc_pass)){
												if ($acc_pass === $re_acc_pass) {

														if (!empty($tlp)) {
															$data_user = array(
																"first_name" => $first_name,
																"last_name" => $last_name,
																"email" => $acc_email,
																"no_telp" => $tlp,
																"username" => $acc_user,
																"password" => $this->encryption->encrypt($acc_pass),
																"joined" => date('Y-m-d H:i:s'),
																"admin" => 0,
																"avatar" => "assets/img/ava/1.png"
																);
															$this->session->set_userdata('uname', $acc_user);
															$this->session->set_userdata('password', $acc_pass);
															$this->signup_model->insert_user($data_user);
															// $this->session->set_userdata('msg_signup', array('msg' => 'Login Success.', 'status' => true));
															redirect('login','refresh');
														}else{
															$data = array(
																"first_name" => $first_name,
																"last_name" => $last_name,							
																"acc_user" => $acc_user,
																"acc_email" => $acc_email,
																"acc_pass" => $acc_pass,
																"re_acc_pass" => $re_acc_pass,
																"acc_tlp" => $tlp
																);
															$this->session->set_userdata('data_signup', $data);
															$this->session->set_userdata('msg_signup', array('msg' => 'Telephone masih kosong !.', 'status'=> false));
															redirect('signup','refresh');	
														}														
												}else{
													$data = array(
													"first_name" => $first_name,
													"last_name" => $last_name,							
													"acc_user" => $acc_user,
													"acc_email" => $acc_email,
													"acc_pass" => $acc_pass,
													"re_acc_pass" => $re_acc_pass
													);
												$this->session->set_userdata('data_signup', $data);
												$this->session->set_userdata('msg_signup', array('msg' => 'Password tidak cocok !.', 'status'=> false));
												redirect('signup','refresh');	
												}
											}else{
												$data = array(
												"first_name" => $first_name,
												"last_name" => $last_name,							
												"acc_user" => $acc_user,
												"acc_email" => $acc_email,
												"acc_pass" => $acc_pass,
												"re_acc_pass" => $re_acc_pass
												);
											$this->session->set_userdata('data_signup', $data);
											$this->session->set_userdata('msg_signup', array('msg' => 'Pastikan Anda Mengisi Re-Password !.', 'status'=> false));
											redirect('signup','refresh');
											}
										}else{
											$data = array(
											"first_name" => $first_name,
											"last_name" => $last_name,							
											"acc_user" => $acc_user,
											"acc_email" => $acc_email,
											"acc_pass" => $acc_pass,
											);
										$this->session->set_userdata('data_signup', $data);
										$this->session->set_userdata('msg_signup', array('msg' => 'Pastikan Anda Mengisi Password !.', 'status'=> false));
										redirect('signup','refresh');
										}
									}else{
										$data = array(
											"first_name" => $first_name,
											"last_name" => $last_name,							
											"acc_user" => $acc_user,
											"acc_email" => $acc_email,
											);
										$this->session->set_userdata('data_signup', $data);
										$this->session->set_userdata('msg_signup', array('msg' => 'Email Telah Terdaftar !.', 'status'=> false));
										redirect('signup','refresh');
									}
								}else{
									$data = array(
									"first_name" => $first_name,
									"last_name" => $last_name,							
									"acc_user" => $acc_user,
									"acc_email" => $acc_email,
									);
								$this->session->set_userdata('data_signup', $data);
								$this->session->set_userdata('msg_signup', array('msg' => 'Pastikan Anda Mengisi Email !.', 'status'=> false));
								redirect('signup','refresh');
								}

							}else{
								$data = array(
								"first_name" => $first_name,
								"last_name" => $last_name,							
								"acc_user" => $acc_user, 
								);
							$this->session->set_userdata('data_signup', $data);
							$this->session->set_userdata('msg_signup', array('msg' => 'Username Telah Terdaftar !.', 'status'=> false));
							redirect('signup','refresh');
							}						
						}else{
							$data = array(
							"first_name" => $first_name,
							"last_name" => $last_name,							
							"acc_user" => $acc_user, 
							);
						$this->session->set_userdata('data_signup', $data);
						$this->session->set_userdata('msg_signup', array('msg' => 'Pastikan Anda Mengisi Username !.', 'status'=> false));
						redirect('signup','refresh');
						}

					}else{
						$data = array(
							"first_name" => $first_name,
							"last_name" => $last_name,							
							);
						$this->session->set_userdata('data_signup', $data);
						$this->session->set_userdata('msg_signup', array('msg' => 'Pastikan Anda Mengisi Nama Belakang !.', 'status'=> false));
						redirect('signup','refresh');
					}

				}else{
					$data = array(
						"first_name" => $first_name,
						);
					$this->session->set_userdata('data_signup', $data);
					$this->session->set_userdata('msg_signup', array('msg' => 'Pastikan Anda Mengisi Nama Depan !.', 'status'=> false));
					redirect('signup','refresh');					
				}	

			}else{
				$data = array(
				"first_name" => $first_name,
				"last_name" => $last_name,
				"acc_email" => $acc_email,
				"acc_pass" => $acc_pass,
				"acc_user" => $acc_user, 
				"re_acc_pass" => $re_acc_pass,
				);
			$this->session->set_userdata('data_signup', $data);
			$this->session->set_userdata('msg_signup', array('msg' => 'Silakan menyetujui peraturan main.', 'status'=> false));
			redirect('signup','refresh');
			}

		}else{
			$data = array(
				"first_name" => $first_name,
				"last_name" => $last_name,
				"acc_email" => $acc_email,
				"acc_pass" => $acc_pass,
				"acc_user" => $acc_user, 
				"re_acc_pass" => $re_acc_pass,
				);
			$this->session->set_userdata('data_signup', $data);
			$this->session->set_userdata('msg_signup', array('msg' => 'Silakan menyetujui peraturan main.', 'status'=> false));
			redirect('signup','refresh');
		}
	}
}
