<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Draft_tender extends User_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'pa';
	private $current_page = 'pa/draft_tender/';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('services/Draft_tender_services');
		$this->services = new Draft_tender_services;

		$this->load->library('services/Paket_services');
		$this->paket_services = new Paket_services;

		$this->load->model(array(
			'draft_tender_model',
			'pokmil_model',
			'paket_model',
		));
	}	

	public function index(  )
	{

		// 
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		//pagination parameter
		$pagination['base_url'] = site_url( $this->current_page ) .'/index';
		$pagination['total_records'] = $this->draft_tender_model->record_count() ;
		$pagination['limit_per_page'] = 10;
		$pagination['start_record'] = $page*$pagination['limit_per_page'];
		$pagination['uri_segment'] = 4;
		//set pagination
		if ($pagination['total_records']>0) $this->data['pagination_links'] = $this->setPagination($pagination);

		$table = $this->services->get_table_config( $this->current_page );
		$user_id = $this->ion_auth->get_user_id();

		$table[ "rows" ] = $this->draft_tender_model
		->where('pa_id',$user_id )
		->draft_tenders( $pagination['start_record'], $pagination['limit_per_page'] )->result();

		$users = $this->ion_auth->users_limit( 1000, 0, 'pa' )->result();
		$user_select = array();
		foreach( $users as $user )
		{
			$user_select[ $user->id ] = $user->first_name." ".$user->last_name;
		}
		for ($i=0; $i < count($table[ "rows" ]) ; $i++) { 
			$table[ "rows" ][$i]->pa_name = $user_select[ $table[ "rows" ][$i]->pa_id ];
		}
		foreach( $table[ "rows" ] as $row )
		{
			$row->id_enc = base64_encode($row->id);
		}
		unset( $table[ "action" ][2] );
		unset( $table[ "action" ][1] );
		$table = $this->load->view('templates/tables/plain_table', $table, true);
		$this->data[ "contents" ] = $table;

		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Usul Draft Tender";
		$this->data["header"] = "Usul Draft Tender";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}

	public function detail( $draft_tender_id = null )
    {
		$draft_tender_id = base64_decode($draft_tender_id);
		$draft_tender = $this->draft_tender_model->draft_tender( $draft_tender_id )->row();
		if( ! $draft_tender ) 
			redirect( site_url($this->current_page)  );
		if ($draft_tender_id == NULL) redirect(site_url($this->current_page));
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->draft_tender_model->errors() ? $this->draft_tender_model->errors() : $this->session->flashdata('message')));
		if(  !empty( validation_errors() ) || $this->draft_tender_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Detail Usul Draft Tender ";
		$this->data["header"] = "Detail Usul Draft Tender ";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

		$form_data = $this->services->get_form_data( $draft_tender_id );
		$form_data = $this->load->view('pa/draft_tender/detail/plain_form_readonly', $form_data , TRUE ) ;

		$user_id = $this->ion_auth->get_user_id();
		$form_data_paket = $this->paket_services->get_form_data()['form_data'];
		$form_data_paket['draft_tender_id']['value'] = $draft_tender_id;
		$form_data_paket['pa_id']['value'] = $user_id;
		$form_data_paket['name']['value'] = $this->services->get_form_data( $draft_tender_id )['form_data']['name']['value'];
		$form_data_paket['status']['type'] = 'hidden';
		$create_paket = array(
			"name" => "Buat Paket",
			"modal_id" => "create_draft_",
			"button_color" => "success",
			"url" => site_url( "pa/paket/add/"),
			"form_data" => $form_data_paket,
			'data' => NULL
		);

		$create_paket= $this->load->view('templates/actions/modal_form', $create_paket, true ); 

		$paket = $this->paket_model
			->where('draft_tender_id', $draft_tender_id)
			->paket()
			->row();

		if( !$paket )
			$this->data[ "header_button" ] =  $create_paket;

		$this->data[ "contents" ] =  $form_data;
		$this->render( "pa/draft_tender/detail/content" );
	}
}
