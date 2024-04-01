<div class="col-lg-4 order-lg-first">
        <form action="<?php echo base_url('products/search');?>" method="GET">
        <div class="sidebar-area">
            <div class="widget widget-search">
                <div class="single-search-inner">
                    <input type="text" name="search_term1" placeholder="Ürün arayın">
                </div>
            </div>
            <?php if($categories){ ?>
            <div class="widget widget-category widget-border">
                <h5 class="widget-title">Ürün Kategorileri</h5>
                <ul>
                    <?php foreach($categories as $cat){ ?>
                    <li>
                        <input type="radio" name="search_term2" value="<?php echo $cat->katkodu;?>"> 
                        <a href='<?php echo base_url('category/'.$cat->katsef);?>'><?php echo $cat->katadi;?></a>
                    </li>
                    <?php } ?>
                    
                </ul>
            </div>
            <?php } ?>
            
            <button type="submit" class="btn btn-base">Filtrele <i class="la la-search"></i></button>
        </div>
        </form>

    </div>