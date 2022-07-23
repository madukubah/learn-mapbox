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
			'comment_model',
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
		$table[ "rows" ] = $this->tender_model
			->where('status', 'Tayang')
			->tenders( $pagination['start_record'], $pagination['limit_per_page'] )->result();
		for ($i=0; $i < count($table[ "rows" ]); $i++) { 
			$table[ "rows" ][$i]->year = $table[ "rows" ][$i]->year." ";
		}
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
		$this->data["block_header"] = "Tender ";
		$this->data["header"] = "Tender";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}

	public function detail( $tender_id = null )
    {
		$tender_id = base64_decode($tender_id);
		if ($tender_id == NULL) redirect(site_url($this->current_page));
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->tender_model->errors() ? $this->tender_model->errors() : $this->session->flashdata('message')));
		if(  !empty( validation_errors() ) || $this->tender_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		$tender = $this->tender_model->tender( $tender_id )->row();
		$this->data[ "tender" ] =  $tender;

		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = " ";
		$this->data["header"] = "Detail Paket Tender Terumumkan ";
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
		foreach( $tender_penyedia_table[ "rows" ] as $row )
		{
			$row->company_id = base64_encode($row->company_id);
		}
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

		$comments = $this->comment_model
			->select('
				comment.*,
				concat(users.first_name, " ", users.last_name) as user_name
			')
			->join(
				'users',
				'users.id = comment.user_id',
				'left'
			)
			->where('tender_id', $tender_id)
			->comments()
			->result();
		$this->data[ "comments" ] =  $comments;
		$this->render( "pt/tender/detail/content" );
	}
    
    
	public function edit( $tender_id = null )
	{
		$tender_id = base64_decode($tender_id);
		if ($tender_id == NULL) redirect(site_url($this->current_page));
		$this->form_validation->set_rules( $this->services->validation_config() );
        $paket_id = $this->input->post( 'paket_id' );
        if ($this->form_validation->run() === TRUE )
        {
			$data['status'] = $this->input->post( 'status' );

			$data_param["id"] = $tender_id;

			if( $this->tender_model->update( $data, $data_param ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tender_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tender_model->errors() ) );
			}
			
		}
        else
        {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->tender_model->errors() ? $this->tender_model->errors() : $this->session->flashdata('message')));
            if(  !empty( validation_errors() ) || $this->tender_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

            $alert = $this->session->flashdata('alert');
        }
        redirect( site_url('pt/paket/detail/'.$paket_id));
	}
	
	public function schedule( $tender_id )
	{
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
		
		redirect(site_url( $this->current_page.'detail/'.base64_encode($tender_id) ));
	}

	public function upload_file( $tender_id = NULL )
	{
		if ($tender_id == NULL) redirect(site_url($this->current_page));

		$this->load->library('upload'); // Load librari upload
		
		$filename = "TENDER_".time();
		$upload_path = 'uploads/tender/';

		$config['upload_path'] = './'.$upload_path;
		$config['image_path'] = base_url().$upload_path;
		$config['allowed_types'] = "pdf|docx";
		$config['overwrite']="true";
		$config['max_size']="2048";
		$config['file_name'] = ''.$filename;
		$data = array();
		$this->upload->initialize($config);
		foreach($_FILES as $key => $value){
			if( $_FILES[$key]["name"] != '' ){
				if ( $this->upload->do_upload($key) ) {
					$data[$key] = $this->upload->data()["file_name"];

					$tender = $this->tender_model->tender( $tender_id )->row();
					if (!@unlink($config['upload_path'] . $tender->$key )) { };

					$data_param["id"] = $tender_id;

					if( $this->tender_model->update( $data, $data_param ) ){
						$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tender_model->messages() ) );
					}else{
						$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tender_model->errors() ) );
					}
				}else {
					$this->session->set_flashdata('alert', $this->alert->set_alert(Alert::DANGER, $this->upload->display_errors()));
				}
			}
		}
		redirect(site_url( $this->current_page.'detail/'.base64_encode($tender_id) ));
	}

	public function tender_penyedia( $tender_id )
	{
		// $data['tender_id'] = $tender_id;
		// $data['penyedia_id'] = $this->input->post( 'penyedia_id' );
		$data['administration'] = $this->input->post( 'administration' ) == 'on';
		$data['technical'] = $this->input->post( 'technical' ) == 'on';
		$data['budget'] = $this->input->post( 'budget' ) == 'on';
		$data['position'] = $this->input->post( 'position' );
		
		// echo var_dump($data);
		// die;

		$data_param["tender_id"] = $tender_id;
		$data_param["penyedia_id"] = $this->input->post( 'penyedia_id' );

		if( $this->tender_penyedia_model->update( $data, $data_param ) ){
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tender_penyedia_model->messages() ) );
		}else{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tender_penyedia_model->errors() ) );
		}
		
		redirect(site_url( $this->current_page.'detail/'.base64_encode($tender_id) ));
	}

	public function comment( $tender_id )
	{
		$user_id = $this->ion_auth->get_user_id();

		$data['tender_id'] = $tender_id;
		$data['content'] = $this->input->post( 'content' );
		$data['user_id'] = $user_id;
		$data['datetime'] = date('Y-m-d H:i:s');
		

		if( $data['content'] == '' )
			redirect(site_url( $this->current_page.'detail/'.base64_encode($tender_id) ));

		if( $this->comment_model->create( $data ) ){
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->comment_model->messages() ) );
		}else{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->comment_model->errors() ) );
		}
		
		redirect(site_url( $this->current_page.'detail/'.base64_encode($tender_id) ));
	}
}
