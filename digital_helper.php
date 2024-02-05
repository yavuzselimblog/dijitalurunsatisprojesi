<?php 

function sef_link($str){

    $preg = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#', '.');
    $match = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp', '');
    $perma = strtolower(str_replace($preg, $match, $str));
    $perma = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $perma);
    $perma = trim(preg_replace('/\s+/', ' ', $perma));
    $perma = str_replace(' ', '-', $perma);
    return $perma;

}

function _printR($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function _printRdie($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die();
}

function IP(){
    if(getenv("HTTP_CLIENT_IP")){
        $ip = getenv("HTTP_CLIENT_IP");
    }elseif(getenv("HTTP_X_FORWARDED_FOR")){
        $ip = getenv("HTTP_X_FORWARDED_FOR");
        if (strstr($ip, ',')) {
            $tmp = explode (',', $ip);
            $ip = trim($tmp[0]);
        } 
    }else{
        $ip = getenv("REMOTE_ADDR");
    }
    return $ip;
}

function tar() {

    $tespit2=$_SERVER['HTTP_USER_AGENT'];
    if(stristr($tespit2,"MSIE")) { $tarayici="Internet Explorer"; }
    elseif(stristr($tespit2,"Firefox")) { $tarayici="Mozilla Firefox"; }
    elseif(stristr($tespit2,"YaBrowser")) { $tarayici="Yandex Browser"; }
    elseif(stristr($tespit2,"Chrome")) { $tarayici="Google Chrome"; }
    elseif(stristr($tespit2,"Safari")) { $tarayici="Safari"; }
    elseif(stristr($tespit2,"Opera")) { $tarayici="Opera"; }
    else {$tarayici="Bilinmiyor";}
    return $tarayici;

}

function loc(){
    $loc = "http://localhost".$_SERVER['REQUEST_URI'];
    return $loc;
}

function ismobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|iemobile|ip(hone|od)|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)|iris|mini|mobi|palm|symbian|vodafone|wap|windows (ce|phone)|xda|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function ss($par){
    return $_SESSION[$par];
}


function sdate($par, $status = false){

    if($status == false){
        return date('d.m.Y H:i',strtotime($par));
    }else{
        return date('d.m.Y',strtotime($par));
    }

}


if (!function_exists('paginationHelper')) {
    function paginationHelper($baseUrl, $totalRows, $perPage, $uriSegment, $usePageNumber = false, $attributes = [],$reuse_query_string=FALSE)
    {
        $ci = &get_instance();
        $ci->load->library('pagination');
        $config = ['base_url' => $baseUrl,
            'total_rows' => $totalRows,
            'per_page' => $perPage,
            'uri_segment' => $uriSegment,
            'use_page_numbers' => $usePageNumber,
            'reuse_query_string'=>$reuse_query_string,
            'first_link' => ' << ',
            'last_link' => ' >> ',
            /*template for pagination*/
            'attributes' => $attributes,

            'full_tag_open' => '<ul class="pagination mb-4 pagination-sm m-0 float-right" style="margin-top: 20px;">',
            'full_tag_close' => '</ul>',
            'num_tag_open' => '<li  class="page-item">',
            'num_tag_close' => '</li>',
            'prev_tag_open' => '<li  class="page-item">',
            'prev_tag_close' => '</li>',
            'next_tag_open' => '<li  class="page-item">',
            'next_tag_close' => '</li>',
            'first_tag_open' => '<li  class="page-item">',
            'first_tag_close' => '</li>',
            'last_tag_open' => '<li  class="page-item">',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li  class="page-item active"><a class="page-link active">',
            'cur_tag_close' => '</a></li>'
        
        ];

        $ci->pagination->initialize($config);
        return $ci->pagination->create_links();
    }
}




?>