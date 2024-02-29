<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;
// use App\Models\Supplier;
use App\Models\Event;
use App\Models\EventTransaksi;
use App\Models\Tiket;
use App\Models\Buyer;

class TicketPurchase extends Component
{
    public $supplier, $buyer;
    public $buyer_name, $buyer_nik, $buyer_email, $buyer_phone, $amount, $payment_method, $total_price;

    public function render()
    { 
        $data = Event::where('event_url', $this->alias);
        

        if($this->amount){
            $this->total_price = $this->amount * $data->first()->event_price;
        }else{
            $this->total_price = $data->first()->event_price * 2;
        }
        // if(\Auth::user()->user_access_id==1){
        //     $user = Auth::user();
            // $this->supplier = Supplier::orderBy('id','DESC')->take(5)->get();
            // $this->buyer = Buyer::orderBy('id','DESC')->take(5)->get();
            // dd('dev');
            return view('livewire.ticket-purchase')->with(['data'=>$data->first()]);
        // } 
        
    }

    public function mount($id)
    {
        $this->alias = $id;
    }

    public function purchase(){
        dd('test submit');
        $checkBuyer = Buyer::where('nama_buyer', $this->buyer_name)->first();
        if(!$checkBuyer){
            $insertBuyer = new Buyer();
            $insertBuyer->nama_buyer = $this->buyer_name;
            $insertBuyer->email = $this->buyer_email;
            $insertBuyer->alamat_buyer = '';
            $insertBuyer->no_telp = $this->buyer_phone;
            $insertBuyer->save();

            $id_buyer = $insertBuyer->id;
        }else{
            $id_buyer = $checkBuyer->id;
        }

        $insertTransaksi = new Transaksi();
        $insertTransaksi->transaction_no = 'TRX';
        $insertTransaksi->buyer_name = $this->buyer_name;
        // $insertTransaksi->buyer_nik = $buyer_name;
        $insertTransaksi->buyer_email = $this->buyer_email;
        $insertTransaksi->buyer_phone = $this->buyer_phone;
        $insertTransaksi->amount = $this->amount;
        // $insertTransaksi->amount = $this->amount;
        $insertTransaksi->save();

        

        for($i = 1; $i <= $this->amount; $i++){
            $insertTiket = new Tiket();
            $insertTiket->id_buyer = $id_buyer;
            $insertTiket->kode_tiket = $id_buyer;
            $insertTiket->id_transaction = $id_buyer;
            
            $insertTiket->save();
        }
        
    }

}