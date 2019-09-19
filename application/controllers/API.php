<?php

require(APPPATH.'/libraries/REST_Controller.php');
 
class Api extends REST_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('books');
    }

    //API - client sends Name and valid book information is sent back
    function bookByName_get(){
        $name  = $this->get('Location');
        
        if(!$name){
            $this->response("No Name specified", 400);
            exit;
        }
        
        $result = $this->books->getbookbyname( $name );
        
        if($result){
            $this->response($result, 200); 
            exit;
        } 
        else{
            $this->response("Invalid Name", 404);
            exit;
        }
    } 

    //API -  Fetch All books
    function books_get(){
        $result = $this->books->getallbooks();
        
        if($result){
            $this->response($result, 200); 
        } 
        else{
            $this->response("No record found", 404);
        }
    }
     
    //API - create a new book.
    function addBook_post(){
        $name = $this->post('Name');
        $isbn13 = $this->post('ISBN-13');
        $isbn10 = $this->post('ISBN-10');
        $location = $this->post('Location');
    
        if(!$name || !$isbn13 || !$isbn10 || !$location){
            $this->response("Enter complete book information to Create", 400);
         }else{
            $data = array(
                "Name"=>$name,
                "ISBN-13"=>$isbn13,
                "ISBN-10"=>$isbn10,
                "Location"=>$location,
             );
            $result = $this->books->add($data);
            if($result === 0){
                $this->response("Book information could not be created. Try again.", 404);
            }else{
                $this->response("success", 200);
            }
        }
    }

    //API - update a book 
    function updateBook_put(){
         
        $name = $this->put('Name');
        $isbn13 = $this->put('ISBN-13');
        $isbn10 = $this->put('ISBN-10');
        $location = $this->put('Location');
        $id = $this->put('BookId');
         
        if(!$name || !$isbn13 || !$isbn10 || !$location){
            $this->response("Enter complete book information to Update", 400);
         }else{
            $data = array(
             "Name"=>$name,
             "ISBN-13"=>$isbn13,
             "ISBN-10"=>$isbn10,
             "Location"=>$location,
            );
            $result = $this->books->update($id, $data);
        
            if($result === 0){
                $this->response("Book information could not be updated. Try again.", 404);
            }
            else{
                $this->response("success", 200);
            }
        }
    }

    //API - delete a book 
    function deleteBook_delete()
    {
        $id  = $this->delete('BookId');
        
        if(!$id){
            $this->response("Parameter missing", 404);
        }
         
        if($this->books->delete($id)){
            $this->response("Success", 200);
        } 
        else {
            $this->response("Failed", 400);
        }
    }
}