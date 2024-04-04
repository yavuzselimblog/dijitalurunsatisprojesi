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
                            <h2 class="page-title"><?php echo $product->urun_adi;?></h2>
                            <ul class="page-list">
                                <li><a href="<?php echo base_url();?>">Ana Sayfa</a></li>
                                <li><a href="<?php echo base_url('products');?>">Ürünler</a></li>
                                <li><?php echo $product->urun_adi;?></li>
                              
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- product-details area start -->
    <section class="product-details pd-top-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-product-wrap mb-4">
                        <div class="thumb">
                     
                           
                            <img src="<?php echo base_url('uploads/'.$product->urun_resim);?>" alt="<?php echo $product->urun_adi;?>">
                            <a class="btn btn-white" target="_blank" href="<?php echo $product->urun_demo;?>">Ürün Demo URL</a>
                            <a class="btn btn-white btn-buy" target="_blank" href="<?php echo $product->urun_yonetimdemo;?>">Yönetim Paneli</a>
                     
                        </div>
                        <div class="single-product-details">
                            <h4><a href="#"><?php echo $product->urun_adi;?></a></h4>
                            <p><?php echo $product->urun_kisa;?></p>
                        </div>
                    </div>

                    <?php if($productimage){ ?>


                        <div class="single-product-wrap mb-4">
                        <div class="row">
                                <div class="col-lg-6">
                                    <div class="section-title">
                                        <h4>Ürün Resimler</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="product-slider owl-carousel owl-theme">
                                        <?php foreach($productimage as $pimage){ ?>
                                        <div class="item">
                                            <div class="all-isotope-item">
                                                <div class="thumb">
                                                    <a class="gallery-fancybox" href="javascript:void(0);">
                                                        <img width="370" height="260" src="<?php echo base_url('uploads/'.$pimage->resdosya);?>" alt="<?php echo $product->urun_adi;?>">
                                                    </a>
                                                    <a class="btn btn-white" href="javascript:void(0);"><i class="fa fa-camera"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                  
                     
                           
                       
                  
                    <?php } ?>

                    <div class="product-tab">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#pills-home">Açıklama</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#pills-profile">Yorumlar (<?php echo count($productcomment);?>)</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-home">
                                <?php echo $product->urun_icerik;?>
                            </div>
                            <div class="tab-pane fade" id="pills-profile">
                                <h5 class="title">Yorumlar (<?php echo count($productcomment);?>)</h5>
                                <?php if($productcomment){ ?>
                                <?php foreach($productcomment as $com){?>
                                <div class="single-review">
                                    <h6 class="name"><?php echo $com->yorumisim;?></h6>
                                    <span class="date"><?php echo sdate($com->yorumtarih,true);?></span>

                                    <div class="star-rating">
                                        <?php for($i=0;$i<$com->yorumpuan;$i++){?>
                                        <span><i class="la la-star"></i></span>
                                        <?php } ?>
                                    </div>

                                    <p><?php echo $com->yorumicerik;?></p>
                                </div>
                                <?php } ?>
                                <?php }else{
                                    alert('Yorum bulunmuyor, ilk yorumu siz yapabilirsiniz...','warning');
                                } ?>

                             
                                <div class="add-review">
                                    <?php if(@ss('userlogin')){
                                    
                                    if($ordercount > 0){
                                    ?>

                                    <h5 class="title">Yorum Yapın</h5>
                                    <form class="contact-form" id="commentform" onsubmit="return false;">
                                    <input type="hidden" name="pcode" value="<?php echo $product->urun_kodu;?>" />
                                        <div class="row">
                                            <div class="col-12">
                                               
                                                <select name="point" class="single-input">
                                                    <option value="0">Puan seçiniz</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                               
                                            </div>
                                            <div class="col-12">
                                                <div class="single-input-wrap">
                                                    <textarea name="comment" class="single-input textarea" placeholder="Yorumunuz"></textarea>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <button type="submit" class="btn btn-base" onclick="combutton();" id="combuton">Yorum Yapın</button>
                                    </form>

                                    <?php 
                                    
                                    }else{
                                        alert('Yorum yapabilmek için ürünü satın almış olmanız gerekmektedir...','danger');
                                    }
                                    
                                    }else{
                                        alert('Yorum yapabilmek için <a href="'.base_url('loginpage').'">giriş yapınız...</a>','danger');
                                    } ?>
                                </div>
                              

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-area">
                        <div class="widget widget-cart">
                            <div class="widget-cart-inner text-center">
                                <h3 class="price"><?php echo $product->urun_fiyat.'₺';?></h3>
                                <ul>
                                    <li><i class="fa fa-shopping-cart"></i><?php echo $productsell;?> Kez Satıldı</li>
                                    <li><i class="fa fa-eye"></i><?php echo $product->urun_goruntulenme;?> Kez Görüntülendi</li>
                                </ul>
                                <a class="btn btn-base" href="<?php echo base_url('order/'.$product->urun_kodu);?>">Satın Al</a>
                            </div>
                        </div>
                        <?php if($productskill){ ?>
                        <div class="widget widget-list">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <?php foreach($productskill as $skill){ ?>
                                        <tr>
                                            <td><b><?php echo $skill->ozbaslik;?>:</b></td>
                                            <td><?php echo $skill->ozicerik;?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product-details area end -->

    <!-- product-slider area start -->
    <?php if($related){ ?>
    <section class="product-slider-area pd-bottom-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h2>Benzer Ürünler</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-slider owl-carousel owl-theme">
                        <?php foreach($related as $rel){ ?>
                        <div class="item">
                            <div class="all-isotope-item">
                                <div class="thumb">
                                    <a class="gallery-fancybox" href="<?php echo base_url('products/detail/'.$rel->urun_sef.'/'.$rel->urun_kodu);?>">
                                        <img width="370" height="260" src="<?php echo base_url('uploads/'.$rel->urun_resim);?>" alt="<?php echo $rel->urun_adi;?>">
                                    </a>
                                    <a class="btn btn-white" href="<?php echo base_url('products/detail/'.$rel->urun_sef.'/'.$rel->urun_kodu);?>">Ürün Detayı</a>
                                </div>
                                <div class="item-details">
                                    <span class="price"><?php echo $rel->urun_fiyat.'₺';?></span>
                                    <h4><a href="<?php echo base_url('products/detail/'.$rel->urun_sef.'/'.$rel->urun_kodu);?>"><?php echo $rel->urun_adi;?></a></h4>
                                    <p><?php echo $rel->urun_kisa;?></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
    <!-- product-slider area end -->
    <?php $this->load->view('default/inc/footer_view');?>