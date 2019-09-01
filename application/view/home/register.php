<?php
 $msg = new \Mini\Libs\FlashMessages();
 use Mini\Model\Register;
?>
<div class="container">


    <div class="row">
      
        <div class="col-md-6 col-md-offset-3 panel">
                        <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST" role="form" enctype="multipart/form-data">
                <h2>Register Product</h2>
                <div class="col-md-12">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Product Image</label><br>

                            <img id="previewimageid" style="width:160px; height:160px;" src="#">

                            <input name="file" class="form-control" required onchange="previewimage(event)" type="file">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" name="productName" required  id="" placeholder="Product Name" type="text">
                        </div>

                        <div class="form-group">
                            <input class="form-control" name="unitPrice" required id="" placeholder="Unit Price" type="number">
                        </div>

                        <div class="form-group">
                            <input class="form-control" name="quantity" required id="" placeholder="Quantity" type="number">
                        </div>
                        <div class="form-group">
                          <select name="category" id="" class="form-control">
                          <option>Select Product Category</option>
                            <?php (new Register)->categorySelect();?>
                          </select>
                        </div>

                         <div class="form-group text-center">
                    <button type="submit" name="registerProductBtn" class="btn btn-primary btn-block ">Submit</button>
                </div>
                    </div>
                </div>





               
            </form>

        </div>
    </div>

</div>

<script type="text/javascript">
    function previewimage(event) {
        var output = document.getElementById('previewimageid');
        output.src = URL.createObjectURL(event.target.files[0]);
    };
</script>