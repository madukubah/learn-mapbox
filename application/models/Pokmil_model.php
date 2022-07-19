<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pokmil_model extends MY_Model
{
  protected $table = "pokmil";

  function __construct() {
      parent::__construct( $this->table );
      parent::set_join_key( 'pokmil_id' );
  }

  /**
   * create
   *
   * @param array  $data
   * @return static
   * @author madukubah
   */
  public function create( $data )
  {
      // Filter the data passed
      $data = $this->_filter_data($this->table, $data);

      $this->db->insert($this->table, $data);
      $id = $this->db->insert_id($this->table . '_id_seq');
    
      if( isset($id) )
      {
        $this->set_message("pokmil baru berhasil ditambah");
        return $id;
      }
      $this->set_error("gagal");
          return FALSE;
  }
  /**
   * update
   *
   * @param array  $data
   * @param array  $data_param
   * @return bool
   * @author madukubah
   */
  public function update( $data, $data_param  )
  {
    $this->db->trans_begin();
    $data = $this->_filter_data($this->table, $data);

    $this->db->update($this->table, $data, $data_param );
    if ($this->db->trans_status() === FALSE)
    {
      $this->db->trans_rollback();

      $this->set_error("gagal");
      return FALSE;
    }

    $this->db->trans_commit();

    $this->set_message("Pokmil berhasil diupdate");
    return TRUE;
  }
  /**
   * delete
   *
   * @param array  $data_param
   * @return bool
   * @author madukubah
   */
  public function delete( $data_param  )
  {
    //foreign
    //delete_foreign( $data_param. $models[]  )
    if( !$this->delete_foreign( $data_param, [] ) )
    {
      $this->set_error("gagal");//('pokmil_delete_unsuccessful');
      return FALSE;
    }
    //foreign
    $this->db->trans_begin();

    $this->db->delete($this->table, $data_param );
    if ($this->db->trans_status() === FALSE)
    {
      $this->db->trans_rollback();

      $this->set_error("gagal");//('pokmil_delete_unsuccessful');
      return FALSE;
    }

    $this->db->trans_commit();

    $this->set_message("Pokmil berhasil dihapus");//('pokmil_delete_successful');
    return TRUE;
  }

    /**
   * pokmil
   *
   * @param int|array|null $id = id_pokmils
   * @return static
   * @author madukubah
   */
  public function pokmil( $id = NULL  )
  {
      if (isset($id))
      {
        $this->where($this->table.'.id', $id);
      }

      $this->limit(1);
      $this->order_by($this->table.'.id', 'desc');

      $this->pokmils(  );

      return $this;
  }
  /**
   * pokmils
   *
   *
   * @return static
   * @author madukubah
   */
  public function pokmils( $start = 0 , $limit = NULL, $year = NULL )
  {
      if (isset( $year ))
      {
        $start = $year."-01-01";
        $end = $year."-12-31";
        $this->where( "start_date >=", $start );
        $this->where( "end_date <=", $end );
      }

      if (isset( $limit ))
      {
        $this->limit( $limit );
      }
      $this->offset( $start );
      $this->order_by($this->table.'.id', 'desc');
      return $this->fetch_data();
  }

}
?>
