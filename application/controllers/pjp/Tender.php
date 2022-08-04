<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tender extends Pjp_Controller {
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
			'tender_penyedia_model',
			'schedule_model',
			'comment_model',
		));
	}	

	public function index(  )
	{
		// 
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		//pagination parameter
		$pagination['base_url'] = site_url( $this->current_page ) .'/index';
		$pagination['total_records'] = $this->tender_model->record_count() ;
		$pagination['limit_per_page'] = 10;
		$pagination['start_record'] = $page*$pagination['limit_per_page'];
		$pagination['uri_segment'] = 4;
		//set pagination
		if ($pagination['total_records']>0) $this->data['pagination_links'] = $this->setPagination($pagination);

		$table = $this->services->get_table_config( $this->current_page );

		if($this->input->get( 'search' )){
			$table[ "rows" ] = $this->tender_model
				->like($table["search"]["field"], $this->input->get( 'search' ))
				->tenders( $pagination['start_record'], $pagination['limit_per_page'] )->result();
		}
		else
		{
			$table[ "rows" ] = $this->tender_model
				->where( 'status', $this->input->get( 'status' ) )
				->tenders( $pagination['start_record'], $pagination['limit_per_page'] )->result();
		}
		for ($i=0; $i < count($table[ "rows" ]); $i++) { 
			$table[ "rows" ][$i]->year = $table[ "rows" ][$i]->year." ";
		}
		foreach( $table[ "rows" ] as $row )
		{
			$row->id_enc = base64_encode($row->id);
		}
		$table = $this->load->view('templates/tables/plain_table', $table, true);
		$this->data[ "contents" ] = $table;

		$link_add = 
		array(
			"name" => "Tambah Rencana Tender",
			"type" => "link",
			"url" => site_url( $this->current_page."add/"),
			"button_color" => "primary",	
			"data" => NULL,
		);
		$this->data[ "header_button" ] =  $this->load->view('templates/actions/link', $link_add, TRUE );
		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Tender";
		$this->data["header"] = "Tender";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}

	public function add()
    {
		$this->form_validation->set_rules( $this->services->validation_config() );

		if ( $this->form_validation->run() === TRUE )
        {
			$data['code'] = 'X';
			switch($this->input->post( 'type' ))
			{
				case 'Pengadaan Barang':
					$data['code'] = 'PB'.substr(".".time(), -6);
					break;
				case 'Pekerjaan Konstruksi':
					$data['code'] = 'PK'.substr(".".time(), -6);
					break;
			}
			$data['name'] = $this->input->post( 'name' );
			$data['type'] = $this->input->post( 'type' );
			$data['budget'] = str_ireplace(",", "", $this->input->post( 'budget' ));
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
			redirect( site_url($this->current_page.'?status=Rencana'));
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
			$this->data["block_header"] = "";
			$this->data["header"] = "Tambah Rencana Tender";
			$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

            $form_data = $this->services->get_form_data();
			$form_data['form_data']['status']['type'] = 'hidden';
			$form_data['form_data']['status']['value'] = 'Rencana';
            $form_data = $this->load->view('templates/form/plain_form', $form_data , TRUE ) ;

            $this->data[ "contents" ] =  $form_data;
            
			$this->render( "pjp/tender/create/content" );
        }
	}

	public function detail( $tender_id = null )
    {
		$tender_id = base64_decode($tender_id);
		$tender = $this->tender_model->tender( $tender_id )->row();
		if( ! $tender ) 
			redirect( site_url($this->current_page)  );

		if ($tender_id == NULL) redirect(site_url($this->current_page));
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->tender_model->errors() ? $this->tender_model->errors() : $this->session->flashdata('message')));
		if(  !empty( validation_errors() ) || $this->tender_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Detail Tender ";
		$this->data["header"] = "Detail Tender ";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->data[ "header_button" ] = '';
		$form_data = $this->services->get_form_data( $tender_id );
		$form_data = $this->load->view('templates/form/plain_form_readonly', $form_data , TRUE ) ;

		$form_data_draft_tender = $this->draft_tender_services->get_form_data()['form_data'];
		$form_data_draft_tender['tender_id']['value'] = $tender_id;
		$form_data_draft_tender['name']['value'] = $this->services->get_form_data( $tender_id )['form_data']['name']['value'];
		unset( $form_data_draft_tender['kak_file'] );
		unset( $form_data_draft_tender['design_file'] );
		unset( $form_data_draft_tender['other_file'] );
		$done_tender_tender = array(
			"name" => "Buat Draft",
			"modal_id" => "done_tender_",
			"button_color" => "success",
			"url" => site_url( "pjp/draft_tender/add/"),
			"form_data" => $form_data_draft_tender,
			'data' => NULL
		);

		$done_tender_tender= $this->load->view('templates/actions/modal_form', $done_tender_tender, true ); 

		$draft_tender = $this->draft_tender_model
			->where('tender_id', $tender_id)
			->draft_tender()
			->row();

		if( !$draft_tender )
			$this->data[ "header_button" ] =  $done_tender_tender;
		
		$finish_tender = array(
			"name" => "Tender Selesai",
			"modal_id" => "done_tender_",
			"button_color" => "success",
			"url" => site_url( "pjp/tender/edit/".base64_encode( $tender->id ) ),
			"form_data" => array(
				"id" => array(
					'type' => 'hidden',
					'label' => "Nama Tender",
					'value' => $tender->id,
				),
				"name" => array(
					'type' => 'text',
					'label' => "Nama Tender",
					'readonly' => true,
					'value' => $tender->name,
				),
				"status" => array(
					'type' => 'hidden',
					'label' => "status",
					'value' => 'Selesai',
				),
			),
			'data' => NULL
		);

		$finish_tender= $this->load->view('templates/actions/modal_form', $finish_tender, true ); 
		if( $tender->status == 'Tayang' )
			$this->data[ "header_button" ] .=  $finish_tender;

		$link_edit_tender = 
		array(
			"name" => "Edit",
			"type" => "link",
			"url" => site_url( "pjp/tender/edit/".base64_encode( $tender->id ) ),
			"button_color" => "warning",	
			"data" => NULL,
		);
		$this->data[ "header_button" ] .=  $this->load->view('templates/actions/link', $link_edit_tender, TRUE );

		if( $tender->status == 'Rencana' )
		{
			$this->data[ "contents" ] =  $form_data;
			$this->render( "pjp/tender/detail/content" );
		}
		else
		{
			$draft_tender = $this->draft_tender_model
				->where('tender_id', $tender_id)
				->draft_tender()
				->row();
			$form_data_draft_tender = $this->draft_tender_services->get_form_data( $draft_tender->id );
			unset($form_data_draft_tender['form_data']['name']);
			unset($form_data_draft_tender['form_data']['status']);
			$form_data_draft_tender = $this->load->view('pt/paket/detail/plain_form_readonly', $form_data_draft_tender , TRUE ) ;


			$user_id = $this->ion_auth->get_user_id();
			
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
				
			$schedule = $this->schedule_model
				->where('tender_id', $tender_id)
				->schedule()
				->row();
			$tender_penyedia_table['user_id'] = $user_id;
			$tender_penyedia_table['schedule'] = $schedule;
			$tender_penyedia_table = $this->load->view('pjp/tender/detail/plain_table', $tender_penyedia_table, true);
			$this->data[ "contents" ] =  $form_data.$form_data_draft_tender;
			$this->data[ "contents_2" ] =  $tender_penyedia_table;
			$schedule_id = '';
			$schedule_table = $this->load->view('penyedia/tender/detail/schedule_table', array('schedule' => $schedule,'tender_id' => $tender_id ), true);
			$this->data[ "contents_3" ] =  $schedule_table;
			$comments = $this->comment_model
				->select('
					comment.*,
					concat(users.first_name, " ", users.last_name) as user_name
				')
				->join(
					'users',
					'users.id = comment.user_id',
					'left'
				)
				->where('tender_id', $tender_id)
				->comments()
				->result();
			$this->data[ "comments" ] =  $comments;
			$this->data[ "tender" ] =  $tender;
			$this->render( "pjp/tender/detail/content_tayang" );
		}
	}

	public function edit( $tender_id = null )
	{
		$tender_id = base64_decode($tender_id);
		$tender = $this->tender_model->tender( $tender_id )->row();
		if( ! $tender ) 
			redirect( site_url($this->current_page)  );
		if ($tender_id == NULL) redirect(site_url($this->current_page));
		$this->form_validation->set_rules( $this->services->validation_config() );

        if ($this->form_validation->run() === TRUE )
        {
			foreach($this->input->post() as $key => $post)
			{
				$data[$key] = $post;
			}

			$data_param["id"] = $this->input->post( 'id' );

			if( $this->tender_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tender_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tender_model->errors() ) );
			}
			redirect( site_url($this->current_page.'detail/'.base64_encode($tender->id)));
		}
        else
        {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->tender_model->errors() ? $this->tender_model->errors() : $this->session->flashdata('message')));
            if(  !empty( validation_errors() ) || $this->tender_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

            $alert = $this->session->flashdata('alert');
			$this->data["key"] = $this->input->get('key', FALSE);
			$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
			$this->data["current_page"] = $this->current_page;
			$this->data["block_header"] = " ";
			$this->data["header"] = "Edit Rencana Paket ";
			$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

            $form_data = $this->services->get_form_data($tender_id);
			$form_data['form_data']['status']['readonly'] = TRUE;
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
