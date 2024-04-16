<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model{

    public function search_products($filters,$limit,$offset){

        $this->db->select('*');
        $this->db->from('urunler');

        if(!empty($filters['search_term1'])){

            $searchterm  = strip_tags($filters['search_term1']);
            $searchterm2 = urldecode($searchterm);
            $searchterm2 = str_replace(
                array('+','_'),
                array(' ','_'),
                $searchterm
            );

            $this->db->like('urun_adi',$searchterm2);

        }


        if(!empty($filters['search_term2'])){

            $searchterm1  = strip_tags($filters['search_term2']);
            $searchterm3 = urldecode($searchterm1);
            $searchterm3 = str_replace(
                array('+','_'),
                array(' ','_'),
                $searchterm1
            );

            $this->db->or_like('urun_kategori',$searchterm3);

        }

        $this->db->order_by('urun_id','DESC');
        $this->db->limit($limit,$offset);
        $query = $this->db->where('urun_durum',1)->get();
        return $query->result();

    }  
    
    

    public function count_search_products($filters){

        $this->db->select('*');
        $this->db->from('urunler');

        if(!empty($filters['search_term1'])){

            $searchterm  = strip_tags($filters['search_term1']);
            $searchterm2 = urldecode($searchterm);
            $searchterm2 = str_replace(
                array('+','_'),
                array(' ','_'),
                $searchterm
            );

            $this->db->like('urun_adi',$searchterm2);

        }


        if(!empty($filters['search_term2'])){

            $searchterm1  = strip_tags($filters['search_term2']);
            $searchterm3 = urldecode($searchterm1);
            $searchterm3 = str_replace(
                array('+','_'),
                array(' ','_'),
                $searchterm1
            );

            $this->db->or_like('urun_kategori',$searchterm3);

        }

        $this->db->order_by('urun_id','DESC');
        $query = $this->db->where('urun_durum',1)->get();
        return $query->num_rows();

    }  

}

?>