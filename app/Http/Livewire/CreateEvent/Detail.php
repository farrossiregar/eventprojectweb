<?php

namespace App\Http\Livewire\CreateEvent;

use Livewire\Component;
use App\Models\Product;
use App\Models\SupplierProduct;
use App\Models\ProductStock;
use App\Models\TransaksiItem;
use App\Models\PurchaseOrderDetail;
use App\Models\SettingHarga;

class Detail extends Component
{
    public $data,$penjualan,$pembelian,$is_ppn,$harga,$harga_jual,$diskon,$ppn=0,$harga_produksi=0,$margin=0;
    public $price, $qty, $disc, $disc_p, $setting_harga, $insert=false;

    protected $listeners = ['reload-page'=>'$refresh'];
    public function render()
    {
        return view('livewire.product-supplier.detail');
    }

    public function mount(SupplierProduct $data)
    {
        $this->data = $data;
        $this->penjualan = PurchaseOrderDetail::where('product_id',$this->data->id)->get();
        $this->setting_harga = @SettingHarga::where('product_id',$this->data->id)->get();
        // dd($this->setting_harga);
        // dd($this->penjualan);
        // if($this->data->ppn==0) {
        //     $this->data->ppn = @$this->data->harga_jual * 0.11;
        //     $this->data->save();
        // }
        // $this->pembelian = ProductStock::where('product_id',$this->data->id)->get();
        $this->is_ppn = $this->data->is_ppn;
        $this->price = $this->data->price;
        $this->desc_product = $this->data->desc_product;
        // $this->harga_jual = $this->data->harga_jual;
        $this->diskon = $this->disc;

        if($this->qty){
            $this->disc = ceil(($this->price*$this->disc_p)/100);
        }

        // if($this->is_ppn==1 and $this->harga){
        //     $this->ppn = $this->harga * 0.11;
        // }
        // // Harga Produksi
        // if($this->harga>0) $this->harga_produksi = $this->harga + $this->ppn;
        // // Margin
        // if($this->harga_jual>0 && $this->harga_produksi>0) $this->margin = $this->harga_jual  - $this->harga_produksi; 
        // if($this->diskon>0 and $this->margin>0) $this->margin = $this->margin - $this->diskon;
    }

    public function updated($propertyName)
    {
        if($this->is_ppn==1 and $this->harga){
            $this->ppn = $this->harga * 0.11;
        }else{
            $this->ppn = 0;
        }

        if($this->qty){
            // if($this->disc_p){
            //     $this->disc = $this->price - ceil(((int)$this->price*(int)$this->disc_p)/100);
            // }

            if($this->disc){
                $this->disc_p = ceil(((int)$this->disc/(int)$this->price)*100);
            }
        }
        // Harga Produksi
        if($this->harga>0) $this->harga_produksi = $this->harga + $this->ppn;
        // Margin
        if($this->harga_jual>0 && $this->harga_produksi>0) $this->margin = $this->harga_jual  - $this->harga_produksi; 
        if($this->diskon>0 and $this->margin>0) $this->margin = $this->margin - $this->diskon;
    }

    public function update()
    {
        $this->validate([
            'price' => 'required'
        ]);

        // dd($this->data);
        // $this->data->ppn = $this->ppn;
        // $this->data->harga_jual = $this->harga_jual;
        // $this->data->harga = $this->harga;
        // $this->data->margin = $this->margin;
        // $this->data->diskon = $this->diskon;
        $this->data->price = $this->price;
        $this->data->save();

        $this->emit('message-success','Data berhasil disimpan.');
    }

    public function updateSettingHarga()
    {
        $data = new SettingHarga();
        
        $data->supplier_id  = $this->data->id_supplier;
        $data->product_id   = $this->data->id;
        $data->qty          = $this->qty;
        $data->disc         = $this->disc_p;
        $data->disc_harga   = $this->disc;
        $data->save();

        $this->reset(['qty','disc_p','disc']);
        $this->insert = false;

        $this->emit('message-success','Data berhasil diupdate.');
        return redirect()->to('product-supplier/detail/'.$this->data->id);
    }

    public function delete($id)
    {
        SettingHarga::find($id)->delete();
        $this->emit('message-success','Data berhasil dihapus.');
    }
}