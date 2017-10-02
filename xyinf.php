<link href="adstyle.css" rel="stylesheet" type="text/css" />
<title>成绩管理系统</title>
<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location:login.php");
    exit();
}
include 'header.php';
include 'leftme.jsp';
?>
<div class="bg">
    <div class="con">
        <div class="con_ls">
            <p>学院管理<a href="ins_kminf.php" class="ins_inf">添加学院</a></p>
        </div>
        <div class="con_con">
            <div class="con_con_num">
                <?php
                include('conn.php');
                $sql = 'select * from xy_inf';
                $r = $conn -> query($sql);
                $ad_count = mysqli_num_rows($r);
                echo "<p>共有".$ad_count."个学院</p>";
                $perNumber=10;
                $page=$_GET['page'];
                $totalPage=ceil($ad_count/$perNumber);
                if (!isset($page)) {
                    $page=1;
                }
                $startCount=($page-1)*$perNumber;
                $sql_q = "select * from xy_inf
                limit $startCount,$perNumber";
                $result= $conn ->query($sql_q);
                ?>
            </div>
            <div class="con_con_movinf">
                <table class="table table-striped table-bordered table-hover" table-layout=fixed; width=100%; align="center">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>学院</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while($row = mysqli_fetch_array($result)){
                        ?>
                        <tr>
                            <td>
                                <?php
                                echo $row['xy_id'];
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $row['stu_xy'];
                                ?>
                            </td>
                            <td width="120">
                                <?php
                                //echo '<a href="alt_kminf.php?id='.$row['km_id'].'" class="movinf_bianji">编辑</a>';
                                echo '<a href="?deid='.$row['xy_id'].'"onclick="return delete_sql();" class="movinf_shanchu">删除</a>';
                                ?>
                                <script>
                                    function delete_sql(){
                                        if(confirm("同时会删除该学院下的所有科目信息，您确定要删除吗?")){
                                            return true;
                                        }else{
                                            return false;
                                        }
                                    }
                                </script>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <div class="drpage">
                    <?php
                    if($page!=1){
                        echo "<a href=?page=1  class='fy'>首页</a>&nbsp;";
                        echo "<a href=?page=".($page-1)." class='fy'>上一页</a>&nbsp;";
                    }
                    for ($i=1;$i<=$totalPage;$i++) {
                        echo '<a href="?page='.$i.';" class="fy" style="margin: 3px">'.$i.'</a>';
                    }
                    if($page<$totalPage){
                        echo "<a href=?page=".($page+1)." class='fy'>下一页</a>&nbsp;";
                        echo "<a href=?page=".$page_count." class='fy'>尾页</a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if(isset($_GET['deid'])){
    $id = $_GET['deid'];
    $sql_de = 'DELETE xy_inf,km_inf from xy_inf left join km_inf on xy_inf.xy_id = km_inf.km_belxyid WHERE xy_id ='.$id;
    if (($conn->query($sql_de) == TRUE)){
        echo "<script>alert('删除成功');window.location.href='xyinf.php';</script>";
    }else{
        echo "<script>alert('删除失败');window.location.href='xyinf.php';</script>";
    }
}
echo '</form>';
$conn->close();
?>