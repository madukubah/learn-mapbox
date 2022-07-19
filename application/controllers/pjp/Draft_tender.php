<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Draft_tender extends User_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'pjp';
	private $current_page = 'pjp/draft_tender/';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('services/Draft_tender_services');
		$this->services = new Draft_tender_services;
		$this->load->model(array(
			'draft_tender_model',
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
		$table[ "rows" ] = $this->draft_tender_model
			->select('
				draft_tender.*,
				concat(users.first_name, " ", users.last_name) as pa_name
			')
			->join(
				'users',
				'users.id = draft_tender.pa_id',
				'left'
			)
			->draft_tenders( $pagination['start_record'], $pagination['limit_per_page'] )->result();
		$users = $this->ion_auth->users_limit( 1000, 0, 'pa' )->result();
		// $user_select = array();
		// foreach( $users as $user )
		// {
		// 	$user_select[ $user->id ] = $user->first_name." ".$user->last_name;
		// }
		// for ($i=0; $i < count($table[ "rows" ]) ; $i++) { 
		// 	$table[ "rows" ][$i]->pa_name = $user_select[ $table[ "rows" ][$i]->pa_id ];
		// }

		$table = $this->load->view('templates/tables/plain_table', $table, true);
		$this->data[ "contents" ] = $table;

		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Draft Tender";
		$this->data["header"] = "Draft Tender";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}

	public function add()
    {
		$this->form_validation->set_rules( $this->services->validation_config() );

		if ( $this->form_validation->run() === TRUE )
        {
			$data['tender_id'] = $this->input->post( 'tender_id' );
			$data['pa_id'] = $this->input->post( 'pa_id' );
			$data['name'] = $this->input->post( 'name' );
			$data['contract_type'] = $this->input->post( 'contract_type' );
			$data['budget_estimation'] = $this->input->post( 'budget_estimation' );
			$data['date'] = $this->input->post( 'date' );
			$data['status'] = $this->input->post( 'status' );
			
			if( $this->draft_tender_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->draft_tender_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->draft_tender_model->errors() ) );
			}
			redirect( site_url($this->current_page));
		}
        else
        {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->draft_tender_model->errors() ? $this->draft_tender_model->errors() : $this->session->flashdata('message')));
            if(  !empty( validation_errors() ) || $this->draft_tender_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

			$alert = $this->session->flashdata('alert');
			$this->session->set_flashdata('alert', NULL);

			$this->data["key"] = $this->input->get('key', FALSE);
			$this->data["alert"] = (isset($alert)) ? $alert : NULL ;

			// $this->data["alert"] .= ($this->upload->display_errors()) ? $this->alert->set_alert(Alert::DANGER, $this->upload->display_errors()) : NULL;

			$this->data["current_page"] = $this->current_page;
			$this->data["block_header"] = "Tambah Draft Tender ";
			$this->data["header"] = "Tambah Draft Tender ";
			$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

            $form_data = $this->services->get_form_data();
            $form_data = $this->load->view('templates/form/plain_form', $form_data , TRUE ) ;

            $this->data[ "contents" ] =  $form_data;
            
			$this->render( "pjp/draft_tender/create/content" );
        }
	}

	public function detail( $draft_tender_id = null )
    {
		if ($draft_tender_id == NULL) redirect(site_url($this->current_page));
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->draft_tender_model->errors() ? $this->draft_tender_model->errors() : $this->session->flashdata('message')));
		if(  !empty( validation_errors() ) || $this->draft_tender_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Detail Draft Tender ";
		$this->data["header"] = "Detail Draft Tender ";
		$this->data["sub_header"] = '';

		$form_data = $this->services->get_form_data( $draft_tender_id );
		$form_data = $this->load->view('pjp/draft_tender/detail/plain_form_readonly', $form_data , TRUE ) ;

		$this->data[ "contents" ] =  $form_data;
		$this->render( "pjp/draft_tender/detail/content" );
	}

	public function edit( $draft_tender_id = null )
	{
		if ($draft_tender_id == NULL) redirect(site_url($this->current_page));
		$this->form_validation->set_rules( $this->services->validation_config() );

		$this->load->library('upload'); // Load librari upload
		$config = $this->services->get_photo_upload_config();
		// echo var_dump($config);
		// return;

		$this->upload->initialize($config);

        if ($this->form_validation->run() === TRUE )
        {
			if( isset($_FILES["kak_file"] ) && $_FILES["kak_file"]["name"] != '' ){
				
				if ( $this->upload->do_upload("kak_file") ) {
					$data['kak_file'] = $this->upload->data()["file_name"];

					$draft_tender = $this->draft_tender_model->draft_tender( $draft_tender_id )->row();
					if (!@unlink($config['upload_path'] . $draft_tender->kak_file )) { };
				}else {
					$this->session->set_flashdata('alert', $this->alert->set_alert(Alert::DANGER, $this->upload->display_errors()));
				}
			}

			if( isset($_FILES["design_file"] ) && $_FILES["design_file"]["name"] != '' ){
				
				if ( $this->upload->do_upload("design_file") ) {
					$data['design_file'] = $this->upload->data()["file_name"];

					$draft_tender = $this->draft_tender_model->draft_tender( $draft_tender_id )->row();
					if (!@unlink($config['upload_path'] . $draft_tender->design_file )) { };
				}else {
					$this->session->set_flashdata('alert', $this->alert->set_alert(Alert::DANGER, $this->upload->display_errors()));
				}
			}

			if( isset($_FILES["other_file"] ) && $_FILES["other_file"]["name"] != '' ){
				
				if ( $this->upload->do_upload("other_file") ) {
					$data['other_file'] = $this->upload->data()["file_name"];

					$draft_tender = $this->draft_tender_model->draft_tender( $draft_tender_id )->row();
					if (!@unlink($config['upload_path'] . $draft_tender->other_file )) { };
				}else {
					$this->session->set_flashdata('alert', $this->alert->set_alert(Alert::DANGER, $this->upload->display_errors()));
				}
			}

			$data['tender_id'] = $this->input->post( 'tender_id' );
			$data['pa_id'] = $this->input->post( 'pa_id' );
			$data['name'] = $this->input->post( 'name' );
			$data['contract_type'] = $this->input->post( 'contract_type' );
			$data['budget_estimation'] = $this->input->post( 'budget_estimation' );
			$data['date'] = $this->input->post( 'date' );
			$data['status'] = $this->input->post( 'status' );

			$data_param["id"] = $this->input->post( 'id' );

			if( $this->draft_tender_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->draft_tender_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->draft_tender_model->errors() ) );
			}
			redirect( site_url($this->current_page));
		}
        else
        {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->draft_tender_model->errors() ? $this->draft_tender_model->errors() : $this->session->flashdata('message')));
            if(  !empty( validation_errors() ) || $this->draft_tender_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

            $alert = $this->session->flashdata('alert');
			$this->data["key"] = $this->input->get('key', FALSE);
			$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
			$this->data["current_page"] = $this->current_page;
			$this->data["block_header"] = "";
			$this->data["header"] = "Edit Paket";
			$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

            $form_data = $this->services->get_form_data($draft_tender_id);
            $form_data = $this->load->view('templates/form/plain_form', $form_data , TRUE ) ;

            $this->data[ "contents" ] =  $form_data;
            
			$this->render( "pjp/draft_tender/edit/content" );
        }
	}

	public function delete(  ) {
		if( !($_POST) ) redirect( site_url($this->current_page) );
		if ($this->input->post('id') == NULL) redirect(site_url($this->current_page));
		
		$tender = $this->draft_tender_model->draft_tender( $this->input->post('id') )->row();

		$data_param['id'] 	= $this->input->post('id');
		if( $this->draft_tender_model->delete( $data_param ) ){
			
			$config = $this->services->get_photo_upload_config();
			if (!@unlink($config['upload_path'] . $tender->image )) { };

		  	$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->draft_tender_model->messages() ) );
		}else{
		  	$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->draft_tender_model->errors() ) );
		}
		redirect( site_url($this->current_page )  );
	  }
}
