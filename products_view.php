<?php $this->load->view('default/inc/header_view');?>


<!-- dkt-sitebar-menu start-->
<?php $this->load->view('default/inc/sidebar_view');?>
<!-- dkt-sitebar-menu end-->

<!-- navbar start -->
<?php $this->load->view('default/inc/menu_view');?>
<!-- navbar end -->

<!-- breadcrumb start -->
<div class="breadcrumb-area" style="background-image:url('<?php echo base_url();?>/default/assets/img/breadcrumb/1.png')">
<div class="container">
<div class="row">
    <div class="col-lg-12">
        <div class="breadcrumb-inner">
            <div class="section-title text-center">
                <h2 class="page-title">Ürün Listesi</h2>
                <ul class="page-list">
                    <li><a href="<?php echo base_url();?>">Ana Sayfa</a></li>
                    <li>Ürün Listesi</li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- breadcrumb end -->

<!-- blog-page area start -->
<section class="blog-page-area pd-top-100 pd-bottom-100">
<div class="container">
<div class="row">
    
    <div class="col-lg-8 order-lg-last">
        <?php if($productcount > 0){ ?>
        <div class="all-item-section all-item-area-2">
            <div class="row">
                <!-- gallery item start here -->
                <?php foreach($productlist as $product){ ?>
                <div class="all-isotope-item col-lg-6 col-sm-6">
                    <div class="thumb">
                        <a class="gallery-fancybox" href="<?php echo base_url('products/detail/'.$product->urun_sef.'/'.$product->urun_kodu);?>">
                            <img width="370" height="260" src="<?php echo base_url('uploads/'.$product->urun_resim);?>" alt="<?php echo $product->urun_adi;?>">
                        </a>
                        <a class="btn btn-white" href="<?php echo base_url('products/detail/'.$product->urun_sef.'/'.$product->urun_kodu);?>">Ürün Detayı</a>
                    </div>
                    <div class="item-details">
                        <h4><a href="<?php echo base_url('products/detail/'.$product->urun_sef.'/'.$product->urun_kodu);?>"><?php echo $product->urun_adi;?></a></h4>
                        <p><?php echo $product->urun_kisa;?></p>
                        
                        <a href="javascript:void(0);" class="author-details align-item-center">
                            <span>Ürün Fiyatı</span>
                        </a>
                        <span class="price bg-white float-right"><?php echo $product->urun_fiyat.'₺';?></span>
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
        
        <div class="row float-right">
        <?php echo $productlinks;?>
        </div>


        <?php }else{
            alert('Kayıt bulunmuyor','danger');
        } ?>


    </div>


    <?php $this->load->view('default/inc/searchsidebar_view');?>
    
</div>
</div>
</section>
<!-- blog-page area end -->
<?php $this->load->view('default/inc/footer_view');?>
