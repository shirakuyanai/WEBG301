<script>
    function xoadanhmuc(){
        var conf= confirm("Are you sure you want to delete this entry?");
        return conf;
    }
</script>
<?php
    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }else{
        $page=1;
    }
    $rowPerPage=5;
    $perPage=$page*$rowPerPage-$rowPerPage;
    $sql="SELECT * FROM dmsanpham ORDER BY id_dm ASC LIMIT $perPage,$rowPerPage";
    $query = mysqli_query($conn,$sql);
    $totalRows=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM dmsanpham"));
    $totalPage=ceil($totalRows/$rowPerPage);
    $listPage="";
    for($i=1;$i<=$totalPage;$i++)
    {
        if($page==$i){
            $listPage.='<li class="active"><a href="quantri.php?page_layout=danhsachdm&page='.$i.'">'.$i.'</a></li>';
        }else{
            $listPage.='<li><a href="quantri.php?page_layout=danhsachdm&page='.$i.'">'.$i.'</a></li>';
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
        <h1 class="page-header">Manage categories</h1>
    </div>
</div><!--/.row-->


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <div class="panel-body" style="position: relative;">
                <a href="quantri.php?page_layout=themdm" class="btn btn-primary" style="margin: 10px 0 20px 0; position: absolute;">Add new category</a>
                <table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-sort-name="name" data-sort-order="desc">
                    <thead>
                        <tr>						        
                            <th data-sortable="true">ID</th>
                            <th data-sortable="true">Category name</th>
                            <th data-sortable="true">Edit</th>
                            <th data-sortable="true">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                            while($row= mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td data-checkbox="true"><?php echo $row['id_dm']; ?></td>
                            <td data-checkbox="true"><a href="quantri.php?page_layout=suadm&id_dm=<?php echo $row['id_dm']; ?>"><?php echo $row['ten_dm']; ?></a></td>						        
                            <td>
                                <a href="quantri.php?page_layout=suadm&id_dm=<?php echo $row['id_dm']; ?>"><span><svg class="glyph stroked brush" style="width: 20px;height: 20px;"><use xlink:href="#stroked-brush"/></svg></span></a>
                            </td>
                            <td>
                                <a onclick="return xoadanhmuc();" href="./chucnang/danhmuc/xoadm.php?id_dm=<?php echo $row['id_dm']; ?>"><span><svg class="glyph stroked cancel" style="width: 20px;height: 20px;"><use xlink:href="#stroked-cancel"/></svg></span></a>
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
