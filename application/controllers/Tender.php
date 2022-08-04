<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tender extends Public_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = '';
	private $current_page = '/';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('services/Tender_services');
		$this->services = new Tender_services;

		$this->load->library('services/Draft_tender_services');
		$this->draft_tender_services = new Draft_tender_services;

		$this->load->model(array(
			'tender_model',
			'draft_tender_model',
			'tender_penyedia_model',
		));
	}	

	public function detail( $tender_id = null )
    {
		$tender_id = base64_decode($tender_id);
		$tender = $this->tender_model
			->select('
				schedule.*,
				draft_tender.budget_estimation as budget_estimation,
				draft_tender.status as draft_tender_status,
				tender.*,
			')
			->join(
				'draft_tender',
				'draft_tender.tender_id = tender.id',
				'inner'
			)
			->join(
				'schedule',
				'schedule.tender_id = tender.id',
				'inner'
			)
			->tender( $tender_id )->row();
		if( ! $tender ) 
			redirect( site_url($this->current_page)  );
		if ($tender_id == NULL) redirect(site_url($this->current_page));
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->tender_model->errors() ? $this->tender_model->errors() : $this->session->flashdata('message')));
		if(  !empty( validation_errors() ) || $this->tender_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = " ";
		$this->data["header"] = "Informasi Paket ";
		$this->data["sub_header"] = 'Klik Tombol Aksi Untuk Ikut Tender';

		$form_data = $this->services->get_form_data( $tender_id );
		// unset($form_data['form_data']['budget']);
		$form_data['form_data']['budget']['label'] = 'Harga Perkiraan Sendiri (HPS)*';
		$form_data['form_data']['budget']['value'] = $tender->budget_estimation;
		$form_data['form_data']['start_date']['label'] = 'Tanggal Mulai Tender';
		$form_data['form_data']['start_date']['type'] = 'text';
		$form_data['form_data']['start_date']['value'] = $tender->announcement_start_date;
		$form_data['form_data']['end_date']['label'] = 'Tanggal Selesai Tender';
		$form_data['form_data']['end_date']['type'] = 'text';
		$form_data['form_data']['end_date']['value'] = $tender->signing_end_date;
		$form_data['form_data']['penyedia_count'] = array(
			'type' => 'text',
			'label' => "Jumlah Peserta",
			'value' => 0,
		);

		$link_register_tender = 
		array(
			"name" => "Ikut Tender",
			"type" => "link",
			"url" => site_url( "penyedia/tender/register/".$tender_id),
			"button_color" => "success",	
			"data" => NULL,
		);
		if( $tender->status == 'Tayang' )
			$this->data[ "header_button" ] =  $this->load->view('templates/actions/link', $link_register_tender, TRUE );

		$tender_penyedia_table["header"] = array(
			'name' => 'Nama',
		);
		$tender_penyedia_table["number"] = 1;
		$tender_penyedia_table["rows"] = $this->tender_penyedia_model
			->select('	tender_penyedia.*, 
					company.name,
				')
			->where('tender_id', $tender_id )
			->join(
				"users",
				"users.id = tender_penyedia.penyedia_id",
				"inner")
			->join(
				"company",
				"company.user_id = users.id",
				"inner")
			->tender_penyedias()
			->result();
			$form_data['form_data']['penyedia_count']['value'] = count( $tender_penyedia_table["rows"] );
		$tender_penyedia_table = $this->load->view('public/tender/detail/plain_table', $tender_penyedia_table, true);
		$form_data = $this->load->view('templates/form/plain_form_readonly', $form_data , TRUE ) ;
		$this->data[ "contents" ] =  $form_data;
		$this->data[ "contents_2" ] =  $tender_penyedia_table;
		$this->data[ "tender" ] =  $tender;
		$this->render( "public/tender/detail/content_tayang" );
	}

}
