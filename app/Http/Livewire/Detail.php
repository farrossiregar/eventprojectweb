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
        $data = Event::select('event.*', 'creator.creator_company', 'creator.creator_address')->where('event.event_url', $this->alias)->join('creator', 'creator.id', '=', 'event.user_id');

        $creator_event = Event::where('user_id', $data->first()->user_id)->orderBy('event.id', 'desc');
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