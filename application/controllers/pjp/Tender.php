<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tender extends User_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'pjp';
	private $current_page = 'pjp/tender/';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('services/Tender_services');
		$this->services = new Tender_services;

		$this->load->library('services/Draft_tender_services');
		$this->draft_tender_services = new Draft_tender_services;

		$this->load->model(array(
			'tender_model',
			'draft_tender_model',
		));
	}	

	public function index(  )
	{
		// 
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		//pagination parameter
		$pagination['base_url'] = base_url( $this->current_page ) .'/index';
		$pagination['total_records'] = $this->tender_model->record_count() ;
		$pagination['limit_per_page'] = 10;
		$pagination['start_record'] = $page*$pagination['limit_per_page'];
		$pagination['uri_segment'] = 4;
		//set pagination
		if ($pagination['total_records']>0) $this->data['pagination_links'] = $this->setPagination($pagination);

		$table = $this->services->get_table_config( $this->current_page );
		$table[ "rows" ] = $this->tender_model->tenders( $pagination['start_record'], $pagination['limit_per_page'] )->result();
		for ($i=0; $i < count($table[ "rows" ]); $i++) { 
			$table[ "rows" ][$i]->year = $table[ "rows" ][$i]->year." ";
		}
		$table = $this->load->view('templates/tables/plain_table', $table, true);
		$this->data[ "contents" ] = $table;

		$link_add = 
		array(
			"name" => "Tambah",
			"type" => "link",
			"url" => site_url( $this->current_page."add/"),
			"button_color" => "primary",	
			"data" => NULL,
		);
		$this->data[ "header_button" ] =  $this->load->view('templates/actions/link', $link_add, TRUE ); ;
		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Rencana Tender";
		$this->data["header"] = "Rencana Tender";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}

	public function add()
    {
		$this->form_validation->set_rules( $this->services->validation_config() );

		if ( $this->form_validation->run() === TRUE )
        {
			$data['code'] = $this->input->post( 'code' );
			$data['name'] = $this->input->post( 'name' );
			$data['type'] = $this->input->post( 'type' );
			$data['budget'] = $this->input->post( 'budget' );
			$data['budget_source'] = $this->input->post( 'budget_source' );
			$data['year'] = $this->input->post( 'year' );
			$data['location'] = $this->input->post( 'location' );
			$data['method'] = $this->input->post( 'method' );
			$data['start_date'] = $this->input->post( 'start_date' );
			$data['end_date'] = $this->input->post( 'end_date' );
			$data['status'] = $this->input->post( 'status' );
			
			if( $this->tender_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tender_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tender_model->errors() ) );
			}
			redirect( site_url($this->current_page));
		}
        else
        {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->tender_model->errors() ? $this->tender_model->errors() : $this->session->flashdata('message')));
            if(  !empty( validation_errors() ) || $this->tender_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

			$alert = $this->session->flashdata('alert');
			$this->session->set_flashdata('alert', NULL);

			$this->data["key"] = $this->input->get('key', FALSE);
			$this->data["alert"] = (isset($alert)) ? $alert : NULL ;

			// $this->data["alert"] .= ($this->upload->display_errors()) ? $this->alert->set_alert(Alert::DANGER, $this->upload->display_errors()) : NULL;

			$this->data["current_page"] = $this->current_page;
			$this->data["block_header"] = "Tambah Rencana Tender ";
			$this->data["header"] = "Tambah Rencana Tender ";
			$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

            $form_data = $this->services->get_form_data();
            $form_data = $this->load->view('templates/form/plain_form', $form_data , TRUE ) ;

            $this->data[ "contents" ] =  $form_data;
            
			$this->render( "pjp/tender/create/content" );
        }
	}

	public function detail( $tender_id = null )
    {
		if ($tender_id == NULL) redirect(site_url($this->current_page));
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->tender_model->errors() ? $this->tender_model->errors() : $this->session->flashdata('message')));
		if(  !empty( validation_errors() ) || $this->tender_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Detail Rencana Tender ";
		$this->data["header"] = "Detail Rencana Tender ";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

		$form_data = $this->services->get_form_data( $tender_id );
		$form_data = $this->load->view('templates/form/plain_form_readonly', $form_data , TRUE ) ;

		$form_data_draft_tender = $this->draft_tender_services->get_form_data()['form_data'];
		$form_data_draft_tender['tender_id']['value'] = $tender_id;
		$form_data_draft_tender['name']['value'] = $this->services->get_form_data( $tender_id )['form_data']['name']['value'];
		$create_draft_tender = array(
			"name" => "Buat Draft",
			"modal_id" => "create_draft_",
			"button_color" => "success",
			"url" => site_url( "pjp/draft_tender/add/"),
			"form_data" => $form_data_draft_tender,
			'data' => NULL
		);

		$create_draft_tender= $this->load->view('templates/actions/modal_form', $create_draft_tender, true ); 

		$draft_tender = $this->draft_tender_model
			->where('tender_id', $tender_id)
			->draft_tender()
			->row();

		if( !$draft_tender )
			$this->data[ "header_button" ] =  $create_draft_tender;

		$this->data[ "contents" ] =  $form_data;
		$this->render( "pjp/tender/detail/content" );
	}

	public function edit( $tender_id = null )
	{
		if ($tender_id == NULL) redirect(site_url($this->current_page));
		$this->form_validation->set_rules( $this->services->validation_config() );

        if ($this->form_validation->run() === TRUE )
        {
			$data['code'] = $this->input->post( 'code' );
			$data['name'] = $this->input->post( 'name' );
			$data['type'] = $this->input->post( 'type' );
			$data['budget'] = $this->input->post( 'budget' );
			$data['budget_source'] = $this->input->post( 'budget_source' );
			$data['year'] = $this->input->post( 'year' );
			$data['location'] = $this->input->post( 'location' );
			$data['method'] = $this->input->post( 'method' );
			$data['start_date'] = $this->input->post( 'start_date' );
			$data['end_date'] = $this->input->post( 'end_date' );
			$data['status'] = $this->input->post( 'status' );

			$data_param["id"] = $this->input->post( 'id' );

			if( $this->tender_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tender_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tender_model->errors() ) );
			}
			redirect( site_url($this->current_page));
		}
        else
        {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->tender_model->errors() ? $this->tender_model->errors() : $this->session->flashdata('message')));
            if(  !empty( validation_errors() ) || $this->tender_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

            $alert = $this->session->flashdata('alert');
			$this->data["key"] = $this->input->get('key', FALSE);
			$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
			$this->data["current_page"] = $this->current_page;
			$this->data["block_header"] = "Edit Paket ";
			$this->data["header"] = "Edit Paket ";
			$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

            $form_data = $this->services->get_form_data($tender_id);
            $form_data = $this->load->view('templates/form/plain_form', $form_data , TRUE ) ;

            $this->data[ "contents" ] =  $form_data;
            
			$this->render( "pjp/tender/edit/content" );
        }
	}

	public function delete(  ) {
		if( !($_POST) ) redirect( site_url($this->current_page) );
		if ($this->input->post('id') == NULL) redirect(site_url($this->current_page));
		
		$tender = $this->tender_model->tender( $this->input->post('id') )->row();

		$data_param['id'] 	= $this->input->post('id');
		if( $this->tender_model->delete( $data_param ) ){
			
			$config = $this->services->get_photo_upload_config();
			if (!@unlink($config['upload_path'] . $tender->image )) { };

		  	$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tender_model->messages() ) );
		}else{
		  	$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tender_model->errors() ) );
		}
		redirect( site_url($this->current_page )  );
	  }
}
