<?php

function status_project($status){
    switch($status){
        case 1:
            return "Opportunity";
        break;
        case 2:
            return "Successful";
        break;
        case 3:
            return "Unsuccessful";
        break;
        default:
            return "Opportunity";
        break;
    }
}

function status_project_list(){
    $arr = [1=>'Opportunity',2=>"Successful",3=>"Unsuccessful"];
    return $arr;
}

function count_project_status($status){
    $count = \App\Models\Project::where('status',$status)->count();
    
    return $count;
}


function get_status_buyer($status){
    switch($status){
        case 1:
            $response = array(
                'badge' => 'info',
                'msg' => 'PO Submitted'
            );
            return $response;
        break;
        case 2:
            $response = array(
                'badge' => 'info',
                'msg' => 'Invoice Sent'
            );
            return $response;
        break;
        case 3:
            $response = array(
                'badge' => 'success',
                'msg' => 'Paid'
            );
            return $response;
        break;
        case 4:
            $response = array(
                'badge' => 'success',
                'msg' => 'On The Way'
            );
            return $response;
        break;
        case 5:
            $response = array(
                'badge' => 'success',
                'msg' => 'Received'
            );
            return $response;
        break;
        case 6:
            $response = array(
                'badge' => 'warning',
                'msg' => 'Refund Requested'
            );
            return $response;
        break;
        case 7:
            $response = array(
                'badge' => 'success',
                'msg' => 'Refund Approved'
            );
            return $response;
        break;
        case 8:
            $response = array(
                'badge' => 'danger',
                'msg' => 'Refund Decline'
            );
            return $response;
        break;
    }
}


function get_status_supplier($status){
    switch($status){
        case 0:
            $response = array(
                'badge' => 'warning',
                'msg' => 'Draft'
            );
            return $response;
        break;
        case 1:
            $response = array(
                'badge' => 'info',
                'msg' => 'Incoming PO'
            );
            return $response;
        break;
        case 2:
            $response = array(
                'badge' => 'warning',
                'msg' => 'Waiting for Payment'
            );
            return $response;
        break;
        case 3:
            $response = array(
                'badge' => 'success',
                'msg' => 'Paid'
            );
            return $response;
        break;
        case 4:
            $response = array(
                'badge' => 'success',
                'msg' => 'On The Way'
            );
            return $response;
        break;
        case 5:
            $response = array(
                'badge' => 'success',
                'msg' => 'Delivered'
            );
            // return '<span class="badge badge-success mr-0">Delivered</span>';
            return $response;
        break;
    }
}