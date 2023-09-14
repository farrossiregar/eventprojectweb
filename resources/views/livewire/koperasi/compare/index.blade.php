@section('title', 'Compare')
<div class="clearfix row">
   
    <div class="col-lg-12">
        <div class="card">
            <div class="row">
              
                <div class="col-md-12">
                    <div class="row">
                        
                        <div id="card-deck" class="card-deck" style="padding: 30px;">
                            <!-- for($i = 1; $i < 4; $i++) -->
                            <div class="card">
                                <img class="card-img-top" src="https://mmc.tirto.id/image/otf/880x495/2019/04/25/avengers-endgame-marvel-studios_ratio-16x9.jpg" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title" style="text-align: left; font-size: 18px;">Sari Roti Roti Tawar Choco Chip</h5>
                                    <h5 class="card-title" style="text-align: left; font-size: 12px;">PT Kartika Mandiri Sejahtera</h5>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title" style="text-align: center; font-size: 30px;">Rp, 10.000,00</h5>
                                    <!-- <p class="card-text">This is a wider card with.</p> -->
                                </div>
                                
                                <div class="card-body">
                                    <p class="card-text" style="text-align: center;">Stok 20 Pcs</p>
                                </div>
                                <div class="card-body">
                                    <p class="card-text" style="text-align: center;">Tangerang Selatan</p>
                                </div>

                                <div class="card-body">
                                    <p class="card-text" style="text-align: center;">Terjual 150 Pcs</p>
                                </div>
                            
                                <div class="card-footer">
                                    <small class="text-muted">
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4">
                                                <div class="btn btn-info">
                                                    <i class="fa fa-shopping-cart"></i> &nbsp; <b> BELI</b>
                                                </div>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                    </small>
                                </div>
                            </div>
                            <!-- endfor -->

                            <div class="card">
                                <img class="card-img-top">
                                <div class="card-body">
                                    <div class="container h-100">
                                        <div class="row align-items-center h-100">
                                            <div class="col-6 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-4">
                                                        <span wire:click="$emit('add_product_compare')">
                                                            <i style="font-size: 75px; align:center; color: lightblue;" class="fa fa-plus fa-8x"></i>
                                                        </span>
                                                        
                                                    </div>
                                                    <div class="col-md-4"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>


                        </div>


                        <a href="javascript:void(0)" wire:click="$emit('modal_detail_product',$item->id)">
                            <div class="card" style="width: 16rem; border: 1px solid lightgrey; margin: 4px;">
                                
                            </div>
                        </a>
                        
                    </div>
                  
                </div>
            </div>
            
            
        </div>
    </div>



    <div wire:ignore.self class="modal fade" id="add_product_compare" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                
                <div class="row" >
                    
                    <div class="col-md-12">
                        
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-search"></i> Search Product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true close-btn">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                
                            </div>

                            <div class="modal-header">
                                <form wire:submit.prevent="beliproduct" style="width: 960px;">
                                    <div class="row">
                                        <div class="btn btn-info" wire:click="$emit('pick_product_compare', '10')">Pilih</div>
                                        
                                    </div>
                                </form>
                            </div>

                    </div>
                </div>

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


@push('after-scripts') 
<script>

    Livewire.on('add_product_compare',()=>{
        console.log();
        $("#add_product_compare").modal('show');
    });


    Livewire.on('pick_product_compare',(data)=>{
        // alert(data);
        var cardprod = 
                            '<div class="card">'+
                                '<img class="card-img-top" src="https://mmc.tirto.id/image/otf/880x495/2019/04/25/avengers-endgame-marvel-studios_ratio-16x9.jpg" alt="Card image cap">'+
                                '<div class="card-body">'+
                                    '<h5 class="card-title" style="text-align: left; font-size: 18px;">Sari Roti Roti Tawar Choco Chip</h5>'+
                                    '<h5 class="card-title" style="text-align: left; font-size: 12px;">PT Kartika Mandiri Sejahtera</h5>'+
                                '</div>'+
                                '<div class="card-body">'+
                                    '<h5 class="card-title" style="text-align: center; font-size: 30px;">Rp, 10.000,00</h5>'+
                                '</div>'+
                                
                                '<div class="card-body">'+
                                    '<p class="card-text" style="text-align: center;">Stok 20 Pcs</p>'+
                                '</div>'+
                                '<div class="card-body">'+
                                    '<p class="card-text" style="text-align: center;">Tangerang Selatan</p>'+
                                '</div>'+

                                '<div class="card-body">'+
                                    '<p class="card-text" style="text-align: center;">Terjual 150 Pcs</p>'+
                                '</div>'+
                            
                                '<div class="card-footer">'+
                                    '<small class="text-muted">'+
                                        '<div class="row">'+
                                            '<div class="col-md-4"></div>'+
                                            '<div class="col-md-4">'+
                                                '<div class="btn btn-info">'+
                                                    '<i class="fa fa-shopping-cart"></i> &nbsp; <b> BELI</b>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="col-md-4"></div>'+
                                        '</div>'+
                                    '</small>'+
                                '</div>'+
                           '</div>';
        
        $("#add_product_compare").modal('hide');
        $('#card-deck').append(cardprod);
    });


    // Livewire.on('modal_detail_product',(data)=>{
    //     console.log(data);
    //     $("#modal_detail_product").modal('show');
    // });
    
    // untuk menangkap Event emit "refresh-page" yang dibuat di Component Edit.php
    // jika ada event refresh-page maka modal kita hide
    Livewire.on('refresh-page',()=>{
        $(".modal").modal("hide");
    });
</script>
@endpush

