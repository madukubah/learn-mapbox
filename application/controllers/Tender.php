<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tender extends Public_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'pt';
	private $current_page = 'pt/tender/';
	
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

	public function detail( $tender_id = null )
    {
		if ($tender_id == NULL) redirect(site_url($this->current_page));
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->tender_model->errors() ? $this->tender_model->errors() : $this->session->flashdata('message')));
		if(  !empty( validation_errors() ) || $this->tender_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Detail Tender ";
		$this->data["header"] = "Detail Tender ";
		$this->data["sub_header"] = 'Klik Tombol Aksi Untuk Ikut Tender';

		$form_data = $this->services->get_form_data( $tender_id );
		$form_data = $this->load->view('templates/form/plain_form_readonly', $form_data , TRUE ) ;

		$link_register_tender = 
		array(
			"name" => "Ikut Tender",
			"type" => "link",
			"url" => site_url( "penyedia/tender/register/".$tender_id),
			"button_color" => "success",	
			"data" => NULL,
		);
		$this->data[ "header_button" ] =  $this->load->view('templates/actions/link', $link_register_tender, TRUE );

		$this->data[ "contents" ] =  $form_data;
		$this->render( "tender" );
	}

}
