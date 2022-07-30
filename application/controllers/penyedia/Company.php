<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company extends User_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'penyedia';
	private $current_page = 'penyedia/company/';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('services/Company_services');
		$this->services = new Company_services;

		$this->load->model(array(
			'company_model',
			'company_permission_model',
			'acta_model',
			'ownership_model',
			'expert_model',
			'tool_model',
			'experience_model',
			'tax_model',
		));
	}	

	public function index(  )
	{
		$user_id = $this->ion_auth->get_user_id();
		$company = $this->company_model
			->where('user_id', $user_id)
			->company()
			->row();
		if( $company )
		{

			redirect(site_url( $this->current_page.'detail/'.base64_encode($company->id) ));
		}
		else
		{
			redirect(site_url( 'penyedia/tender'));
		}

		// // 
		// $page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		// //pagination parameter
		// $pagination['base_url'] = site_url( $this->current_page ) .'/index';
		// $pagination['total_records'] = $this->company_model->record_count() ;
		// $pagination['limit_per_page'] = 10;
		// $pagination['start_record'] = $page*$pagination['limit_per_page'];
		// $pagination['uri_segment'] = 4;
		// //set pagination
		// if ($pagination['total_records']>0) $this->data['pagination_links'] = $this->setPagination($pagination);

		// $table = $this->services->get_table_config( $this->current_page );
		// $table[ "rows" ] = $this->company_model->companys( $pagination['start_record'], $pagination['limit_per_page'] )->result();
		// $table = $this->load->view('templates/tables/plain_table', $table, true);
		// $this->data[ "contents" ] = $table;

		// $link_add = 
		// array(
		// 	"name" => "Tambah",
		// 	"type" => "link",
		// 	"url" => site_url( $this->current_page."add/"),
		// 	"button_color" => "primary",	
		// 	"data" => NULL,
		// );
		// $this->data[ "header_button" ] =  $this->load->view('templates/actions/link', $link_add, TRUE ); ;
		
		// $alert = $this->session->flashdata('alert');
		// $this->data["key"] = $this->input->get('key', FALSE);
		// $this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		// $this->data["current_page"] = $this->current_page;
		// $this->data["block_header"] = "Kelompok Kerja Pemilihan";
		// $this->data["header"] = "Kelompok Kerja Pemilihan";
		// $this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		// $this->render( "templates/contents/plain_content" );
	}

	public function detail( $company_id = null )
    {
		$company_id = base64_decode($company_id);
		$company = $this->company_model->company( $company_id )->row();
		if( ! $company ) 
			redirect( site_url($this->parent_page)  );
		if ($company_id == NULL) redirect(site_url($this->current_page));
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->company_model->errors() ? $this->company_model->errors() : $this->session->flashdata('message')));
		if(  !empty( validation_errors() ) || $this->company_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Perusahaan Saya";
		$this->data["header"] = "Perusahaan Saya";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

		$form_data = $this->services->get_form_data( $company_id );
		$form_data['form_data']['province']['type'] = 'text';
		$form_data['form_data']['city']['type'] = 'text';
		$form_data = $this->load->view('templates/form/plain_form_readonly', $form_data , TRUE ) ;
		$this->data[ "contents" ] =  $form_data;
		
		$link_edit_company = 
		array(
			"name" => "Edit",
			"type" => "link",
			"url" => site_url( "penyedia/company/edit/".$company_id),
			"button_color" => "primary",	
			"data" => NULL,
		);
		$this->data[ "header_button" ] =  $this->load->view('templates/actions/link', $link_edit_company, TRUE );
		#############################################################################
		$company_permission_table = $this->services->get_company_permission_table_config( site_url( $this->current_page."company_permission/".$company_id) );
		$company_permission_table['rows'] = $this->company_permission_model
			->select('
				*,
				concat(name, " ") as name,
				concat(cert_no, " ") as cert_no,
				concat(agency_from, " ") as agency_from
			')
			->where('company_id', $company_id)
			->company_permissions()
			->result();
		$company_permission_table = $this->load->view('templates/tables/plain_table', $company_permission_table, true);
		$add_company_permission = array(
			"name" => "Tambah Ijin",
			"modal_id" => "add_permission_",
			"button_color" => "primary",
			"url" => site_url( $this->current_page."company_permission/".$company_id),
			"form_data" => $this->services->get_company_permission_table_config('')['action'][0]['form_data'],
			'data' => NULL
		);
		$add_company_permission["form_data"]['company_id']['value'] = $company_id;
		$add_company_permission= $this->load->view('templates/actions/modal_form', $add_company_permission, true ); 
		$company_permission_card = $this->load->view(
			'penyedia/company/detail/content_card_12', 
			array(
				'contents' => $company_permission_table,
				'header_button' => $add_company_permission,
				'header' => 'Ijin Perusahaan',
			), 
			true
		);		
		$this->data[ "company_permission_contents" ] = $company_permission_card;
		#############################################################################
		$acta_table = $this->services->get_acta_table_config( site_url( $this->current_page."acta/".$company_id) );
		$acta_table['rows'] = $this->acta_model
			->select('
				*,
				concat(name, " ") as name
			')
			->where('company_id', $company_id)
			->actas()
			->result();
		$acta_table = $this->load->view('templates/tables/plain_table', $acta_table, true);
		$add_acta = array(
			"name" => "Tambah Akta",
			"modal_id" => "add_acta_",
			"button_color" => "primary",
			"url" => site_url( $this->current_page."acta/".$company_id),
			"form_data" => $this->services->get_acta_table_config('')['action'][0]['form_data'],
			'data' => NULL
		);
		$add_acta["form_data"]['company_id']['value'] = $company_id;
		$add_acta= $this->load->view('templates/actions/modal_form', $add_acta, true ); 
		$acta_card = $this->load->view(
			'penyedia/company/detail/content_card_12', 
			array(
				'contents' => $acta_table,
				'header_button' => $add_acta,
				'header' => 'Akta',
			), 
			true
		);		
		$this->data[ "acta_contents" ] = $acta_card;
		#############################################################################
		$ownership_table = $this->services->get_ownership_table_config( site_url( $this->current_page."ownership/".$company_id) );
		$ownership_table['rows'] = $this->ownership_model
			->select('
				*,
				concat(id_number, " ") as id_number
			')
			->where('company_id', $company_id)
			->ownerships()
			->result();
		$ownership_table = $this->load->view('templates/tables/plain_table', $ownership_table, true);
		$add_ownership = array(
			"name" => "Tambah Pemilik",
			"modal_id" => "add_ownership_",
			"button_color" => "primary",
			"url" => site_url( $this->current_page."ownership/".$company_id),
			"form_data" => $this->services->get_ownership_table_config('')['action'][0]['form_data'],
			'data' => NULL
		);
		$add_ownership["form_data"]['company_id']['value'] = $company_id;
		$add_ownership= $this->load->view('templates/actions/modal_form', $add_ownership, true ); 
		$ownership_card = $this->load->view(
			'penyedia/company/detail/content_card_12', 
			array(
				'contents' => $ownership_table,
				'header_button' => $add_ownership,
				'header' => 'Pemilik',
			), 
			true
		);		
		$this->data[ "ownership_contents" ] = $ownership_card;
		#############################################################################
		$expert_table = $this->services->get_expert_table_config( site_url( $this->current_page."expert/".$company_id) );
		$expert_table['rows'] = $this->expert_model
			->select('
				*,
				concat(npwp, " ") as npwp
			')
			->where('company_id', $company_id)
			->experts()
			->result();
		$expert_table = $this->load->view('templates/tables/plain_table', $expert_table, true);
		$add_expert = array(
			"name" => "Tambah Tenaga Ahli",
			"modal_id" => "add_expert_",
			"button_color" => "primary",
			"url" => site_url( $this->current_page."expert/".$company_id),
			"form_data" => $this->services->get_expert_table_config('')['action'][0]['form_data'],
			'data' => NULL
		);
		$add_expert["form_data"]['company_id']['value'] = $company_id;
		$add_expert= $this->load->view('templates/actions/modal_form', $add_expert, true ); 
		$expert_card = $this->load->view(
			'penyedia/company/detail/content_card_12', 
			array(
				'contents' => $expert_table,
				'header_button' => $add_expert,
				'header' => 'Tenaga Ahli',
			), 
			true
		);		
		$this->data[ "expert_contents" ] = $expert_card;
		#############################################################################
		$tool_table = $this->services->get_tool_table_config( site_url( $this->current_page."tool/".$company_id) );
		$tool_table['rows'] = $this->tool_model
			->where('company_id', $company_id)
			->tools()
			->result();
		$tool_table = $this->load->view('templates/tables/plain_table', $tool_table, true);
		$add_tool = array(
			"name" => "Tambah Peralatan",
			"modal_id" => "add_tool_",
			"button_color" => "primary",
			"url" => site_url( $this->current_page."tool/".$company_id),
			"form_data" => $this->services->get_tool_table_config('')['action'][0]['form_data'],
			'data' => NULL
		);
		$add_tool["form_data"]['company_id']['value'] = $company_id;
		$add_tool= $this->load->view('templates/actions/modal_form', $add_tool, true ); 
		$tool_card = $this->load->view(
			'penyedia/company/detail/content_card_12', 
			array(
				'contents' => $tool_table,
				'header_button' => $add_tool,
				'header' => 'Peralatan',
			), 
			true
		);		
		$this->data[ "tool_contents" ] = $tool_card;
		#############################################################################
		$experience_table = $this->services->get_experience_table_config( site_url( $this->current_page."experience/".$company_id) );
		$experience_table['rows'] = $this->experience_model
			->where('company_id', $company_id)
			->experiences()
			->result();
		$experience_table = $this->load->view('templates/tables/plain_table', $experience_table, true);
		$add_experience = array(
			"name" => "Tambah Pengalaman",
			"modal_id" => "add_experience_",
			"button_color" => "primary",
			"url" => site_url( $this->current_page."experience/".$company_id),
			"form_data" => $this->services->get_experience_table_config('')['action'][0]['form_data'],
			'data' => NULL
		);
		$add_experience["form_data"]['company_id']['value'] = $company_id;
		$add_experience= $this->load->view('templates/actions/modal_form', $add_experience, true ); 
		$experience_card = $this->load->view(
			'penyedia/company/detail/content_card_12', 
			array(
				'contents' => $experience_table,
				'header_button' => $add_experience,
				'header' => 'Pengalaman',
			), 
			true
		);		
		$this->data[ "experience_contents" ] = $experience_card;
		#############################################################################
		$tax_table = $this->services->get_tax_table_config( site_url( $this->current_page."tax/".$company_id) );
		$tax_table['rows'] = $this->tax_model
			->where('company_id', $company_id)
			->taxs()
			->result();
		$tax_table = $this->load->view('templates/tables/plain_table', $tax_table, true);
		$add_tax = array(
			"name" => "Tambah Pajak",
			"modal_id" => "add_tax_",
			"button_color" => "primary",
			"url" => site_url( $this->current_page."tax/".$company_id),
			"form_data" => $this->services->get_tax_table_config('')['action'][0]['form_data'],
			'data' => NULL
		);
		$add_tax["form_data"]['company_id']['value'] = $company_id;
		$add_tax= $this->load->view('templates/actions/modal_form', $add_tax, true ); 
		$tax_card = $this->load->view(
			'penyedia/company/detail/content_card_12', 
			array(
				'contents' => $tax_table,
				'header_button' => $add_tax,
				'header' => 'Pajak',
			), 
			true
		);		
		$this->data[ "tax_contents" ] = $tax_card;
		#################################################################3
		$this->render( "penyedia/company/detail/content" );
	}

	public function edit( $company_id = null )
	{
		if ($company_id == NULL) redirect(site_url($this->current_page));
		$this->form_validation->set_rules( $this->services->validation_config() );

        if ($this->form_validation->run() === TRUE )
        {
			$data['name'] = $this->input->post( 'name' );
			$data['company_type'] = $this->input->post( 'company_type' );
			$data['company_cert'] = $this->input->post( 'company_cert' );
			$data['npwp'] = $this->input->post( 'npwp' );
			$data['postal_code'] = $this->input->post( 'postal_code' );
			$data['province'] = $this->input->post( 'province' );
			$data['city'] = $this->input->post( 'city' );
			$data['website'] = $this->input->post( 'website' );

			$data_param["id"] = $this->input->post( 'id' );

			if( $this->company_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->company_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->company_model->errors() ) );
			}
			redirect( site_url($this->current_page));
		}
        else
        {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->company_model->errors() ? $this->company_model->errors() : $this->session->flashdata('message')));
            if(  !empty( validation_errors() ) || $this->company_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

            $alert = $this->session->flashdata('alert');
			$this->data["key"] = $this->input->get('key', FALSE);
			$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
			$this->data["current_page"] = $this->current_page;
			$this->data["block_header"] = "Edit Perusahaan ";
			$this->data["header"] = "Edit Perusahaan ";
			$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

            $form_data = $this->services->get_form_data($company_id);
			$form_data['form_data']['npwp']['type'] = 'number';
			$form_data['form_data']['postal_code']['type'] = 'number';

            $form = array(
                'name' => 'province_1',
                'id' => 'province_1',
                'type' => 'text',
                'class' => 'form-control',  
                'style' => 'display: none',  
				'value' => $form_data['form_data']['province']['value'],
            );
			$extra_html = form_input( $form );
            $form = array(
                'name' => 'city_1',
                'id' => 'city_1',
                'type' => 'text',
                'class' => 'form-control',  
                'style' => 'display: none',  
				'value' => $form_data['form_data']['city']['value'],
            );
			$extra_html .= form_input( $form );
            $form_data = $this->load->view('templates/form/plain_form', $form_data , TRUE ) ;
			$form_data.= $extra_html;
            $this->data[ "contents" ] =  $form_data;
            
			$this->render( "penyedia/company/edit/content" );
        }
	}

	public function company_permission( $company_id )
	{
		if( $this->input->post( 'delete' ) !== NULL ){
			$data_param['id'] 	= $this->input->post('id');
			if( $this->company_permission_model->delete( $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->company_permission_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->company_permission_model->errors() ) );
			}
			redirect(site_url( $this->current_page));
		}

		$data['company_id'] = $this->input->post( 'company_id' );
		$data['name'] = $this->input->post( 'name' );
		$data['cert_no'] = $this->input->post( 'cert_no' );
		$data['agency_from'] = $this->input->post( 'agency_from' );
		$data['qualification'] = $this->input->post( 'qualification' );

		$data_param["id"] = $this->input->post( 'id' );
		if($data_param["id"])
		{
			if( $this->company_permission_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->company_permission_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->company_permission_model->errors() ) );
			}
		}
		else
		{
			if( $this->company_permission_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->company_permission_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->company_permission_model->errors() ) );
			}
		}
		
		redirect(site_url( $this->current_page));
	}

	public function acta( $company_id )
	{
		if( $this->input->post( 'delete' ) !== NULL ){
			$data_param['id'] 	= $this->input->post('id');
			if( $this->acta_model->delete( $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->acta_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->acta_model->errors() ) );
			}
			redirect(site_url( $this->current_page));
		}

		$data['company_id'] = $this->input->post( 'company_id' );
		$data['name'] = $this->input->post( 'name' );
		$data['date'] = $this->input->post( 'date' );
		$data['notary'] = $this->input->post( 'notary' );
		$data['desc'] = $this->input->post( 'desc' );

		$data_param["id"] = $this->input->post( 'id' );
		if($data_param["id"])
		{
			if( $this->acta_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->acta_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->acta_model->errors() ) );
			}
		}
		else
		{
			if( $this->acta_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->acta_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->acta_model->errors() ) );
			}
		}
		
		redirect(site_url( $this->current_page));
	}

	public function ownership( $company_id )
	{
		if( $this->input->post( 'delete' ) !== NULL ){
			$data_param['id'] 	= $this->input->post('id');
			if( $this->ownership_model->delete( $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->ownership_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->ownership_model->errors() ) );
			}
			redirect(site_url( $this->current_page));
		}

		$data['company_id'] = $this->input->post( 'company_id' );
		$data['name'] = $this->input->post( 'name' );
		$data['id_number'] = $this->input->post( 'id_number' );
		$data['address'] = $this->input->post( 'address' );
		$data['shared'] = $this->input->post( 'shared' );
		$data['unit'] = $this->input->post( 'unit' );

		$data_param["id"] = $this->input->post( 'id' );
		if($data_param["id"])
		{
			if( $this->ownership_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->ownership_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->ownership_model->errors() ) );
			}
		}
		else
		{
			if( $this->ownership_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->ownership_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->ownership_model->errors() ) );
			}
		}
		
		redirect(site_url( $this->current_page));
	}

	public function expert( $company_id )
	{
		if( $this->input->post( 'delete' ) !== NULL ){
			$data_param['id'] 	= $this->input->post('id');
			if( $this->expert_model->delete( $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->expert_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->expert_model->errors() ) );
			}
			redirect(site_url( $this->current_page));
		}

		$data['company_id'] = $this->input->post( 'company_id' );
		$data['name'] = $this->input->post( 'name' );
		$data['birthday'] = $this->input->post( 'birthday' );
		$data['address'] = $this->input->post( 'address' );
		$data['last_study'] = $this->input->post( 'last_study' );
		$data['email'] = $this->input->post( 'email' );
		$data['experience'] = $this->input->post( 'experience' );
		$data['skill'] = $this->input->post( 'skill' );
		$data['npwp'] = $this->input->post( 'npwp' );
		$data['sex'] = $this->input->post( 'sex' );
		$data['nationality'] = $this->input->post( 'nationality' );
		$data['status'] = $this->input->post( 'status' );
		$data['position'] = $this->input->post( 'position' );

		$data_param["id"] = $this->input->post( 'id' );
		if($data_param["id"])
		{
			if( $this->expert_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->expert_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->expert_model->errors() ) );
			}
		}
		else
		{
			if( $this->expert_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->expert_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->expert_model->errors() ) );
			}
		}
		
		redirect(site_url( $this->current_page));
	}

	public function tool( $company_id )
	{
		if( $this->input->post( 'delete' ) !== NULL ){
			$data_param['id'] 	= $this->input->post('id');
			if( $this->tool_model->delete( $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tool_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tool_model->errors() ) );
			}
			redirect(site_url( $this->current_page));
		}

		$data['company_id'] = $this->input->post( 'company_id' );
		$data['name'] = $this->input->post( 'name' );
		$data['quantity'] = $this->input->post( 'quantity' );
		$data['capacity'] = $this->input->post( 'capacity' );
		$data['type'] = $this->input->post( 'type' );
		$data['condition'] = $this->input->post( 'condition' );
		$data['year'] = $this->input->post( 'year' );
		$data['location'] = $this->input->post( 'location' );
		$data['cert_no'] = $this->input->post( 'cert_no' );

		$data_param["id"] = $this->input->post( 'id' );
		if($data_param["id"])
		{
			if( $this->tool_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tool_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tool_model->errors() ) );
			}
		}
		else
		{
			if( $this->tool_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tool_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tool_model->errors() ) );
			}
		}
		
		redirect(site_url( $this->current_page));
	}

	public function experience( $company_id )
	{
		if( $this->input->post( 'delete' ) !== NULL ){
			$data_param['id'] 	= $this->input->post('id');
			if( $this->experience_model->delete( $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->experience_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->experience_model->errors() ) );
			}
			redirect(site_url( $this->current_page));
		}

		$data['company_id'] = $this->input->post( 'company_id' );
		$data['name'] = $this->input->post( 'name' );
		$data['location'] = $this->input->post( 'location' );
		$data['agency'] = $this->input->post( 'agency' );
		$data['address'] = $this->input->post( 'address' );
		$data['start_date'] = $this->input->post( 'start_date' );
		$data['end_date'] = $this->input->post( 'end_date' );
		

		$data_param["id"] = $this->input->post( 'id' );
		if($data_param["id"])
		{
			if( $this->experience_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->experience_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->experience_model->errors() ) );
			}
		}
		else
		{
			if( $this->experience_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->experience_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->experience_model->errors() ) );
			}
		}
		
		redirect(site_url( $this->current_page));
	}

	public function tax( $company_id )
	{
		if( $this->input->post( 'delete' ) !== NULL ){
			$data_param['id'] 	= $this->input->post('id');
			if( $this->tax_model->delete( $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tax_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tax_model->errors() ) );
			}
			redirect(site_url( $this->current_page));
		}

		$data['company_id'] = $this->input->post( 'company_id' );
		$data['name'] = $this->input->post( 'name' );
		$data['date'] = $this->input->post( 'date' );
		$data['cert_no'] = $this->input->post( 'cert_no' );
		

		$data_param["id"] = $this->input->post( 'id' );
		if($data_param["id"])
		{
			if( $this->tax_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tax_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tax_model->errors() ) );
			}
		}
		else
		{
			if( $this->tax_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tax_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tax_model->errors() ) );
			}
		}
		
		redirect(site_url( $this->current_page));
	}
}
