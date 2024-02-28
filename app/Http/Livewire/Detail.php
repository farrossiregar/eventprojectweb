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

        $creator_event = Event::where('user_id', $data->first()->user_id)->orderBy('id', 'desc');
        // dd($creator_event->get());
        
        // if(\Auth::user()->user_access_id==1){
        //     $user = Auth::user();
            // $this->supplier = Supplier::orderBy('id','DESC')->take(5)->get();
            // $this->buyer = Buyer::orderBy('id','DESC')->take(5)->get();
            // dd('dev');
            return view('livewire.detail')->with(['data'=>$data->first(), 'creator_event'=>$creator_event->get()]);
        // } 
        
    }

    public function mount($id)
    {
        $this->alias = $id;
    }
}