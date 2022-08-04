<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Pjp_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'pjp';
	private $current_page = 'pjp/';
	public function __construct(){
		parent::__construct();

		redirect(site_url('/pjp/tender?status=Rencana'));

		$this->load->model(array(
			'paket_model',
		));
		$this->data[ "parent_page" ] =  $this->parent_page;

	}
	public function index()
	{
		$year = $this->input->get("year", TRUE );
		$year || $year = date('Y');
		$form_filter["form_data"] = array(
				"year" => array(
						'type' => 'select',
						'label' => "Year",
						'options' => array(
							2019 => "2019",
							2020 => "2020",
							2021 => "2021",
							2022 => "2022",
						),
						'selected' => $year
				),
		);
		$this->data[ "paket" ] = $this->paket_model->pakets( 0, null, $year)->result();

		$form_filter = $this->load->view('pjp/dashboard/form_filter', $form_filter, TRUE);
		$this->data[ "form_filter" ] = $form_filter;
		$this->render( "pjp/dashboard/content" );
	}
}
