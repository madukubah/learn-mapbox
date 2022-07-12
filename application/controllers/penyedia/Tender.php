<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tender extends User_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'penyedia';
	private $current_page = 'penyedia/tender/';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('services/Tender_services');
		$this->services = new Tender_services;

		$this->load->library('services/Draft_tender_services');
		$this->draft_tender_services = new Draft_tender_services;

		$this->load->model(array(
			'tender_model',
			'draft_tender_model',
			'tender_penyedia_model',
			'schedule_model',
		));
	}	

	public function index(  )
	{
		// 
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		//pagination parameter
		$pagination['base_url'] = site_url( $this->current_page ) .'/index';
		$pagination['total_records'] = $this->tender_model->record_count() ;
		$pagination['limit_per_page'] = 10;
		$pagination['start_record'] = $page*$pagination['limit_per_page'];
		$pagination['uri_segment'] = 4;
		//set pagination
		if ($pagination['total_records']>0) $this->data['pagination_links'] = $this->setPagination($pagination);

		$table = $this->services->get_table_config( $this->current_page );
		unset($table['action'][2]);
		unset($table['action'][1]);
		$table[ "rows" ] = $this->tender_model->tenders( $pagination['start_record'], $pagination['limit_per_page'] )->result();
		for ($i=0; $i < count($table[ "rows" ]); $i++) { 
			$table[ "rows" ][$i]->year = $table[ "rows" ][$i]->year." ";
		}
		$table = $this->load->view('templates/tables/plain_table', $table, true);
		$this->data[ "contents" ] = $table;

		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Tender";
		$this->data["header"] = "Tender";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}

	public function register( $tender_id = NULL )
	{
		if ($tender_id == NULL) redirect(site_url($this->current_page));

		$user_id = $this->ion_auth->get_user_id();

		$data['tender_id'] = $tender_id;
		$data['penyedia_id'] = $user_id;
		
		if( $this->tender_penyedia_model->create( $data ) ){
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tender_penyedia_model->messages() ) );
		}else{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tender_penyedia_model->errors() ) );
		}
		redirect( site_url($this->current_page.'detail/'.$tender_id));
	}

	public function effering_file( $tender_penyedia_id = NULL )
	{
		if ($tender_penyedia_id == NULL) redirect(site_url($this->current_page));

		$this->load->library('upload'); // Load librari upload
		
		$filename = "Penawaran_".time();
		$upload_path = 'uploads/tender/';
	
		$config['upload_path'] = './'.$upload_path;
		$config['image_path'] = base_url().$upload_path;
		$config['allowed_types'] = "pdf";
		$config['overwrite']="true";
		$config['max_size']="2048";
		$config['file_name'] = ''.$filename;

		$this->upload->initialize($config);
		
		if( isset($_FILES["effering_file"] ) && $_FILES["effering_file"]["name"] != '' ){
				
			if ( $this->upload->do_upload("effering_file") ) {
				$data['effering_file'] = $this->upload->data()["file_name"];

				$tender_penyedia = $this->tender_penyedia_model->tender_penyedia( $tender_penyedia_id )->row();
				if (!@unlink($config['upload_path'] . $tender_penyedia->effering_file )) { };
			}else {
				$this->session->set_flashdata('alert', $this->alert->set_alert(Alert::DANGER, $this->upload->display_errors()));
			}
		}
		$data['tender_id'] = $this->input->post( 'tender_id' );
		$data_param["id"] = $tender_penyedia_id;

		if( $this->tender_penyedia_model->update( $data, $data_param ) ){
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tender_penyedia_model->messages() ) );
		}else{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tender_penyedia_model->errors() ) );
		}
		redirect( site_url($this->current_page.'detail/'.$data['tender_id']));
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
		$this->data["block_header"] = "Tender ";
		$this->data["header"] = "Tender ";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

		$form_data = $this->services->get_form_data( $tender_id );
		$form_data = $this->load->view('templates/form/plain_form_readonly', $form_data , TRUE ) ;

		$draft_tender = $this->draft_tender_model
			->where('tender_id', $tender_id)
			->draft_tender()
			->row();
		$form_data_draft_tender = $this->draft_tender_services->get_form_data( $draft_tender->id );
		unset($form_data_draft_tender['form_data']['name']);
		unset($form_data_draft_tender['form_data']['status']);
		$form_data_draft_tender = $this->load->view('pt/paket/detail/plain_form_readonly', $form_data_draft_tender , TRUE ) ;

		$link_register_tender = 
		array(
			"name" => "Ikut Tender",
			"type" => "link",
			"url" => site_url( "penyedia/tender/register/".$tender_id),
			"button_color" => "success",	
			"data" => NULL,
		);

		$user_id = $this->ion_auth->get_user_id();
		$tender_penyedia = $this->tender_penyedia_model
			->where('penyedia_id', $user_id )
			->where('tender_id', $tender_id )
			->tender_penyedia()
			->row();
		if( !$tender_penyedia )
			$this->data[ "header_button" ] =  $this->load->view('templates/actions/link', $link_register_tender, TRUE );

		$tender_penyedia_table["header"] = array(
			'name' => 'Nama',
		);
		$tender_penyedia_table["number"] = 1;
		$tender_penyedia_table["rows"] = $this->tender_penyedia_model
			->select('	tender_penyedia.*, 
					company.name,
				')
			->where('tender_id', $tender_id )
			->join(
				"users",
				"users.id = tender_penyedia.penyedia_id",
				"inner")
			->join(
				"company",
				"company.user_id = users.id",
				"inner")
			->tender_penyedias()
			->result();
		$tender_penyedia_table['user_id'] = $user_id;
		$tender_penyedia_table = $this->load->view('penyedia/tender/detail/plain_table', $tender_penyedia_table, true);
		$this->data[ "contents" ] =  $form_data.$form_data_draft_tender;
		$this->data[ "contents_2" ] =  $tender_penyedia_table;
		$schedule = $this->schedule_model
			->where('tender_id', $tender_id)
			->schedule()
			->row();
		$schedule_id = '';
		$schedule_table = $this->load->view('penyedia/tender/detail/schedule_table', array('schedule' => $schedule,'tender_id' => $tender_id ), true);
		$this->data[ "contents_3" ] =  $schedule_table;
		$this->render( "penyedia/tender/detail/content" );
	}

}
