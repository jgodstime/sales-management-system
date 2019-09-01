<?php
 $msg = new \Mini\Libs\FlashMessages();
 use Mini\Model\Sales;
 use Mini\Model\Register;

?>

<div class="container">

    <div class="row">
        <?php
                            

        if(!isset($_GET['tDate']) || !isset($_GET['salesId'])){
            ?>
        <div class="col-md-6 col-md-offset-3">

            <form action="<?php $_SERVER['PHP_SELF'];?>" method="GET">

                    <div class="col-md-6">
                        <input type="text" required name="sDate" class="form-control" id="productSearch" placeholder="Start date (e.g 02-12-2018)">   
                    </div>

                    <div class="col-md-6">
                    <div class="input-group">
                            <input type="text" required name="eDate" class="form-control" id="productSearch" placeholder="End date (e.g 04-12-2018)">
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
                            (new Sales())->displaySalesSearchDate($startDate,$endDate);
                        }else if(isset($_GET['salesId'])){
                            $salesId = trim($_GET['salesId']);

                            (new Sales())->displaySalesInfo($salesId);
                        }else{
                            (new Sales())->displaySales();
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