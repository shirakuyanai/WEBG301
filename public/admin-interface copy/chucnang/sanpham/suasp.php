<?php  
    $id_sp=$_GET['id_sp'];
    $sqldm="SELECT * FROM dmsanpham";
    $querydm= mysqli_query($conn,$sqldm);

    $sql="SELECT * FROM sanpham WHERE id_sp='$id_sp'";
    $query=mysqli_query($conn,$sql);
    $row=mysqli_fetch_array($query);

    if(isset($_POST['submit'])){
        $ten_sp=$_POST['ten_sp'];
        $gia_sp=$_POST['gia_sp'];
        $bao_hanh=$_POST['bao_hanh'];
        $phu_kien=$_POST['phu_kien'];
        $tinh_trang=$_POST['tinh_trang'];
        $khuyen_mai=$_POST['khuyen_mai'];
        $trang_thai=$_POST['trang_thai'];
        $chi_tiet_sp=$_POST['chi_tiet_sp'];

        if($_FILES['anh_sp']['name']==''){
            $anh_sp=$_POST['anh_sp'];
        }else{
            $anh_sp=$_FILES['anh_sp']['name'];
            $tmp_name=$_FILES['anh_sp']['tmp_name'];
        }
        $id_dm=$_POST['id_dm'];
        $dac_biet=$_POST['dac_biet'];
        if(isset($ten_sp) && isset($gia_sp) && isset($bao_hanh) && isset($phu_kien) && 
                isset($tinh_trang) && isset($khuyen_mai) && isset($trang_thai) && 
                isset($chi_tiet_sp) && isset($dac_biet)){
            move_uploaded_file($tmp_name, 'anh/'.$anh_sp);
            $sql="UPDATE sanpham SET ten_sp='$ten_sp',gia_sp='$gia_sp',bao_hanh='$bao_hanh',khuyen_mai='$khuyen_mai',"
                    . "phu_kien='$phu_kien',tinh_trang='$tinh_trang',trang_thai='$trang_thai',"
                    . "chi_tiet_sp='$chi_tiet_sp', dac_biet='$dac_biet',anh_sp='$anh_sp',id_dm='$id_dm' WHERE id_sp=$id_sp";
            $query= mysqli_query($conn, $sql);
            header('location: quantri.php?page_layout=danhsachsp');
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
        <h1 class="page-header">Edit information of products</h1>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Edit</div>
            <div class="panel-body">

                <form method="post" enctype="multipart/form-data" role="form">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Product name</label>
                            <input type="text" class="form-control"  name="ten_sp" value="<?php if(isset($_POST['ten_sp'])){echo $_POST['ten_sp'];}else{echo $row['ten_sp'];} ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" class="form-control" name="gia_sp" value="<?php if(isset($_POST['gia_sp'])){echo $_POST['gia_sp'];}else{echo $row['gia_sp'];} ?>" required="">
                        </div>

                        <div class="form-group">
                            <label>Warranty</label>
                            <input type="text" class="form-control" name="bao_hanh" value="<?php if(isset($_POST['bao_hanh'])){echo $_POST['bao_hanh'];}else{echo $row['bao_hanh'];} ?>" required="">
                        </div>

                        <div class="form-group">
                            <label>Accessories</label>
                            <input type="text" class="form-control" name="phu_kien" value="<?php if(isset($_POST['phu_kien'])){echo $_POST['phu_kien'];}else{echo $row['phu_kien'];} ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" class="form-control" name="tinh_trang" value="<?php if(isset($_POST['tinh_trang'])){echo $_POST['tinh_trang'];}else{echo $row['tinh_trang'];} ?>" required="">
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="anh_sp"><input type="hidden" name="anh_sp" value="<?php echo $row['anh_sp']; ?>">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sales</label>
                            <input type="text" class="form-control" name="khuyen_mai" value="<?php if(isset($_POST['khuyen_mai'])){echo $_POST['khuyen_mai'];}else{echo $row['khuyen_mai'];} ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Stocking status</label>
                            <input type="text" class="form-control" name="trang_thai" value="<?php if(isset($_POST['trang_thai'])){echo $_POST['trang_thai'];}else{echo $row['trang_thai'];} ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Special product</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="dac_biet"
                                        <?php 
                                            if($row['dac_biet']==1)
                                            {
                                                echo 'checked';
                                            }
                                         ?>

                                     id="optionsRadios1" value=1>Yes
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="dac_biet"
                                        <?php 
                                            if($row['dac_biet']==0)
                                            {
                                                echo 'checked';
                                            }
                                         ?>
                                     id="optionsRadios2" value=0>No
                                </label>
                            </div>

                        </div>

                        <div class="form-group">
                            <label>Provider</label>
                            <select name="id_dm" class="form-control">
                                <?php  
                                    while($rowdm= mysqli_fetch_array($querydm)) {
                                ?>
                                <option
                                    <?php
                                    if($row['id_dm']==$rowdm['id_dm']){
                                        echo 'selected="selected"'; 
                                    }?>
                                 value="<?php echo $rowdm['id_dm']; ?>"><?php echo $rowdm['ten_dm']; ?></option>
                                <?php 
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Information of product</label>
                            <textarea class="form-control" rows="3" name="chi_tiet_sp" <?php if(isset($_POST['chi_tiet_sp'])){echo $_POST['chi_tiet_sp'];} else{echo $row['chi_tiet_sp'];}  ?>></textarea>
                            <script type="text/javascript">
                                CKEDITOR.replace('chi_tiet_sp');
                            </script>
                        </div>



                    </div>

                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    <button type="reset" class="btn btn-default" name="reset">Refresh</button>


                </form>
            </div>
        </div>
    </div><!-- /.col-->
</div><!-- /.row -->
