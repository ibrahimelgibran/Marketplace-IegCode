<?php
/*
-- ---------------------------------------------------------------
-- MARKETPLACE MULTI BUYER MULTI SELLER + SUPPORT RESELLER SYSTEM
-- CREATED BY : IBRAHIM EL GIBRAN
-- COPYRIGHT  : Copyright (c) 2023 - 2024, IEGCODE. (https://iegcode.my.id/)
-- LICENSE    : http://opensource.org/licenses/MIT  MIT License
-- CREATED ON : 2023-04-17
-- UPDATED ON : 2024-04-17
-- ---------------------------------------------------------------
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Testimoni extends CI_Controller {
	public function index(){
		if (isset($_POST['submit'])){
			$this->model_reseller->insert_testimoni();
			echo $this->session->set_flashdata('message', '<div class="alert alert-success"><center>Sukses, Testimoni akan muncul setelah di setujui oleh admin.</center></div>');
			redirect('testimoni');
		}else{
			$jumlah= $this->model_reseller->hitung_testimoni()->num_rows();
			$config['base_url'] = base_url().'testimoni/index';
			$config['total_rows'] = $jumlah;
			$config['per_page'] = 6; 	
			if ($this->uri->segment('3')==''){
				$dari = 0;
			}else{
				$dari = $this->uri->segment('3');
			}
			if (is_numeric($dari)) {
				$data['record'] = $this->model_reseller->public_testimoni($config['per_page'], $dari);
			}else{
				redirect('testimoni');
			}
			$this->pagination->initialize($config);
			$data['title'] = 'Testimoni Konsumen';
			$data['description'] = description();
			$data['keywords'] = keywords();
			$this->template->load(template().'/template',template().'/reseller/view_testimoni',$data);
		}
	}
}
