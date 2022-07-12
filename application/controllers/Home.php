<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {

    private $parent_page = '';
	private $current_page = '/tender/';
	function __construct()
	{
		parent::__construct();

		$this->load->library('services/Tender_services');
		$this->tender_services = new Tender_services;
		$this->load->model(array(
			'tender_model',
		));
	}
	public function index()
	{
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		//pagination parameter
		$pagination['base_url'] = site_url( $this->current_page ) .'/index';
		$pagination['total_records'] = $this->tender_model->record_count() ;
		$pagination['limit_per_page'] = 10;
		$pagination['start_record'] = $page*$pagination['limit_per_page'];
		$pagination['uri_segment'] = 4;
		//set pagination
		if ($pagination['total_records']>0) $this->data['pagination_links'] = $this->setPagination($pagination);

		$table = $this->tender_services->get_table_config( $this->current_page );
		$table['header'] = array(
			'name' => 'Nama',
			'budget' => 'Anggaran',
			'end_date' => 'Akhir Pendaftaran',
		);
		unset($table['action']);
		$table[ "rows" ] = $this->tender_model
		->where('status', 'Tayang')
		->tenders( $pagination['start_record'], $pagination['limit_per_page'] )->result();
		for ($i=0; $i < count($table[ "rows" ]); $i++) { 
			$table[ "rows" ][$i]->year = $table[ "rows" ][$i]->year." ";
		}
		$table = $this->load->view('public/plain_table_12', $table, true);
		$this->data[ "contents" ] = $table;

		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Rencana Tender";
		$this->data["header"] = "Tender";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render("public/home");
	}
}