<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Paket extends User_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'pt';
	private $current_page = 'pt/paket/';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('services/Paket_services');
		$this->services = new Paket_services;

		$this->load->library('services/Draft_tender_services');
		$this->draft_tender_services = new Draft_tender_services;

		$this->load->library('services/Tender_services');
		$this->tender_services = new Tender_services;

		$this->load->model(array(
			'paket_model',
			'pokmil_model',
			'draft_tender_model',
			'tender_model',
		));
	}	

	public function index(  )
	{
		// 
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		//pagination parameter
		$pagination['base_url'] = site_url( $this->current_page ) .'/index';
		$pagination['total_records'] = $this->paket_model->record_count() ;
		$pagination['limit_per_page'] = 10;
		$pagination['start_record'] = $page*$pagination['limit_per_page'];
		$pagination['uri_segment'] = 4;
		//set pagination
		if ($pagination['total_records']>0) $this->data['pagination_links'] = $this->setPagination($pagination);

		$table = $this->services->get_table_config( $this->current_page );
		$table[ "rows" ] = $this->paket_model
		->select('	paket.*, 
					concat(users.first_name, " ", users.last_name) as pa_full_name,
					pokmil.name as pokmil_name
					')
		->join(
			"users",
			"users.id = paket.pa_id",
			"inner")
		->join(
			"pokmil",
			"pokmil.id = paket.pokmil_id",
			"inner")
		->pakets( $pagination['start_record'], $pagination['limit_per_page'] )->result();
		unset( $table[ "action" ][2] );
		unset( $table[ "action" ][1] );
		$table = $this->load->view('templates/tables/plain_table', $table, true);
		$this->data[ "contents" ] = $table;

		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Paket";
		$this->data["header"] = "Paket";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}

	public function detail( $paket_id = null )
    {
		if ($paket_id == NULL) redirect(site_url($this->current_page));
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->paket_model->errors() ? $this->paket_model->errors() : $this->session->flashdata('message')));
		if(  !empty( validation_errors() ) || $this->paket_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Detail Paket ";
		$this->data["header"] = "Detail Paket ";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

		$form_data = $this->services->get_form_data( $paket_id );
		$form_data = $this->load->view('pt/paket/detail/plain_form_readonly', $form_data , TRUE ) ;
		$this->data[ "contents" ] =  $form_data;

		$paket = $this->paket_model->paket( $paket_id )->row();
		
		$form_data_draft_tender = $this->draft_tender_services->get_form_data( $paket->draft_tender_id );
		unset($form_data_draft_tender['form_data']['name']);
		unset($form_data_draft_tender['form_data']['status']);
		$form_data_draft_tender = $this->load->view('pt/paket/detail/plain_form_readonly', $form_data_draft_tender , TRUE ) ;
		$this->data[ "contents_2" ] =  $form_data_draft_tender;

		$draft_tender = $this->draft_tender_model->draft_tender( $paket->draft_tender_id )->row();
		$form_data_tender = $this->tender_services->get_form_data( $draft_tender->tender_id );
		$form_data_tender = $this->load->view('pt/paket/detail/plain_form_readonly', $form_data_tender , TRUE ) ;
		$this->data[ "contents_2" ] =  $form_data_tender.$this->data[ "contents_2" ] ;

		$tender = $this->tender_model->tender( $draft_tender->tender_id )->row();

		$publish_tender = array(
			"name" => "Terbitkan Tender",
			"modal_id" => "create_draft_",
			"button_color" => "success",
			"url" => site_url( "pt/tender/edit/".$draft_tender->tender_id ),
			"form_data" => array(
				"paket_id" => array(
					'type' => 'hidden',
					'label' => "tender_id",
					'value' => $paket->id,
				),
				"name" => array(
					'type' => 'text',
					'label' => "Nama Tender",
					'readonly' => true,
					'value' => $draft_tender->name,
				),
				"status" => array(
					'type' => 'hidden',
					'label' => "status",
					'value' => 'Tayang',
				),
			),
			'data' => NULL
		);

		$publish_tender= $this->load->view('templates/actions/modal_form', $publish_tender, true ); 
		if($tender->status != 'Tayang')
			$this->data[ "header_button" ] =  $publish_tender;

		$this->render( "pt/paket/detail/content" );
	}	
}
