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
		// echo json_encode( $this->data[ "paket" ]);die;
		$this->render( "uadmin/dashboard/content" );
	}
}
