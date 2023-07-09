<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Home extends Component
{
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
        
        return view('livewire.home');
    }
}