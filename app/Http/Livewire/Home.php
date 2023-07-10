<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;
use App\Models\Supplier;
use App\Models\Buyer;

class Home extends Component
{
    public $supplier, $buyer;

    public function render()
    { 
        /**
         * if kasir
         */
        if(\Auth::user()->user_access_id==7){
            redirect()->route('supplier.index');
        } 
        
        if(\Auth::user()->user_access_id==8){
            redirect()->route('buyer.index');
        } 
        
        // if(\Auth::user()->user_access_id==1){
        //     $user = Auth::user();
            // $this->supplier = Supplier::orderBy('id','DESC')->take(5)->get();
            // $this->buyer = Buyer::orderBy('id','DESC')->take(5)->get();

            return view('livewire.home');
        // } 
        
    }
}