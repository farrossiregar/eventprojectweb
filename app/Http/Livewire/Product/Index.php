<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $keyword,$filter=[],$is_confirm_delete=false,$selected_id=0;
    protected $listeners = ['refresh'=>'$refresh'];
    public function render()
    {
        $data = Product::with(['uom'])->orderBy('id','DESC');

        foreach($this->filter as $field => $value){
            if($value=="") continue;
            if($field =='keterangan'){
                $data->where(function($table) use($value){
                    $table->where('keterangan','LIKE',"%{$value}%")
                    ->orWhere('kode_produksi','LIKE',"%{$value}%");
                });
            }elseif($field=='minimum_stock'){
                if($value==1) $data->whereNotNull('minimum_stok')->whereRaw('qty < minimum_stok');
                if($value==2) $data->whereNotNull('minimum_stok')->whereRaw('qty = minimum_stok');
            }else{
                $data->where($field,$value);
            }
        }
        return view('livewire.product.index')->with(['data'=>$data->paginate(200)]);
    }

    public function mount()
    {
        \LogActivity::add('Product');
    }

    public function set_delete($id)
    {
        $this->is_confirm_delete = true; $this->selected_id = $id;
    }

    public function cancel_delete()
    {
        $this->is_confirm_delete = false; $this->selected_id = 0;
    }

    public function delete()
    {
        Product::find($this->selected_id)->delete();
        
        $this->selected_id = 0;
        $this->emit('message-success','Data berhasil dihapus');
        $this->emit('refresh');
    }
}
