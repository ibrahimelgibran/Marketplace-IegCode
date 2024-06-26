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
class Polling extends CI_Controller {
	public function index(){
		$data['title'] = 'Polling - Hasil Persentase Perhitungan';
		$data['description'] = description();
		$data['keywords'] = keywords();
		$data['rows'] = $this->model_utama->polling_sum()->row_array();
		$data['polling'] = $this->model_utama->view_where('poling', array('aktif'=>'Y', 'status'=>'Jawaban'));
		$this->template->load(template().'/template',template().'/polling_lihat',$data);
	}

	function hasil(){
		$data['title'] = 'Polling - Terima kasih atas partisipasi anda mengikuti polling kami';
		$data['description'] = description();
		$data['keywords'] = keywords();
		$data['rows'] = $this->model_utama->polling_sum()->row_array();
		$data['polling'] = $this->model_utama->view_where('poling', array('aktif'=>'Y', 'status'=>'Jawaban'));
		$r = $this->model_utama->view_where('poling', array('id_poling'=>$this->input->post('pilihan')))->row_array();
		if (get_cookie('poling')=='') {
			$dataa = array('rating'=>$r['rating']+1);
			$where = array('id_poling' => $r['id_poling']);
			$this->model_utama->update('poling', $dataa, $where);
		}
		$this->template->load(template().'/template',template().'/polling_hasil',$data);
	}
}
