<?php 
class Api_model extends CI_Model
{
function fetch_all()
 {
  $this->db->order_by('item_status', 'ASC');
  return $this->db->get('tbl_items');
 }
 function insert_api($data)
 {
  $this->db->insert('tbl_items', $data);
  if($this->db->affected_rows() > 0)
  {
   return true;
  }
  else
  {
   return false;
  }
 }

 function fetch_single_item($item_id)
 {
  $this->db->where("item_id", $item_id);
  $query = $this->db->get('tbl_items');
  return $query->result_array();
 }

 function update_api($item_id, $data)
 {
  $this->db->where("item_id", $item_id);
  $this->db->update("tbl_items", $data);
 }

 function delete_single_item($item_id)
 {
  $this->db->where("item_id", $item_id);
  $this->db->delete("tbl_items");
  if($this->db->affected_rows() > 0)
  {
   return true;
  }
  else
  {
   return false;
  }
 }
}
?>