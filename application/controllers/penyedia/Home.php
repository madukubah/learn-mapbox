<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends User_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'user';
	private $current_page = 'user/';
	public function __construct(){
		parent::__construct();
		redirect(site_url('/penyedia/tender'));

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

		$form_filter = $this->load->view('uadmin/dashboard/form_filter', $form_filter, TRUE);
		$this->data[ "form_filter" ] = $form_filter;
		$this->render( "uadmin/dashboard/content" );
	}
}
