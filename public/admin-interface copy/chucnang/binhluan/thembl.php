<?php  
    if(isset($_POST['submit'])){
        $ten=$_POST['ten'];
        $id_sp=$_POST['id_sp'];
        $dien_thoai=$_POST['dien_thoai'];
        $binh_luan=$_POST['binh_luan'];
        $ngay_gio=date('Y-m-d H:i:s');

        if(isset($ten)&&isset($dien_thoai)&&isset($binh_luan)&&isset($id_sp)){
            $sql="INSERT INTO blsanpham(ten,dien_thoai,binh_luan,ngay_gio,id_sp) VALUES('$ten','$dien_thoai',"."'$binh_luan','$ngay_gio','$id_sp')";
            $query=mysqli_query($conn,$sql);
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
        <h1 class="page-header">Add new comment</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Add new comment</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form role="form" method="post">
                        <table data-toggle="table">
                            <thead>
                                <tr>                                
                                    <th data-sortable="true">Name</th>
                                    <th data-sortable="true">ID Product</th>
                                    <th data-sortable="true">Phone number</th>
                                    <th data-sortable="true">Comment content</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="ten" value="<?php if(isset($_POST['ten']))echo $_POST['ten'];?>" required="">
                                    </td>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="id_sp" value="<?php if(isset($_POST['id_sp']))echo $_POST['id_sp'];?>" required="">
                                    </td>
                                    <td data-checkbox="true">
                                        <input class="form-control" type="text" name="dien_thoai" value="<?php if(isset($_POST['dien_thoai']))echo $_POST['dien_thoai'];?>" required="">
                                    </td>
                                    <td data-checkbox="true">
                                        <textarea class="form-control" rows="3" name="binh_luan"><?php if(isset($_POST['binh_luan']))echo $_POST['binh_luan'];?></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary" name="submit">Add</button>
                        <button type="reset" class="btn btn-default">Refresh</button>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.col-->
</div><!-- /.row -->