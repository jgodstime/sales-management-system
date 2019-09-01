<?php

/**
 * Class Songs
 * This is a demo Model class.
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

namespace Mini\Model;

use Mini\Core\Model;
use PDO;


class Register extends Model
{

    public function updateProductQuantity($addedQuantity,$productId)
    {
       $lastProductQuantity = (new Sales)->getProductInfo($productId)->quantity;
       $newProductQuantity = $lastProductQuantity + $addedQuantity;
    //    die('<br><br><br><br><br><br><br>'.$productId);
        $queryUpdate = $this->db->prepare("UPDATE product_tbl set quantity = ? WHERE id = ?");
        $queryUpdate->execute(array($newProductQuantity, $productId));
        if($queryUpdate){
            $this->msg->success('Product quantity successfully updated.', $_SERVER['HTTP_REFERER']);  
        }else{
            $this->msg->error('Unable to update product quantity at this time, please try again later.', $_SERVER['HTTP_REFERER']);            

        }
    }


    public function deleteProduct($productId)
    {
        $queryDelete = $this->db->prepare("DELETE FROM product_tbl WHERE id = ?");
        $queryDelete->execute(array($productId));
        if($queryDelete){
            $this->msg->success('Product successfully deleted.', $_SERVER['HTTP_REFERER']);  
        }else{
            $this->msg->error('Unable to delete product at this time, please try again later.', $_SERVER['HTTP_REFERER']);            

        }
    }

    
    public function register($productName,$unitPrice,$quantity,$category,$fileName,$temporaryFile)
    {

        if($this->checkProductName($productName)){
            $this->msg->error('Product name "' .$productName. '" already exist', $_SERVER['HTTP_REFERER']); 

        }else{
            $materialCode =  rand(3000,10000).rand(9000,10000).rand(200,4000);
       
            $writerCodeForThisMat = $materialCode;
            $temp = explode(".", $fileName);
            $newFileName = $writerCodeForThisMat . '.' . end($temp); //renaming the file with
            move_uploaded_file($temporaryFile,'productImages/'.$newFileName);

            $queryInsert = $this->db -> prepare("INSERT INTO product_tbl (id, categoryid,productname, unitprice,quantity,image, entrydate) VALUES(?,?,?,?,?,?,now())");
            $queryInsert->execute(array('',$category, $productName,$unitPrice,$quantity,$newFileName));
            if($queryInsert){
                $this->msg->success('Product successfully registered.', $_SERVER['HTTP_REFERER']);
            }else{
                $this->msg->error('Unable to register product at this time, try again later.', $_SERVER['HTTP_REFERER']);
            }
        }

      
    }


    public function registerCategory($categoryName)
    {

        if($this->checkProductCategoryName($categoryName)){
            $this->msg->error('Category name "' .$categoryName. '" already exist', $_SERVER['HTTP_REFERER']);            
        }else{
            $queryInsert = $this->db -> prepare("INSERT INTO category_tbl (id, categoryname, createdat) VALUES(?,?,now())");
            $queryInsert->execute(array('',$categoryName));
            if($queryInsert){
                $this->msg->success('Category successfully registered.', $_SERVER['HTTP_REFERER']);
            }else{
                $this->msg->error('Unable to register category at this time, try again later.', $_SERVER['HTTP_REFERER']);
            }
        }      
    }

    public function registerMaterial($materialName)
    {

        if($this->checkProductMaterialName($materialName)){
            $this->msg->error('Material name "' .$materialName. '" already exist', $_SERVER['HTTP_REFERER']);            
        }else{
            $queryInsert = $this->db -> prepare("INSERT INTO material_tbl (id, materialname, createdat) VALUES(?,?,now())");
            $queryInsert->execute(array('',$materialName));
            if($queryInsert){
                $this->msg->success('Material successfully registered.', $_SERVER['HTTP_REFERER']);
            }else{
                $this->msg->error('Unable to register material at this time, try again later.', $_SERVER['HTTP_REFERER']);
            }
        }      
    }

    public function registerUseMaterial($materialId,$kg,$todaysDate){
        // die($materialId.$kg.$todaysDate);
        $queryInsert = $this->db -> prepare("INSERT INTO materialuse_tbl (id, materialid, kg, createdat) VALUES(?,?,?,?)");
            $queryInsert->execute(array('',$materialId,$kg,$todaysDate));
            if($queryInsert){
                $this->msg->success('Use material successfully registered.', $_SERVER['HTTP_REFERER']);
            }else{
                $this->msg->error('Unable to register use material at this time, try again later.', $_SERVER['HTTP_REFERER']);
            }
    }


    public function categorySelect()
    {
     
        $query = $this->db->prepare("SELECT * FROM category_tbl ORDER BY id ASC");
        $query->execute();

        if ($query->rowCount() > 0) {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['id'];
                $categoryname = $row['categoryname'];
                echo '<option value="'.$id.'" >'.$categoryname.'</option>';
            }

        }else{
            echo '<option>No category</option>';

        }

    }


    public function materialSelect()
    {
     
        $query = $this->db->prepare("SELECT * FROM material_tbl ORDER BY id ASC");
        $query->execute();

        if ($query->rowCount() > 0) {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['id'];
                $materialname = $row['materialname'];
                echo '<option value="'.$id.'" >'.$materialname.'</option>';
            }

        }else{
            echo '<option>No material</option>';

        }

    }

    public function getCategoryById($id)
    {
     
        $query = $this->db->prepare("SELECT * FROM category_tbl WHERE id=?");
        $query->execute(array($id));

      
            return $query->fetch(PDO::FETCH_ASSOC)['categoryname'];
             

    }


    public function displayCategory()
    {
     
        $query = $this->db->prepare("SELECT * FROM category_tbl ORDER BY id DESC");
        $query->execute();
        if ($query->rowCount() > 0) {
            

            ?>
<div class="table-responsive">
<h2 class="text-center">Current Category</h2>
    <table class="table table-hover table-bordered" >

        <thead>
            <tr>
                <th><i class="icon-database"></i></th>
                <th>Category Name</th>
                <th>Created At</th>
                

            </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
                ?> 
            
       
            <tr>
                <td><?php echo $id;?></td>
                <td><?php echo $row['categoryname'];?></td>
                <td><?php echo $row['createdat']; ?></td>
            
            </tr>
        
        
    

<?php
        }
        
            ?>
            </tbody>
            </table>
            
        

<?php

        } else {
            echo '<div>
			<a class="list-group-item">Not Found.</a>
		</div>';
        }


    }




    public function displayMaterial()
    {
     
        $query = $this->db->prepare("SELECT * FROM material_tbl ORDER BY id DESC");
        $query->execute();
        if ($query->rowCount() > 0) {
            

            ?>
<div class="table-responsive">
<h2 class="text-center">Current Materials</h2>
    <table class="table table-hover table-bordered" >

        <thead>
            <tr>
                <th><i class="icon-database"></i></th>
                <th>Material Name</th>
                <th>Created At</th>
                

            </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
                ?> 
            
       
            <tr>
                <td><?php echo $id;?></td>
                <td><?php echo $row['materialname'];?></td>
                <td><?php echo $row['createdat']; ?></td>
            
            </tr>
        
        
    

<?php
        }
        
            ?>
            </tbody>
            </table>
            
        

<?php

        } else {
            echo '<div>
			<a class="list-group-item">Not Found.</a>
		</div>';
        }


    }

    public function checkProductName($productName)
    {
        $quesrySelect = $this->db -> prepare("SELECT productname FROM  product_tbl WHERE productname = ?");
        $quesrySelect->execute(array($productName));
        if($quesrySelect->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    public function checkProductCategoryName($categoryName)
    {
        $quesrySelect = $this->db -> prepare("SELECT categoryname FROM  category_tbl WHERE categoryname = ?");
        $quesrySelect->execute(array($categoryName));
        if($quesrySelect->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    public function checkProductMaterialName($materialName)
    {
        $quesrySelect = $this->db -> prepare("SELECT materialname FROM  material_tbl WHERE materialname = ?");
        $quesrySelect->execute(array($materialName));
        if($quesrySelect->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }
    

    public function displayProducts()
    {
     
        $query = $this->db->prepare("SELECT * FROM product_tbl ORDER BY id DESC");
        $query->execute();
        if ($query->rowCount() > 0) {
            

            ?>
<div class="table-responsive">
<h2 class="text-center">Current Products (Make Sales)</h2>
    <table class="table table-hover table-bordered" >

        <thead>
            <tr>
                <th>Product Name</th>
                <th>Category</th>
                <th>Unit Price</th>
                <th>Available Quantity</th>
                <th>Image</th>
                <th>Quantity Needed</th>
                <th  class="text-center">Select</th>

            </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $categoryId = $row['categoryid'];
                ?> 
            
       
            <tr>
                <td><?php echo $row['productname'];?></td>
                <td><?php echo $this->getCategoryById($categoryId);?></td>
                <td> <img src=" <?php echo URL. PRODUCT_IMAGE.$row['image']; ?>"width="50" height="50" alt=""></td>
               
                <td>
                <?php if($row['quantity']==0){
                        echo '<span style="color:red;">'.$row['quantity'].'</span>';
                    }else{
                        ?>
                        <?php echo $row['quantity']; ?>

                        <?php
                    }?>
                    
                </td>

               

                <td>
                    <?php if($row['quantity']==0){
                        echo '<span style="color:red;">Out of Stock</span>';
                    }else{
                        ?>
                        <input type="number" name="quantityProductId<?php echo $id;?>" value="1" min="1" max="<?php echo $row['quantity']; ?>" required class="" id="">
                        <?php
                    }?>
                   
                </td>
                <td><?php echo $row['unitprice']; ?></td>


                <td class="text-center"> 
                    <?php if($row['quantity']==0){
                        echo '<a href="'.URL.'register/manage"> <i style="color:red;" class="glyphicon glyphicon-edit"></i></a>';
                    }else{
                        ?>
                        <input  type="checkbox" class="" value="<?php echo $id; ?>" name="productCheckId[]" id="checkBox">

                        <?php
                    }?>
                
                </td>
            </tr>
        
        
    

<?php
        }
        
            ?>
            </tbody>
            </table>
            
            <div class="text-center">
            
            
            <button type="submit" class="btn btn-primary" name="salesBtn">Make Sales</button>
            </div>
           
</div>

<?php

        } else {
            echo '<div>
			<a class="list-group-item">Not Found.</a>
		</div>';
        }


    }


    


    public function displayProductsBySearch($searchData)
    {
     
        $query = $this->db->prepare("SELECT * FROM product_tbl WHERE productname LIKE ? ");
        $query -> bindValue(1, "%$searchData%", PDO::PARAM_STR);
	$query -> execute();
     
        if ($query->rowCount() > 0) {
            

            ?>
<div class="table-responsive">
<h2 class="">Current Products</h2>
    <table class="table table-hover table-bordered">

        <thead>
            <tr>
                <th>Product Name</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Select</th>

            </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
                ?> 
        
            <tr>
               
                <td>
                    <?php echo $row['productname']; ?>
                </td>

                  <td>
                    <?php echo $row['unitprice']; ?>
                </td>
               
                <td>
                    <input type="number" name="quantityProductId<?php echo $id;?>" value="1" min="1" required class="" id="">
                </td>
                <td> <input type="checkbox" class="" value="<?php echo $id; ?>" name="productCheckId[]" id="checkBox"
                ></td>
            </tr>
       
        
    

<?php
        }
        
            ?>
             </tbody>
            </table>
            
            <div class="text-center">
            
            
            <button type="submit" class="btn btn-primary" name="salesBtn">Make Sales</button>
            </div>
</div>

<?php

        } else {
            echo '<div>
			<a class="list-group-item">Not Found.</a>
		</div>';
        }


    }




    public function manageProducts()
    {
     
        $query = $this->db->prepare("SELECT * FROM product_tbl ORDER BY id DESC");
        $query->execute();
        if ($query->rowCount() > 0) {
            

            ?>
<div class="table-responsive">
<h2 class="text-center">Manage Products</h2>
    <table class="table table-hover table-bordered">

        <thead>
            <tr>
                <th>Product Name</th>
                <th>Category</th>
                <th>Unit Price</th>
                <th>Available Quantity</th>
                <th  class="text-center">Delete</th>
                <th>Update</th>

            </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $categoryId = $row['categoryid'];
                ?> 
            
        
            <tr>
            

                <td>
                    <?php echo $row['productname']; ?>
                </td>
                <td>
                    <?php echo $this->getCategoryById($categoryId); ?>
                </td>

                  <td>
                    <?php echo $row['unitprice']; ?>
                </td>
               
                <td>
                <?php if($row['quantity']==0){
                        echo '<span style="color:red;">'.$row['quantity'].'</span>';
                    }else{
                        ?>
                        <?php echo $row['quantity']; ?>

                        <?php
                    }?>
                    
                </td>
               

                

                <td class="text-center"> 
                <form method="POST" onsubmit="return confirm('Do you really want to Delete Product?');">
                    <input type="hidden" name="productId" value="<?php echo $id;?>">
                    <button type="submit" class="btn btn-sm btn-danger"  name="deleteBtn">
                    <i class="glyphicon glyphicon-trash"> </i>
                    </button>
                    </form>           
                </td>

                <td>
                    <form method="POST" onsubmit="return confirm('Do you really want to Update Product Quantity?');">
                        <input type="hidden" name="productId" value="<?php echo $id;?>">
                        <input type="number" name="addedQuantity" placeholder="New Quantity">
                        <button type="submit" class="btn btn-sm btn-info"  name="updateProductQuantityBtn">
                            <i class="glyphicon glyphicon-edit"> </i>
                        </button>
                    </form>    
                </td>
            </tr>
      
        
    

<?php
        }
        
            ?>
              </tbody>
            </table>
            
          
           
</div>

<?php

        } else {
            echo '<div>
			<a class="list-group-item">Not Found.</a>
		</div>';
        }


    }



}
