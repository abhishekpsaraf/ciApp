<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_api extends CI_Controller {
function index()
 {
  $this->load->view('api_view');
 }
 
 function action()
 {
    if($this->input->post('data_action'))
    {
        $data_action = $this->input->post('data_action');
        if($data_action == "fetch_all")
        {
            $api_url =  base_url()."index.php/api";
 
            $client = curl_init($api_url);
        
            curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        
            $response = curl_exec($client);

            curl_close($client);
        
            $result = json_decode($response);
        
            $output = '';

            if(count($result) > 0)
            {
            foreach($result as $row)
            {   
                $checked = "";
                $checked = ($row->item_status)  ? "checked" : "";
                $itemName = ($row->item_status) ? "<del>$row->item_name</del>" : $row->item_name;
                $output .= '
                <tr>
                <td><input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" '.$checked.'> '.$itemName.'</td>
                <td><butto type="button" name="edit" class="btn btn-warning btn-xs edit" id="'.$row->item_id.'">Edit</button></td>
                <td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row->item_id.'">Delete</button></td>
                </tr>

            ';
            }
            }
            else
            {
                $output .= '
                <tr>
                <td colspan="4" align="center">No Data Found</td>
                </tr>
                ';
            }

            echo $output;
        }

        if($data_action == "Insert")
        {
            $api_url = base_url()."index.php/api/insert";

            $form_data = array(
            'item_name'  => $this->input->post('item_name'),
            'item_completed'  => $this->input->post('item_completed')
            );

            $client = curl_init($api_url);

            curl_setopt($client, CURLOPT_POST, true);

            curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

            curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($client);

            curl_close($client);

            echo $response;
        }

        if($data_action == "fetch_single")
        {
            $api_url = base_url()."index.php/api/fetch_single";

            $form_data = array(
            'id'  => $this->input->post('item_id')
            );

            $client = curl_init($api_url);

            curl_setopt($client, CURLOPT_POST, true);

            curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

            curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($client);

            curl_close($client);

            echo $response;

        }

        if($data_action == "Edit")
        {
            $api_url = base_url()."index.php/api/update";

            $form_data = array(
            'item_name'  => $this->input->post('item_name'),
            'item_completed'  => $this->input->post('item_completed'),
            'item_id'    => $this->input->post('item_id')
            );

            $client = curl_init($api_url);

            curl_setopt($client, CURLOPT_POST, true);

            curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

            curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($client);

            curl_close($client);

            echo $response;

        }

        if($data_action == "Delete")
        {
            $api_url = base_url()."index.php/api/delete";

            $form_data = array(
            'id'  => $this->input->post('item_id')
            );

            $client = curl_init($api_url);

            curl_setopt($client, CURLOPT_POST, true);

            curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

            curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($client);

            curl_close($client);

            echo $response;

        }

        
    }
 }

}
?>