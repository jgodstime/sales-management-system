<?php
namespace Mini\Controller;

use Mini\Core\View;
use Mini\Model\Register;


class RegisterController
{
    var $View;
    public $msg;
   
    function __construct() {
        $this->View = new View();
        $this->msg = new \Mini\Libs\FlashMessages();
    }

    

    public function index()
    {
        if(isset($_POST['registerProductBtn'])){
            $productName = ucwords($_POST['productName']);
            $unitPrice = $_POST['unitPrice'];
            $quantity = $_POST['quantity'];
            $category = $_POST['category'];


            $fileName = $_FILES['file']['name'];
            $temporaryFile = $_FILES['file']['tmp_name'];

            $allowed =  array('png','jpeg','jpg','gif');
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);

            // die('gghghhh<br>.pppph'.$quantity);
           


            // if ($this->msg->hasErrors()){
            //     // header('location:' . $_SERVER['HTTP_REFERER']);
            //     echo 'All fields are required';
            //     die();
            // }else{
                
            (new Register())->register($productName,$unitPrice,$quantity,$category,$fileName,$temporaryFile);
            // }
        }
            // html data
            $data["title"] = "Register Product"; /* for <title></title> inside header.php in this case */
            // load views
            $this->View->render('home/register', $data);
    }


    public function category()
    {
        if(isset($_POST['registerCategoryBtn'])){
            $categoryName = ucwords($_POST['categoryName']);
           

           
            if(empty($categoryName)){
                $this->msg->error('Category Name is required.');
            }
            if ($this->msg->hasErrors()){
                header('location:' . $_SERVER['HTTP_REFERER']);
                die();
            }else{
                
                (new Register())->registerCategory($categoryName);
            }
        }
            // html data
            $data["title"] = "Register Category"; /* for <title></title> inside header.php in this case */
            // load views
            $this->View->render('home/category', $data);
    }

    public function newMaterial()
    {
        if(isset($_POST['registerMaterialBtn'])){
            $materialName = ucwords($_POST['materialName']);
           

           
            if(empty($materialName)){
                $this->msg->error('Material Name is required.');
            }
            if ($this->msg->hasErrors()){
                header('location:' . $_SERVER['HTTP_REFERER']);
                die();
            }else{
                
                (new Register())->registerMaterial($materialName);
            }
        }
            // html data
            $data["title"] = "Register Material"; /* for <title></title> inside header.php in this case */
            // load views
            $this->View->render('home/newMaterial', $data);
    }


    public function useMaterial()
    {

        if(isset($_POST['registerUseMaterialBtn'])){
            $materialId = ($_POST['materialId']);
            $kg = trim($_POST['kg']);
            $todaysDate =  date('d-m-Y');           
            // die($todaysDate);
           
            if(empty($materialId)){
                $this->msg->error('Material is required.');
            }
            if(empty($kg)){
                $this->msg->error('Material KG is required.');
            }
            if ($this->msg->hasErrors()){
                header('location:' . $_SERVER['HTTP_REFERER']);
                die();
            }else{
                
                (new Register())->registerUseMaterial($materialId,$kg,$todaysDate);
            }
        }


       // html data
       $data["title"] = "Use Material";  /* for <title></title> inside header.php in this case */
       // load views
       $this->View->render('home/useMaterial', $data);
    }
   




    public function manage()
    {

        if(isset($_POST['deleteBtn'])){
            $productId  = $_POST['productId'];
            (new Register())->deleteProduct($productId);
        }

        if(isset($_POST['updateProductQuantityBtn'])){
            $productId  = $_POST['productId'];
            $addedQuantity  = $_POST['addedQuantity'];

            if(empty($addedQuantity)){
                $this->msg->error('New quantity value is required.');
            }
            if ($this->msg->hasErrors()){
                header('location:' . $_SERVER['HTTP_REFERER']);
                die();
            }else{
                // die(4);
                (new Register())->updateProductQuantity($addedQuantity,$productId);
            }
            
        }

            // html data
            $data["title"] = "Register Product"; /* for <title></title> inside header.php in this case */
            // load views
            $this->View->render('home/manage', $data);
    }



}
