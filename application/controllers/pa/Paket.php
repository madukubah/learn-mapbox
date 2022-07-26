<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Paket extends User_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'pa';
	private $current_page = 'pa/paket/';
	
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
		foreach( $table[ "rows" ] as $row )
		{
			$row->id_enc = base64_encode($row->id);
		}
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

	public function add()
    {
		$this->form_validation->set_rules( $this->services->validation_config() );

		if ( $this->form_validation->run() === TRUE )
        {
			$data['draft_tender_id'] = $this->input->post( 'draft_tender_id' );
			$data['pa_id'] = $this->input->post( 'pa_id' );
			$data['name'] = $this->input->post( 'name' );
			$data['pokmil_id'] = $this->input->post( 'pokmil_id' );
			$data['date'] = $this->input->post( 'date' );
			$data['status'] = $this->input->post( 'status' );
			
			if( $this->paket_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->paket_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->paket_model->errors() ) );
				redirect( site_url('pa/draft_tender/detail/'.$data['draft_tender_id'] ));
				return;
			}
			redirect( site_url($this->current_page));
		}
        else
        {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->paket_model->errors() ? $this->paket_model->errors() : $this->session->flashdata('message')));
            if(  !empty( validation_errors() ) || $this->paket_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

			redirect( site_url('pa/draft_tender/detail/'.$this->input->post( 'draft_tender_id' ) ));
			return;
			$alert = $this->session->flashdata('alert');
			$this->session->set_flashdata('alert', NULL);

			$this->data["key"] = $this->input->get('key', FALSE);
			$this->data["alert"] = (isset($alert)) ? $alert : NULL ;

			// $this->data["alert"] .= ($this->upload->display_errors()) ? $this->alert->set_alert(Alert::DANGER, $this->upload->display_errors()) : NULL;

			$this->data["current_page"] = $this->current_page;
			$this->data["block_header"] = "Tambah Paket ";
			$this->data["header"] = "Tambah Paket ";
			$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

            $form_data = $this->services->get_form_data();
            $form_data = $this->load->view('templates/form/plain_form', $form_data , TRUE ) ;

            $this->data[ "contents" ] =  $form_data;
            
			$this->render( "pa/paket/create/content" );
        }
	}

	public function detail( $paket_id = null )
    {
		$paket_id = base64_decode($paket_id);
		$paket = $this->paket_model->paket( $paket_id )->row();
		if( ! $paket ) 
			redirect( site_url($this->current_page)  );
			
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
		$form_data_draft_tender = $this->load->view('pt/paket/detail/plain_form_readonly', $form_data_draft_tender , TRUE ) ;

		$this->data[ "contents_2" ] =  $form_data_draft_tender;

		$this->render( "pa/paket/detail/content" );
	}	

	public function edit( $paket_id = null )
	{
		$paket_id = base64_decode($paket_id);
		$paket = $this->paket_model->paket( $paket_id )->row();
		if( ! $paket ) 
			redirect( site_url($this->current_page)  );
		if ($paket_id == NULL) redirect(site_url($this->current_page));
		$this->form_validation->set_rules( $this->services->validation_config() );

		$this->load->library('upload'); // Load librari upload
		$config = $this->services->get_photo_upload_config();

		$this->upload->initialize($config);

        if ($this->form_validation->run() === TRUE )
        {
			$data['draft_tender_id'] = $this->input->post( 'draft_tender_id' );
			$data['pa_id'] = $this->input->post( 'pa_id' );
			$data['name'] = $this->input->post( 'name' );
			$data['pokmil_id'] = $this->input->post( 'pokmil_id' );
			$data['date'] = $this->input->post( 'date' );
			$data['status'] = $this->input->post( 'status' );

			$data_param["id"] = $this->input->post( 'id' );

			if( $this->paket_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->paket_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->paket_model->errors() ) );
			}
			redirect( site_url($this->current_page));
		}
        else
        {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->paket_model->errors() ? $this->paket_model->errors() : $this->session->flashdata('message')));
            if(  !empty( validation_errors() ) || $this->paket_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

            $alert = $this->session->flashdata('alert');
			$this->data["key"] = $this->input->get('key', FALSE);
			$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
			$this->data["current_page"] = $this->current_page;
			$this->data["block_header"] = "Edit Paket ";
			$this->data["header"] = "Edit Paket ";
			$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

            $form_data = $this->services->get_form_data($paket_id);
            $form_data = $this->load->view('templates/form/plain_form', $form_data , TRUE ) ;

            $this->data[ "contents" ] =  $form_data;
            
			$this->render( "pa/paket/edit/content" );
        }
	}

	public function delete(  ) {
		if( !($_POST) ) redirect( site_url($this->current_page) );
		if ($this->input->post('id') == NULL) redirect(site_url($this->current_page));
		
		$tender = $this->paket_model->paket( $this->input->post('id') )->row();

		$data_param['id'] 	= $this->input->post('id');
		if( $this->paket_model->delete( $data_param ) ){
			
			$config = $this->services->get_photo_upload_config();
			if (!@unlink($config['upload_path'] . $tender->image )) { };

		  	$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->paket_model->messages() ) );
		}else{
		  	$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->paket_model->errors() ) );
		}
		redirect( site_url($this->current_page )  );
	  }
}
