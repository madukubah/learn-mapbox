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

	public function detail( $company_id = null )
    {
		$company_id = base64_decode($company_id);
		if ($company_id == NULL) redirect(site_url($this->current_page));
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->company_model->errors() ? $this->company_model->errors() : $this->session->flashdata('message')));
		if(  !empty( validation_errors() ) || $this->company_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Detail Perusahaan";
		$this->data["header"] = "Detail Perusahaan";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

		$form_data = $this->services->get_form_data( $company_id );
		$form_data = $this->load->view('templates/form/plain_form_readonly', $form_data , TRUE ) ;
		$this->data[ "contents" ] =  $form_data;
		
		#############################################################################
		$company_permission_table = $this->services->get_company_permission_table_config( site_url( $this->current_page."company_permission/".$company_id) );
		unset($company_permission_table['action']);
		$company_permission_table['rows'] = $this->company_permission_model
			->where('company_id', $company_id)
			->company_permissions()
			->result();
		$company_permission_table = $this->load->view('templates/tables/plain_table', $company_permission_table, true);
		$company_permission_card = $this->load->view(
			'penyedia/company/detail/content_card_12', 
			array(
				'contents' => $company_permission_table,
				'header' => 'Ijin Perusahaan',
			), 
			true
		);		
		$this->data[ "company_permission_contents" ] = $company_permission_card;
		#############################################################################
		$acta_table = $this->services->get_acta_table_config( site_url( $this->current_page."acta/".$company_id) );
		unset($acta_table['action']);
		$acta_table['rows'] = $this->acta_model
			->where('company_id', $company_id)
			->actas()
			->result();
		$acta_table = $this->load->view('templates/tables/plain_table', $acta_table, true);
		$acta_card = $this->load->view(
			'penyedia/company/detail/content_card_12', 
			array(
				'contents' => $acta_table,
				'header' => 'Akta',
			), 
			true
		);		
		$this->data[ "acta_contents" ] = $acta_card;
		#############################################################################
		$ownership_table = $this->services->get_ownership_table_config( site_url( $this->current_page."ownership/".$company_id) );
		unset($ownership_table['action']);
		$ownership_table['rows'] = $this->ownership_model
			->where('company_id', $company_id)
			->ownerships()
			->result();
		$ownership_table = $this->load->view('templates/tables/plain_table', $ownership_table, true);
		$ownership_card = $this->load->view(
			'penyedia/company/detail/content_card_12', 
			array(
				'contents' => $ownership_table,
				'header' => 'Pemilik',
			), 
			true
		);		
		$this->data[ "ownership_contents" ] = $ownership_card;
		#############################################################################
		$expert_table = $this->services->get_expert_table_config( site_url( $this->current_page."expert/".$company_id) );
		unset($expert_table['action']);
		$expert_table['rows'] = $this->expert_model
			->where('company_id', $company_id)
			->experts()
			->result();
		$expert_table = $this->load->view('templates/tables/plain_table', $expert_table, true);
		$expert_card = $this->load->view(
			'penyedia/company/detail/content_card_12', 
			array(
				'contents' => $expert_table,
				'header' => 'Tenaga Ahli',
			), 
			true
		);		
		$this->data[ "expert_contents" ] = $expert_card;
		#############################################################################
		$tool_table = $this->services->get_tool_table_config( site_url( $this->current_page."tool/".$company_id) );
		unset($tool_table['action']);
		$tool_table['rows'] = $this->tool_model
			->where('company_id', $company_id)
			->tools()
			->result();
		$tool_table = $this->load->view('templates/tables/plain_table', $tool_table, true);
		$tool_card = $this->load->view(
			'penyedia/company/detail/content_card_12', 
			array(
				'contents' => $tool_table,
				'header' => 'Peralatan',
			), 
			true
		);		
		$this->data[ "tool_contents" ] = $tool_card;
		#############################################################################
		$experience_table = $this->services->get_experience_table_config( site_url( $this->current_page."experience/".$company_id) );
		unset($experience_table['action']);
		$experience_table['rows'] = $this->experience_model
			->where('company_id', $company_id)
			->experiences()
			->result();
		$experience_table = $this->load->view('templates/tables/plain_table', $experience_table, true);
		$experience_card = $this->load->view(
			'penyedia/company/detail/content_card_12', 
			array(
				'contents' => $experience_table,
				'header' => 'Pengalaman',
			), 
			true
		);		
		$this->data[ "experience_contents" ] = $experience_card;
		#############################################################################
		$tax_table = $this->services->get_tax_table_config( site_url( $this->current_page."tax/".$company_id) );
		unset($tax_table['action']);
		$tax_table['rows'] = $this->tax_model
			->where('company_id', $company_id)
			->taxs()
			->result();
		$tax_table = $this->load->view('templates/tables/plain_table', $tax_table, true);
		$tax_card = $this->load->view(
			'penyedia/company/detail/content_card_12', 
			array(
				'contents' => $tax_table,
				'header' => 'Pajak',
			), 
			true
		);
		$this->data[ "tax_contents" ] = $tax_card;
		#################################################################3
		$this->render( "penyedia/company/detail/content" );
	}

	
}
