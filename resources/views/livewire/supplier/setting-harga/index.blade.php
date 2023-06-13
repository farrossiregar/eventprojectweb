@section('title', 'Produk')
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header row">
                <div class="col-md-2">
                    <input type="text" class="form-control" wire:model="keyword" placeholder="Pencarian" />
                </div>
                <div class="col-md-6">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="javascript:void(0);" wire:click="downloadExcel"><i class="fa fa-download"></i> Download</a>
                            <a href="{{route('product-supplier.insert')}}" class="dropdown-item"><i class="fa fa-plus"></i> Tambah Produk</a>
                            <a href="javascript:void(0)" class="dropdown-item" data-toggle="modal" data-target="#modal_upload"><i class="fa fa-upload"></i> Upload</a>
                        </div>
                    </div>
                    <span wire:loading>
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        <span class="sr-only">{{ __('Loading...') }}</span>
                    </span>
                </div>
            </div>
            <div class="body pt-0">
                <div class="table-responsive" style="min-height:400px;">
                    <table class="table table-hover m-b-0 c_list">
                        <thead style="background: #eee;">
                           <tr>
                                <th>No</th>
                                <th>Jumlah (>=)</th>
                                <th>Harga</th>
                                <th class="text-right">Created At</th>
                                <th></th>
                           </tr>
                        </thead>
                        <tbody>
                            @php($number= $data->total() - (($data->currentPage() -1) * $data->perPage()) )
                            @foreach($data as $k => $item)
                                @php($bg_minimum_stok="transparent")
                                
                                
                                @php($number--)
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br />
                {{$data->links()}}
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modal_set_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form wire:submit.prevent="changePassword">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-sign-in"></i> Set Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true close-btn">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" wire:model="password" />
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger close-modal">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <livewire:product-supplier.upload />
        </div>
    </div>
</div>



