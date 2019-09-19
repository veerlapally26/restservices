<?php
  class Books extends CI_Model {
       
    public function __construct(){          
        $this->load->database();
    }
    
    //API call - filter books by Person
    public function getbookbyname($location){  
        $this->db->select('*');
        $this->db->from('Books');
        $this->db->where('Location',$location);
        $query = $this->db->get();
        
        if($query->num_rows() == 1){
           return $query->result_array();
        }else{
         return 0;
        }
    }

    //API call - get all books
    public function getallbooks(){
        $this->db->select('*');
        $this->db->from('Books');
        $this->db->order_by("BookId", "desc");
        $query = $this->db->get();
        
        if($query->num_rows() > 0){
          return $query->result_array();
        }else{
          return 0;
        }
    }
   
   //API call - delete a book
    public function delete($id){
        $this->db->where('BookId', $id);
        
        if($this->db->delete('Books')){
          return true;
        }else{
          return false;
        }
   }
   
   //API call - add new book
    public function add($data){        
        if($this->db->insert('Books', $data)){
           return true;
        }else{
           return false;
        }
    }
    
    //API call - update a book
    public function update($id, $data){
        $this->db->where('BookId', $id);
        
        if($this->db->update('Books', $data)){
          return true;
        }else{
          return false;
        }
    }

}