<?php  
    if (isset($_POST['submit'])) {
        $ten_dm=$_POST['ten_dm'];
        if(isset($ten_dm)){
            $sql = "INSERT INTO dmsanpham(ten_dm) VALUES('$ten_dm')";
            $query = mysqli_query($conn, $sql);
            header('location: quantri.php?page_layout=danhsachdm');
        }
    }
?>
<div class="row">
    <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active"></li>
    </ol>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add new categories</h1>
    </div>
</div><!--/.row-->


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Add new categories</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form role="form" method="post">
                        <div class="form-group">
                            <label>Category name</label>
                            <input class="form-control" type="text" required="" name="ten_dm">
                        </div>																					
                        <button type="submit" class="btn btn-primary" name="submit">Add</button>
                        <button type="reset" class="btn btn-default">Refresh</button>
                        </div>
                    </form>
            </div>
        </div>
    </div><!-- /.col-->
</div><!-- /.row -->
