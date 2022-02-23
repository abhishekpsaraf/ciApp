<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller {

public function __construct()
 {
  parent::__construct();
  $this->load->model('api_model');
  $this->load->library('form_validation');
 }

 function index()
 {
  $data = $this->api_model->fetch_all();
  echo json_encode($data->result_array());
 }

 function insert()
 {
  $this->form_validation->set_rules("item_name", "Item Name", "required");
  $array = array();
  if($this->form_validation->run())
  {
   $data = array(
    'item_name' => trim($this->input->post('item_name')),
    'item_status'  => $this->input->post('item_completed')
   );
   $this->api_model->insert_api($data);
   $array = array(
    'success'  => true
   );
  }
  else
  {
   $array = array(
    'error'    => true,
    'item_name_error' => form_error('item_name')
   );
  }
  echo json_encode($array, true);
 }

 function fetch_single()
 {
  if($this->input->post('id'))
  {
   $data = $this->api_model->fetch_single_item($this->input->post('id'));
   foreach($data as $row)
   {
    $output['item_name'] = $row["item_name"];
    $output['item_status'] = $row["item_status"];
   }
   echo json_encode($output);
  }
 }

 function update()
 {
  $this->form_validation->set_rules("item_name", "Item Name", "required");
  $array = array();
  if($this->form_validation->run())
  {
   $data = array(
    'item_name' => trim($this->input->post('item_name')),
    'item_status'  => $this->input->post('item_completed')
   );
   $this->api_model->update_api($this->input->post('item_id'), $data);
   $array = array(
    'success'  => true
   );
  }
  else
  {
   $array = array(
    'error'    => true,
    'item_name_error' => form_error('item_name')
   );
  }
  echo json_encode($array, true);
 }

 function delete()
 {
  if($this->input->post('id'))
  {
   if($this->api_model->delete_single_item($this->input->post('id')))
   {
    $array = array(
     'success' => true
    );
   }
   else
   {
    $array = array(
     'error' => true
    );
   }
   echo json_encode($array);
  }
 }

}
?>