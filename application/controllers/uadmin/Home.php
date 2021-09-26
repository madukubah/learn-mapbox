<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Uadmin_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'uadmin';
	private $current_page = 'uadmin/';
	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'paket_model',
		));

	}
	public function index()
	{
		$this->data[ "paket" ] = $this->paket_model->pakets( )->result();
		
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
		$form_filter = $this->load->view('uadmin/dashboard/form_filter', $form_filter, TRUE);
		$this->data[ "form_filter" ] = $form_filter;
		$this->render( "uadmin/dashboard/content" );
	}
}
