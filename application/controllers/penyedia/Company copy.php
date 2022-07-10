<?php
public function tax( $company_id )
{
	if( $this->input->post( 'delete' ) !== NULL ){
		$data_param['id'] 	= $this->input->post('id');
		if( $this->tax_model->delete( $data_param ) ){
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tax_model->messages() ) );
		}else{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tax_model->errors() ) );
		}
		redirect(site_url( $this->current_page.'detail/'.$company_id ));
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
	
	redirect(site_url( $this->current_page.'detail/'.$company_id ));
}