<script>
	function xoatv(){
		var conf=confirm('Bạn có muốn xóa tài khoản này không?');
		return conf;
	}
</script>
<?php
    if(isset($_GET['page']))
    {
        $page=$_GET['page'];
    }
    else{
        $page=1;
    }
    $rowPerPage=5;
    $perPage=$page*$rowPerPage-$rowPerPage;
	$sql="SELECT * FROM thanhvien ORDER BY id_thanhvien ASC LIMIT $perPage,$rowPerPage";
	$query=mysqli_query($conn, $sql);

    $totalRows=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM thanhvien"));
    $totalPages=ceil($totalRows/$rowPerPage);
    $listPage="";
    for($i=1;$i<=$totalPages;$i++)
    {
        if($page==$i){
            $listPage.='<li class="active"><a href="quantri.php?page_layout=quanlytv&page='.$i.'">'.$i.'</a></li>';
        }
        else{
            $listPage.='<li><a href="quantri.php?page_layout=quanlytv&page='.$i.'">'.$i.'</a></li>';
        }
    }
?>
<div class="row">
    <ol class="breadcrumb">
        <li><a href="quantri.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active"></li>
    </ol>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manage members</h1>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">					
            <div class="panel-body" style="position: relative;">
                <a href="quantri.php?page_layout=themtv" class="btn btn-primary" style="margin: 10px 0 20px 0; position: absolute;">Add member</a>				
                <table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-sort-name="name" data-sort-order="desc">
                    <thead>
                        <tr>						        
                            <th data-sortable="true">ID</th>
                            <th data-sortable="true">Email</th>
                            <th data-sortable="true">Password</th>
                            <th data-sortable="true">Access ID</th>
                            <th data-sortable="true">Edit</th>
                            <th data-sortable="true">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                            while($row=mysqli_fetch_array($query)){
                        ?>
                        <tr style="height: 300px;">
                            <td data-checkbox="true"><?php echo $row['id_thanhvien']; ?></td>
                            <td data-checkbox="true"><a href="quantri.php?page_layout=suatv&id_thanhvien=<?php echo $row['id_thanhvien']; ?>"><?php echo $row['email']; ?></a></td>
                            <td data-checkbox="true"><?php echo $row['mat_khau']; ?></td>
                            <td data-sortable="true"><?php echo $row['quyen_truy_cap']; ?></td>
                            <td>
                                <a href="quantri.php?page_layout=suatv&id_thanhvien=<?php echo $row['id_thanhvien']; ?>"><span><svg class="glyph stroked brush" style="width: 20px;height: 20px;"><use xlink:href="#stroked-brush"/></svg></span></a>
                            </td>
                            <td>
                                <a onclick="return xoatv();" href="./chucnang/thanhvien/xoatv.php?id_thanhvien=<?php echo $row['id_thanhvien']; ?>"><span><svg class="glyph stroked cancel" style="width: 20px;height: 20px;"><use xlink:href="#stroked-cancel"/></svg></span></a>
                            </td>
                        </tr>
                        <?php  
                            }
                        ?>
                    </tbody>
                </table>
                <ul class="pagination" style="float: right;">
                    <?php  
                        echo $listPage;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div><!--/.row-->	