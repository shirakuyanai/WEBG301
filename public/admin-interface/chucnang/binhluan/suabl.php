<?php  
    $id_bl=$_GET['id_bl'];
    $sql = "SELECT * FROM blsanpham WHERE id_bl=$id_bl";
    $query = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($query);
    if(isset($_POST['submit'])){
        $binh_luan=$_POST['binh_luan'];
        if(isset($id_bl) && isset($binh_luan)){
            $sql="UPDATE blsanpham SET binh_luan='$binh_luan' WHERE id_bl=$id_bl";
            $query = mysqli_query($conn,$sql);
            header('location: quantri.php?page_layout=blsp');
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
        <h1 class="page-header">Edit comments</h1>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Edit comments</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form role="form" method="post">


                        <table data-toggle="table">
                            <thead>
                                <tr>                                
                                    <th data-sortable="true">ID</th>
                                    <th data-sortable="true">Name</th>
                                    <th data-sortable="true">Phone number</th>
                                    <th data-sortable="true">Comment content</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-checkbox="true"><?php echo $row['id_bl']; ?></td>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="ten" value="<?php if(isset($_POST['ten'])){echo $_POST['ten'];} else{echo $row['ten'];}?>" required="">
                                    </td>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="dien_thoai" value="<?php if(isset($_POST['dien_thoai'])){echo $_POST['dien_thoai'];} else{echo $row['dien_thoai'];}?>" required="">

                                    </td>
                                    <td data-checkbox="true">
                                        <textarea class="form-control" rows="3" name="binh_luan"><?php if(isset($_POST['binh_luan'])){echo $_POST['binh_luan'];} else{echo $row['binh_luan'];}  ?></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        <button type="submit" class="btn btn-primary" name="submit">Edit</button>
                        <button type="reset" class="btn btn-default">Refresh</button>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.col-->
</div><!-- /.row -->
