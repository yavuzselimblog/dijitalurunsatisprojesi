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
                            <h2 class="page-title">Ödeme Ekranı</h2>
                            <ul class="page-list">
                                <li><a href="<?php echo base_url();?>">Ana Sayfa</a></li>
                                <li>Ödeme Ekranı</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- error-page area start -->
    <section class="error-page-area pd-top-100 pd-bottom-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12">
                    <?php if($iyzicoerror){ ?>
                        <div class="alert alert-danger"><?php echo $iyzicoerror;?></div>
                    <?php } ?>  
                    <div style="color: #0c5460;background-color: #d1ecf1;border-color: #bee5eb;" class="alert alert-info">!Lütfen ödeme işlemini tamamlayana kadar sekmeyi kapatmayınız...</div>
						<div id="iyzipay-checkout-form" class="responsive"><?php echo $iyzicoform;?></div>
					</div>
                
                 
                </div>
            </div>
        </div>
    </section>
    <!-- error-page area end -->
    <?php $this->load->view('default/inc/footer_view');?>
