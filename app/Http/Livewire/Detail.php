<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;
use App\Models\Supplier;
use App\Models\Event;

class Detail extends Component
{
    public $supplier, $buyer;

    public function render()
    { 
        $data = Event::where('event_url', $this->alias);
        
        // if(\Auth::user()->user_access_id==1){
        //     $user = Auth::user();
            // $this->supplier = Supplier::orderBy('id','DESC')->take(5)->get();
            // $this->buyer = Buyer::orderBy('id','DESC')->take(5)->get();
            // dd('dev');
            return view('livewire.detail')->with(['data'=>$data->first()]);
        // } 
        
    }

    public function mount($id)
    {
        $this->alias = $id;
    }
}