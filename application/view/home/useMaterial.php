<?php
 $msg = new \Mini\Libs\FlashMessages();
 use Mini\Model\Sales;
 use Mini\Model\Register;

?>

<div class="container">

    <div class="row">


        <div class="col-md-6 col-md-offset-3 panel">


            <form action="" method="POST" role="form" class="">
            <div class="col-md-12 text-center"> <h3>Add Material Used</h3></div>
               
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="materialId" id="" class="form-control">
                            <option value="">Select Material</option>
                            <?php (new Register)->materialSelect();?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <input class="form-control" name="kg" required id="" placeholder="KG" type="number">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      
                <button type="submit" name="registerUseMaterialBtn" class="btn btn-primary">Submit</button>

                    </div>
                </div>






            </form>


        </div>
    

        <?php
                            

        if(!isset($_GET['tDate']) || !isset($_GET['salesId'])){
            ?>
        <div class="col-md-6 col-md-offset-3">

            <form action="<?php $_SERVER['PHP_SELF'];?>" method="GET">

                <div class="col-md-6">
                    <input type="text" required name="sDate" class="form-control" id="productSearch"
                        placeholder="Start date (e.g 02-12-2018)">
                </div>

                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" required name="eDate" class="form-control" id="productSearch"
                            placeholder="End date (e.g 04-12-2018)">
                        <span class="input-group-btn">
                            <button type="submit" name="tDateBtn" class="btn btn-default">Go!</button>
                        </span>
                    </div>
                </div>


            </form>

        </div>
        <?php
        }

        ?>





        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <form action="<?php $_SERVER['PHP_SELF']?>" method="get">
                        <?php
                          $msg->display();
                        if(isset($_GET['sDate']) && isset($_GET['eDate'])){
                            $startDate = trim($_GET['sDate']);
                            $endDate = trim($_GET['eDate']);
                            (new Sales())->displayUseMaterialSearchDate($startDate,$endDate);
                        }else{
                            (new Sales())->displayUseMaterial();
                        } 
                            
                        
                        
                        ?>
                        <!-- <div id="salesDisplay"></div> -->


                    </form>

                </div>

            </div>


        </div>



    </div>



</div>

<script type='text/javascript' src='<?php echo URL; ?>js/sales.js'></script>