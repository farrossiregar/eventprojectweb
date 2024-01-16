<?php

namespace App\Http\Livewire\Event;

use Livewire\Component;
use App\Models\SupplierProduct;
use Livewire\WithFileUploads;
use Auth;

class Insert extends Component
{
    use WithFileUploads;
    public $barcode,$desc_product,$nama_product, $qty, $price, $file;
    public function render()
    {
        return view('livewire.event.insert');
    }

    public function save()
    {
        $this->validate([
            'barcode' => 'required',
            'desc_product' => 'required',
            'nama_product' => 'required'
        ]);

        $data = new SupplierProduct();
        $data->barcode = $this->barcode;
        $data->desc_product = $this->desc_product;
        $data->nama_product = $this->nama_product;
        $data->qty = $this->price;
        $data->id_supplier = Auth::user()->id;
        // $data->image_source = $this->file;

        

        // if($this->file!=""){
            // $image = strtolower(str_replace(" ", "", $this->nama_product)).'.'.$this->file->extension();
            $image = strtolower(str_replace(" ", "-", $this->file->getClientOriginalName()));
            // $this->file->storePubliclyAs('public/assets/images/',$image);

            // $this->file->store('images/product', ['disk' => 'product']);
            $this->file->storeAs('images/product', $image, 'product');

            // $this->file($image)->storeAs('images', $image, 'product');

            // Storage::disk('assets_public')->put('filename', $image);

            // $path = base_path() . '/public/assets/images/product';
            // $request->file('image')->move($path, $image);
            
            $data->image_source = $image;
        // }

        $data->save();

        session()->flash('message-success',"Product berhasil di simpan, selanjutnya kamu harus tentukan harga jual produk");

        return redirect()->route('product-supplier.detail',$data->id);
    }
}
