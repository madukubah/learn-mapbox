<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tender extends User_Controller {
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
			'tender_penyedia_model',
			'schedule_model',
		));
	}	

	public function index(  )
	{
		// 
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		//pagination parameter
		$pagination['base_url'] = base_url( $this->current_page ) .'/index';
		$pagination['total_records'] = $this->tender_model->record_count() ;
		$pagination['limit_per_page'] = 10;
		$pagination['start_record'] = $page*$pagination['limit_per_page'];
		$pagination['uri_segment'] = 4;
		//set pagination
		if ($pagination['total_records']>0) $this->data['pagination_links'] = $this->setPagination($pagination);

		$table = $this->services->get_table_config( $this->current_page );
		unset($table['action'][2]);
		unset($table['action'][1]);
		$table[ "rows" ] = $this->tender_model
			->where('status', 'Tayang')
			->tenders( $pagination['start_record'], $pagination['limit_per_page'] )->result();
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

		$tender_penyedia_table["header"] = array(
			'name' => 'Nama',
		);
		$tender_penyedia_table["number"] = 1;
		$tender_penyedia_table["rows"] = $this->tender_penyedia_model
			->select('	tender_penyedia.*, 
					company.*,
					company.id as company_id,
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
		$tender_penyedia_table = $this->load->view('pt/tender/detail/plain_table', $tender_penyedia_table, true);

		$this->data[ "contents" ] =  $form_data.$form_data_draft_tender;
		$this->data[ "contents_2" ] =  $tender_penyedia_table;
		$schedule = $this->schedule_model
			->where('tender_id', $tender_id)
			->schedule()
			->row();
		$schedule_id = '';
		$schedule_table = $this->load->view('pt/tender/detail/schedule_table', array('schedule' => $schedule,'tender_id' => $tender_id ), true);
		$this->data[ "contents_3" ] =  $schedule_table;
		$this->render( "pt/tender/detail/content" );
	}

	public function schedule( $tender_id )
	{
		if( $this->input->post( 'delete' ) !== NULL ){
			$data_param['id'] 	= $this->input->post('id');
			if( $this->schedule_model->delete( $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->schedule_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->schedule_model->errors() ) );
			}
			redirect(site_url( $this->current_page.'detail/'.$company_id ));
		}

		$data['tender_id'] = $tender_id;
		$data['announcement_start_date'] = $this->input->post( 'announcement_start_date' ).' '.$this->input->post( 'announcement_start_time' );
		$data['announcement_end_date'] = $this->input->post( 'announcement_end_date' ).' '.$this->input->post( 'announcement_end_time' );
		$data['file_download_start_date'] = $this->input->post( 'file_download_start_date' ).' '.$this->input->post( 'file_download_start_time' );
		$data['file_download_end_date'] = $this->input->post( 'file_download_end_date' ).' '.$this->input->post( 'file_download_end_time' );
		$data['explanation_start_date'] = $this->input->post( 'explanation_start_date' ).' '.$this->input->post( 'explanation_start_time' );
		$data['explanation_end_date'] = $this->input->post( 'explanation_end_date' ).' '.$this->input->post( 'explanation_end_time' );
		$data['effering_file_upload_start_date'] = $this->input->post( 'effering_file_upload_start_date' ).' '.$this->input->post( 'effering_file_upload_start_time' );
		$data['effering_file_upload_end_date'] = $this->input->post( 'effering_file_upload_end_date' ).' '.$this->input->post( 'effering_file_upload_end_time' );
		$data['proof_offering_start_date'] = $this->input->post( 'proof_offering_start_date' ).' '.$this->input->post( 'proof_offering_start_time' );
		$data['proof_offering_end_date'] = $this->input->post( 'proof_offering_end_date' ).' '.$this->input->post( 'proof_offering_end_time' );
		$data['evaluation_start_date'] = $this->input->post( 'evaluation_start_date' ).' '.$this->input->post( 'evaluation_start_time' );
		$data['evaluation_end_date'] = $this->input->post( 'evaluation_end_date' ).' '.$this->input->post( 'evaluation_end_time' );
		$data['proof_qualification_start_date'] = $this->input->post( 'proof_qualification_start_date' ).' '.$this->input->post( 'proof_qualification_start_time' );
		$data['proof_qualification_end_date'] = $this->input->post( 'proof_qualification_end_date' ).' '.$this->input->post( 'proof_qualification_end_time' );
		$data['winner_settle_start_date'] = $this->input->post( 'winner_settle_start_date' ).' '.$this->input->post( 'winner_settle_start_time' );
		$data['winner_settle_end_date'] = $this->input->post( 'winner_settle_end_date' ).' '.$this->input->post( 'winner_settle_end_time' );
		$data['winner_announcement_start_date'] = $this->input->post( 'winner_announcement_start_date' ).' '.$this->input->post( 'winner_announcement_start_time' );
		$data['winner_announcement_end_date'] = $this->input->post( 'winner_announcement_end_date' ).' '.$this->input->post( 'winner_announcement_end_time' );
		$data['interuption_start_date'] = $this->input->post( 'interuption_start_date' ).' '.$this->input->post( 'interuption_start_time' );
		$data['interuption_end_date'] = $this->input->post( 'interuption_end_date' ).' '.$this->input->post( 'interuption_end_time' );
		$data['choose_letter_start_date'] = $this->input->post( 'choose_letter_start_date' ).' '.$this->input->post( 'choose_letter_start_time' );
		$data['choose_letter_end_date'] = $this->input->post( 'choose_letter_end_date' ).' '.$this->input->post( 'choose_letter_end_time' );
		$data['signing_start_date'] = $this->input->post( 'signing_start_date' ).' '.$this->input->post( 'signing_start_time' );
		$data['signing_end_date'] = $this->input->post( 'signing_end_date' ).' '.$this->input->post( 'signing_end_time' );
		

		$data_param["id"] = $this->input->post( 'id' );
		if($data_param["id"])
		{
			if( $this->schedule_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->schedule_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->schedule_model->errors() ) );
			}
		}
		else
		{
			if( $this->schedule_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->schedule_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->schedule_model->errors() ) );
			}
		}
		
		redirect(site_url( $this->current_page.'detail/'.$tender_id ));
	}
}
