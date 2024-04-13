<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Creditcard extends CI_Controller{

    public function paytr($order){

        ##session kontrolleri
        $this->load->helper('usersession');
        userchecksession();
         ##session kontrolleri sonu
        
        if(!$order){
            redirect(base_url());
        }

        $orderquery = $this->Common_model->get([
        'sipno'=>$order,'odemedurum' => 2],'siparisler');
        if($orderquery){

            ##default POS firması ## 
            $setting = $this->Common_model->get(['id'=>1],'ayarlar');
            $defaultpos = $setting->site_gecerli_pos;
            $pos        = $this->Common_model->get(['posid'=>$defaultpos],'posfirmalari');

            ##ürün bilgileri ## 
            $product    = $this->Common_model->get(['urun_kodu'=>$orderquery->sipurun],'urunler');

            ##PAYTR için veriler## 
            $merchant_id 	   = $pos->posmerchantid;
            $merchant_key      = $pos->posmerchantkey;
            $merchant_salt	   = $pos->posmerchantsalt;

            $email             = ss('usermail');
            $payment_amount	   = $product->urun_fiyat * 100;
            $merchant_oid      = $orderquery->sipno;
            $user_name         = ss('username'); 
            $user_address      = "Istanbul";
            $user_phone        = ss('userphone');
            $merchant_ok_url   = $pos->basariliurl;
            $merchant_fail_url = $pos->hataurl;

            $user_basket       = base64_encode(json_encode(array(
                array($product->urun_adi, $product->urun_fiyat, 1)
            )));

            ## Kullanıcının IP adresi
            if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }

            ## !!! Eğer bu örnek kodu sunucuda değil local makinanızda çalıştırıyorsanız
            ## buraya dış ip adresinizi (https://www.whatismyip.com/) yazmalısınız. Aksi halde geçersiz paytr_token hatası alırsınız.
            $user_ip=$ip;
            ##

            ## İşlem zaman aşımı süresi - dakika cinsinden
            $timeout_limit = "30";

            ## Hata mesajlarının ekrana basılması için entegrasyon ve test sürecinde 1 olarak bırakın. Daha sonra 0 yapabilirsiniz.
            $debug_on = 1;

            ## Mağaza canlı modda iken test işlem yapmak için 1 olarak gönderilebilir.
            $test_mode = 1;

            $no_installment	= 0; // Taksit yapılmasını istemiyorsanız, sadece tek çekim sunacaksanız 1 yapın

            ## Sayfada görüntülenecek taksit adedini sınırlamak istiyorsanız uygun şekilde değiştirin.
            ## Sıfır (0) gönderilmesi durumunda yürürlükteki en fazla izin verilen taksit geçerli olur.
            $max_installment = 0;

            $currency = "TL";
            
            ####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
            $hash_str = $merchant_id .$user_ip .$merchant_oid .$email .$payment_amount .$user_basket.$no_installment.$max_installment.$currency.$test_mode;
            $paytr_token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));
            $post_vals=array(
                    'merchant_id'=>$merchant_id,
                    'user_ip'=>$user_ip,
                    'merchant_oid'=>$merchant_oid,
                    'email'=>$email,
                    'payment_amount'=>$payment_amount,
                    'paytr_token'=>$paytr_token,
                    'user_basket'=>$user_basket,
                    'debug_on'=>$debug_on,
                    'no_installment'=>$no_installment,
                    'max_installment'=>$max_installment,
                    'user_name'=>$user_name,
                    'user_address'=>$user_address,
                    'user_phone'=>$user_phone,
                    'merchant_ok_url'=>$merchant_ok_url,
                    'merchant_fail_url'=>$merchant_fail_url,
                    'timeout_limit'=>$timeout_limit,
                    'currency'=>$currency,
                    'test_mode'=>$test_mode
                );
            
            $ch=curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1) ;
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            
            // XXX: DİKKAT: lokal makinanızda "SSL certificate problem: unable to get local issuer certificate" uyarısı alırsanız eğer
            // aşağıdaki kodu açıp deneyebilirsiniz. ANCAK, güvenlik nedeniyle sunucunuzda (gerçek ortamınızda) bu kodun kapalı kalması çok önemlidir!
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            
            $result = @curl_exec($ch);

            if(curl_errno($ch))
                die("PAYTR IFRAME connection error. err:".curl_error($ch));

            curl_close($ch);
            
            $result=json_decode($result,1);
                
            if($result['status']=='success')
                $token=$result['token'];
            else
                die("PAYTR IFRAME failed. reason:".$result['reason']);
            #########################################################################
          
            $viewData = array(
                "token"        => $token,
                "setting"      => $this->Common_model->get(['id'=>1],'ayarlar'),
                'social'       => $this->Common_model->getAll(['sosdurum'=>1],'sosyalmedyalar'),
                'pages'        => $this->Common_model->getAll(['sayfadurum'=>1],'sayfalar'),
                'popular'      => $this->Common_model->getLimitAll(['urun_durum'=>1],8,0,'urunler','urun_goruntulenme','DESC'),
                'popblog'      => $this->Common_model->getLimitAll(['blogdurum'=>1],4,0,'blog','bloggoruntulenme','DESC'),
            );

            $this->load->view('default/paytr_view',$viewData);

         
        }else{
            redirect(base_url());
        }

    
    }

    //yavuz-selim.com/resultpaytr
    public function resultpaytr(){

        ##default pos firması
        $setting = $this->Common_model->get(['id'=>1],'ayarlar');
        $defaultpos = $setting->site_gecerli_pos;
        $pos        = $this->Common_model->get(['posid'=>$defaultpos],'posfirmalari');

        $post           = $_POST;
        $merchant_key   = $pos->posmerchantkey;
        $merchant_salt	= $pos->posmerchantsalt;
        $orderno        = $post['merchant_oid'];

        ##siparişe ait veriler ## 
        $orderquery     = $this->Common_model->get(['sipno'=>$orderno],'siparisler');
        $userquery      = $this->Common_model->get(['uye_kodu'=>$orderquery->sipuye],'uyeler');
        $pquery         = $this->Common_model->get(['urun_kodu'=>$orderquery->sipurun],'urunler');
        ##siparişe ait veriler ## 

        ## POST değerleri ile hash oluştur.
        $hash = base64_encode( hash_hmac('sha256', $post['merchant_oid'].$merchant_salt.$post['status'].$post['total_amount'], $merchant_key, true) );
        #
        ## Oluşturulan hash'i, paytr'dan gelen post içindeki hash ile karşılaştır (isteğin paytr'dan geldiğine ve değişmediğine emin olmak için)
        ## Bu işlemi yapmazsanız maddi zarara uğramanız olasıdır.
        if( $hash != $post['hash'] )
            die('PAYTR notification failed: bad hash');
        ###########################################################################

        if( $post['status'] == 'success' ) { ## Ödeme Onaylandı

            $this->Common_model->update(['sipno'=>$orderno],
            ['sipdurum'=>'hazirlaniyor'],'siparisler');

            ##mail gönderim işlemi ## 
            if($setting->mailbildirim == 1){

                $this->load->helper('class.smtp');
                $this->load->helper('class.phpmailer');

                $defaultsmtp       = $setting->site_gecerli_smtp;
                $smtpinfo          = $this->Common_model->get(['smtp_id'=>$defaultsmtp,'smtp_durum'=>1],'smtpbilgileri');

                $mail              = new PHPMailer();
                $mail->Host        = $smtpinfo->smtp_host;
                $mail->Port        = $smtpinfo->smtp_port;
                $mail->SMTPSecure  = $smtpinfo->smtp_sec;
                $mail->Username    = $smtpinfo->smtp_mail;
                $mail->Password    = $smtpinfo->smtp_sifre;
                $mail->IsSMTP();
                $mail->SMTPAuth    = true;
                $mail->SetFrom($smtpinfo->smtp_mail,$setting->site_baslik);
                $mail->AddAddress($userquery->uye_mail,$setting->site_baslik);
                $mail->CharSet  = 'UTF-8';
                $mail->Subject  = $orderno.' Nolu Siparişiniz Onaylandı - '.$setting->site_baslik;
                    
                $content = '<h3>Sipariş Onayı</h3>
                <p>'.$orderno.' sipariş numarası ile yeni siparişiniz onaylandı, En kısa sürede teslimatı sağlanacaktır ...</p>
                <hr />
                <h5>Sipariş Detayı</h5>
                <p><b>Sipariş Tutarı:</b>'.$pquery->urun_fiyat.' TL</p>
                <p><b>Sipariş Numarası:</b>'.$orderno.'</p>
                <p><b>Ürün Adı:</b>'.$pquery->urun_adi.'</p>
                <hr />
                <p>Bizi tercih ettiğiniz için teşekkür ederiz...</p>
                ';
                $mail->MsgHTML($content);
                $mail->Send();
            }
            ##mail bildirim sonu

            
        } else { ## Ödemeye Onay Verilmedi
    
            $this->Common_model->update(['sipno'=>$orderno],
            ['sipdurum'=>'iptal',
            'odemeaciklama' => $post['failed_reason_code'].'-'.$post['failed_reason_msg']],
            'siparisler');
    
        }
    
        ## Bildirimin alındığını PayTR sistemine bildir.
        echo "OK";
        exit;

    }
    

}

?>