<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pokmil extends User_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'pa';
	private $current_page = 'pa/pokmil/';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('services/Pokmil_services');
		$this->services = new Pokmil_services;

		$this->load->model(array(
			'pokmil_model',
		));
	}	

	public function index(  )
	{
		// 
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		//pagination parameter
		$pagination['base_url'] = site_url( $this->current_page ) .'/index';
		$pagination['total_records'] = $this->pokmil_model->record_count() ;
		$pagination['limit_per_page'] = 10;
		$pagination['start_record'] = $page*$pagination['limit_per_page'];
		$pagination['uri_segment'] = 4;
		//set pagination
		if ($pagination['total_records']>0) $this->data['pagination_links'] = $this->setPagination($pagination);

		$table = $this->services->get_table_config( $this->current_page );
		$table[ "rows" ] = $this->pokmil_model
		->select('pokmil.*, concat(users.first_name, " ", users.last_name) as lead_full_name')
		->join(
			"users",
			"users.id = pokmil.lead_id",
			"inner"
		)->pokmils( $pagination['start_record'], $pagination['limit_per_page'] )->result();
		foreach( $table[ "rows" ] as $row )
		{
			$row->id_enc = base64_encode($row->id);
		}
		$table = $this->load->view('templates/tables/plain_table', $table, true);
		$this->data[ "contents" ] = $table;

		$link_add = 
		array(
			"name" => "Tambah Pokmil",
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
		$this->data["block_header"] = "";
		$this->data["header"] = "Kelompok Kerja Pemilihan (Pokmil)";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}

	public function add()
    {
		$this->form_validation->set_rules( $this->services->validation_config() );

		if ( $this->form_validation->run() === TRUE )
        {
			$data['name'] = $this->input->post( 'name' );
			$data['sk_no'] = $this->input->post( 'sk_no' );
			$data['lead_id'] = $this->input->post( 'lead_id' );
			$data['member_1_id'] = $this->input->post( 'member_1_id' );
			$data['member_2_id'] = $this->input->post( 'member_2_id' );
			$data['member_3_id'] = $this->input->post( 'member_3_id' );
			$data['member_4_id'] = $this->input->post( 'member_4_id' );
			$data['date'] = $this->input->post( 'date' );
			$data['status'] = $this->input->post( 'status' );
			
			if( $this->pokmil_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->pokmil_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->pokmil_model->errors() ) );
			}
			redirect( site_url($this->current_page));
		}
        else
        {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->pokmil_model->errors() ? $this->pokmil_model->errors() : $this->session->flashdata('message')));
            if(  !empty( validation_errors() ) || $this->pokmil_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

			$alert = $this->session->flashdata('alert');
			$this->session->set_flashdata('alert', NULL);

			$this->data["key"] = $this->input->get('key', FALSE);
			$this->data["alert"] = (isset($alert)) ? $alert : NULL ;

			// $this->data["alert"] .= ($this->upload->display_errors()) ? $this->alert->set_alert(Alert::DANGER, $this->upload->display_errors()) : NULL;

			$this->data["current_page"] = $this->current_page;
			$this->data["block_header"] = "";
			$this->data["header"] = "Tambah Pokmil ";
			$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

            $form_data = $this->services->get_form_data();
            $form_data = $this->load->view('templates/form/plain_form', $form_data , TRUE ) ;

            $this->data[ "contents" ] =  $form_data;
            
			$this->render( "pa/pokmil/create/content" );
        }
	}

	public function detail( $pokmil_id = null )
    {
		$pokmil_id = base64_decode($pokmil_id);
		if ($pokmil_id == NULL) redirect(site_url($this->current_page));
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->pokmil_model->errors() ? $this->pokmil_model->errors() : $this->session->flashdata('message')));
		if(  !empty( validation_errors() ) || $this->pokmil_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Detail Kelompok Kerja Pemilihan (Pokmil)";
		$this->data["header"] = "Detail Kelompok Kerja Pemilihan (Pokmil)";
		$this->data["sub_header"] = '';

		$form_data = $this->services->get_form_data( $pokmil_id );
		$form_data = $this->load->view('templates/form/plain_form_readonly', $form_data , TRUE ) ;
		$this->data[ "contents" ] =  $form_data;
		$this->render( "pa/pokmil/detail/content" );
	}

	public function edit( $pokmil_id = null )
	{
		$pokmil_id = base64_decode($pokmil_id);
		if ($pokmil_id == NULL) redirect(site_url($this->current_page));
		$this->form_validation->set_rules( $this->services->validation_config() );

        if ($this->form_validation->run() === TRUE )
        {
			$data['name'] = $this->input->post( 'name' );
			$data['sk_no'] = $this->input->post( 'sk_no' );
			$data['lead_id'] = $this->input->post( 'lead_id' );
			$data['member_1_id'] = $this->input->post( 'member_1_id' );
			$data['member_2_id'] = $this->input->post( 'member_2_id' );
			$data['member_3_id'] = $this->input->post( 'member_3_id' );
			$data['member_4_id'] = $this->input->post( 'member_4_id' );
			$data['date'] = $this->input->post( 'date' );
			$data['status'] = $this->input->post( 'status' );

			$data_param["id"] = $this->input->post( 'id' );

			if( $this->pokmil_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->pokmil_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->pokmil_model->errors() ) );
			}
			redirect( site_url($this->current_page));
		}
        else
        {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->pokmil_model->errors() ? $this->pokmil_model->errors() : $this->session->flashdata('message')));
            if(  !empty( validation_errors() ) || $this->pokmil_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

            $alert = $this->session->flashdata('alert');
			$this->data["key"] = $this->input->get('key', FALSE);
			$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
			$this->data["current_page"] = $this->current_page;
			$this->data["block_header"] = "";
			$this->data["header"] = "Edit Kelompok Kerja Pemilihan (Pokmil)";
			$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

            $form_data = $this->services->get_form_data($pokmil_id);
            $form_data = $this->load->view('templates/form/plain_form', $form_data , TRUE ) ;

            $this->data[ "contents" ] =  $form_data;
            
			$this->render( "pa/pokmil/edit/content" );
        }
	}

	public function delete(  ) {
		if( !($_POST) ) redirect( site_url($this->current_page) );
		if ($this->input->post('id') == NULL) redirect(site_url($this->current_page));
		
		$pokmil = $this->pokmil_model->pokmil( $this->input->post('id') )->row();

		$data_param['id'] 	= $this->input->post('id');
		if( $this->pokmil_model->delete( $data_param ) ){
			
			$config = $this->services->get_photo_upload_config();
			if (!@unlink($config['upload_path'] . $pokmil->image )) { };

		  	$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->pokmil_model->messages() ) );
		}else{
		  	$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->pokmil_model->errors() ) );
		}
		redirect( site_url($this->current_page )  );
	  }
}
