<?php
 $msg = new \Mini\Libs\FlashMessages();
 use Mini\Model\Register;
 
?>
<div class="container">

    <div class="row">
        <div class="col-md-5 " >
            <?php
                $msg->display();
            ?>
            <form action="<?php $_SERVER['PHP_SELF'];?>" class="" method="POST" role="form" >
                <h3>Register Material</h3>
            
                <div class="form-group">
                    <input type="text" class="form-control" name="materialName" id="" placeholder="Material Name">
                </div>
                                
                <div class="form-group ">
                    <button type="submit" name="registerMaterialBtn" class="btn btn-primary ">Submit</button>
                </div>
            </form>
            
        </div>

        <div class="col-md-7 panel">
           <?php (new Register)->displayMaterial();?>
            
        </div>

        
    </div>

</div>