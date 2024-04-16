<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends CI_Controller{

    public function index(){

        
        $perPage        = 6;
        $productcount   = $this->Common_model->getcount(['urun_durum'=>1],'urunler');
        $pageSegment    = ($this->uri->segment(2)) ? $this->uri->segment(2) : 1;
        $pkCount        = ($pageSegment - 1) * $perPage;

        $links       = paginationHelper(
            base_url('products'),
            $productcount,
            $perPage,
            2,
            TRUE,['class' => 'page-link']
        );

        $viewData      = array(
            "setting"      => $this->Common_model->get(['id'=>1],'ayarlar'),
            "productlist"  => $this->Common_model->getLimitAll(['urun_durum'=>1],$perPage,$pkCount,'urunler','urun_id','DESC'),
            "productcount" => $productcount,
            "productlinks" => $links,

            "categories"   => $this->Common_model->getAll(['katdurum'=>1],'kategoriler'),

            'social'       => $this->Common_model->getAll(['sosdurum'=>1],'sosyalmedyalar'),
            'pages'        => $this->Common_model->getAll(['sayfadurum'=>1],'sayfalar'),
            'popular'      => $this->Common_model->getLimitAll(['urun_durum'=>1],8,0,'urunler','urun_goruntulenme','DESC'),
            'popblog'      => $this->Common_model->getLimitAll(['blogdurum'=>1],4,0,'blog','bloggoruntulenme','DESC'),
        );

        $this->load->view('default/products_view',$viewData);

    }

    public function detail($par1,$par2){
        if(!$par1 || !$par2){
            redirect(base_url());
        }

        $query = $this->Common_model->get([
            'urun_durum'=>1,
            'urun_kodu' =>$par2,
            'urun_sef'  =>$par1
        ],'urunler');

        if($query){

            ##ürün görüntülenmesini arttır ##
            $views = @$_COOKIE[$query->urun_kodu];
            if(!$views){
                $plus = $query->urun_goruntulenme + 1;
                $this->db->query("UPDATE urunler SET urun_goruntulenme='$plus' WHERE urun_kodu='$query->urun_kodu'");
                setcookie($query->urun_kodu,'1',time() + 3600);
            }
            ##ürün görüntülenmesini arttır ##

            $viewData = array(
                'product'        => $query,
                'productcomment' => $this->Common_model->getlistAll(['yorumurun'=>$query->urun_kodu,'yorumdurum'=>1],'yorumlar','yorumtarih','DESC'),
                'productimage'   => $this->Common_model->getAll(['resurun'=>$query->urun_kodu],'urunresimler'),
                'productskill'   => $this->Common_model->getAll(['ozurun'=>$query->urun_kodu],'urunozellikler'),
                'productsell'    => $this->Common_model->getcount(['sipurun'=>$query->urun_kodu,'sipdurum'=>'tamamlandi'],'siparisler'),
                'related'        => $this->Common_model->getLimitAll(['urun_kategori'=>$query->urun_kategori,'urun_kodu !='=>$query->urun_kodu],5,0,'urunler','urun_goruntulenme','Desc'),

                "setting"        => $this->Common_model->get(['id'=>1],'ayarlar'),
                'social'         => $this->Common_model->getAll(['sosdurum'=>1],'sosyalmedyalar'),
                'pages'          => $this->Common_model->getAll(['sayfadurum'=>1],'sayfalar'),
                'popular'        => $this->Common_model->getLimitAll(['urun_durum'=>1],8,0,'urunler','urun_goruntulenme','DESC'),
                'popblog'        => $this->Common_model->getLimitAll(['blogdurum'=>1],4,0,'blog','bloggoruntulenme','DESC'),
                
                'ordercount'     => $this->Common_model->getcount(['sipuye'=>ss('usercode'),'sipurun'=>$query->urun_kodu,'sipdurum'=>'tamamlandi'],'siparisler')
            
            );

            $this->load->view('default/productdetail_view',$viewData);

        }else{
            redirect(base_url()); 
        }

    }

    public function search(){

        $filters    = $this->input->get();
        $page       = $this->input->get('page') ?? 1;
        $limit      = 12;
        $offest     = ($page - 1) * $limit;

        $this->load->model('Search_model');
        $total_rows = $this->Search_model->count_search_products($filters);
        $products   = $this->Search_model->search_products($filters,$limit,$offest);

        $total_pages= ceil($total_rows / $limit);
        $num_link   = 5;
        $start_page = max(1,$page - $num_link);
        $end_page   = min($total_pages,$page + $num_link);

        $viewData   = array(
            'productcount' => $total_rows,
            'totalrow'     => $total_rows,
            'products'     => $products,
            'productlist'  => $products,
            'total_pages'  => $total_pages,
            'current_page' => $page,
            'start_page'   => $start_page,
            'end_page'     => $end_page,

            'setting'      => $this->Common_model->get(['id'=>1],'ayarlar'),
            'social'       => $this->Common_model->getAll(['sosdurum'=>1],'sosyalmedyalar'),
            'pages'        => $this->Common_model->getAll(['sayfadurum'=>1],'sayfalar'),
            'popular'      => $this->Common_model->getLimitAll(['urun_durum'=>1],8,0,'urunler','urun_goruntulenme','DESC'),
            'popblog'      => $this->Common_model->getLimitAll(['blogdurum'=>1],4,0,'blog','bloggoruntulenme','DESC'),
            "categories"   => $this->Common_model->getAll(['katdurum'=>1],'kategoriler'),

        );

        $this->load->view('default/search_view',$viewData);

    }

    public function savecomment(){

        $this->load->helper('usersession');
        userchecksession();

        if($this->input->method() == "post"){

            $pcode        = strip_tags(trim($this->input->post('pcode')));
            $point        = strip_tags(trim($this->input->post('point')));
            $comment      = strip_tags(trim($this->input->post('comment')));
            $pquery       = $this->Common_model->get(['urun_kodu'=>$pcode],'urunler');
            $commentquery = $this->Common_model->getcount(['yorumuye'=>ss('usercode'),'yorumurun'=>$pquery->urun_kodu,'yorumdurum'=>2],'yorumlar');


            if(!$pcode || !$point || !$comment || $point < 1 || $point > 5 ){

                $error = array(
                    'title' => 'Hata oluştu',
                    'text'  => 'Boş alan bırakmayınız...',
                    'icon'  => 'error'
                );

            }else{

                if($pquery){

                    $order = $this->Common_model->getcount([
                        'sipuye'=>ss('usercode'),
                        'sipurun'=>$pquery->urun_kodu,
                        'sipdurum'=>'tamamlandi'],'siparisler');
                    if($order > 0){
    
                        ///beklemede olan yorumu varmı
                        if($commentquery > 0){

                            $error = array(
                                'title' => 'Hata oluştu',
                                'text'  => 'Bu ürünle ilgili beklemede olan yorumunuz olduğu için yeni bir yorum yapamazsınız...',
                                'icon'  => 'error'
                            );

                        }else{

                            //ürünü satın aldıysa ve giriş yaptıysa
                            $data = array(
                                'yorumuye'    => ss('usercode'),
                                'yorumisim'   => ss('username'),
                                'yorumurun'   => $pcode,
                                'yorumicerik' => $comment,
                                'yorumip'     => $this->input->ip_address(),
                                'yorumpuan'   => $point
                            );

                            $add = $this->Common_model->add('yorumlar',$data);
                            if($add){

                                $error = array(
                                    'title' => 'Başarılı',
                                    'text'  => 'Yorumunuz gönderildi, yönetici onayından sonra görüntülenecektir...',
                                    'icon'  => 'success'
                                );

                            }else{
                                $error = array(
                                    'title' => 'Hata oluştu',
                                    'text'  => 'Sistem hatası oluştu...',
                                    'icon'  => 'error'
                                );
                            }

                        }

                    }else{
    
                        $error = array(
                            'title' => 'Hata oluştu',
                            'text'  => 'Ürünü satın almış olmanız gerekmektedir...',
                            'icon'  => 'error'
                        );
    
                    }

                }else{

                    $error = array(
                        'title' => 'Hata oluştu',
                        'text'  => 'Ürün bulunmuyor...',
                        'icon'  => 'error'
                    );

                }

            }


            echo json_encode($error);

        }

    }

}

?>
