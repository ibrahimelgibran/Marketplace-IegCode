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
class Main extends CI_Controller {
	public function index(){
		$data['title'] = title();
		$data['description'] = description();
		$data['keywords'] = keywords();
		$data['ik1'] = $this->model_app->view_where_ordering_limit('iklanatas',array('username'=>'default'),'id_iklanatas','ASC',0,1)->row_array();
		$data['ik2'] = $this->model_app->view_where_ordering_limit('iklanatas',array('username'=>'default'),'id_iklanatas','ASC',1,1)->row_array();
		$data['ik3'] = $this->model_app->view_where_ordering_limit('iklanatas',array('username'=>'default'),'id_iklanatas','ASC',2,1)->row_array();
		$data['ik4'] = $this->model_app->view_where_ordering_limit('iklanatas',array('username'=>'default'),'id_iklanatas','ASC',3,1)->row_array();
		$data['kategori'] = $this->db->query("SELECT * FROM (SELECT a.*,b.produk FROM (SELECT * FROM `rb_kategori_produk`) as a LEFT JOIN
										(SELECT id_kategori_produk, COUNT(*) produk FROM rb_produk GROUP BY id_kategori_produk HAVING COUNT(id_kategori_produk)) as b on a.id_kategori_produk=b.id_kategori_produk ORDER BY RAND()) as c WHERE produk>=6 ORDER BY c.id_kategori_produk DESC LIMIT 5");
		$this->template->load(template().'/template',template().'/content',$data);
	}
}
