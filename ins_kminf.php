<script type="text/javascript" src="adjs.js"></script>
<link href="adstyle.css" rel="stylesheet" type="text/css" />
<title>MyKurol管理</title>
<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location:login.php");
    exit();
}
include 'header.php';
include 'leftme.jsp';
include('conn.php');
?>
<div class="bg">
    <div class="con">
        <div class="con_ls">
            <p>添加科目</p>
        </div>
        <div class="con_con">
            <form action="" method="post">
                <dl>
                    <dt>科目：</dt>
                    <dd><input type="text" name="ins_km" id="ins_km"/></dd>
                </dl>
                <dl>
                    <dt>学院：</dt>
                    <dd>
                        <select name="ins_kmxy" id="ins_kmxy">
                            <?php
                            $sql_xy = "select * from xy_inf";
                            $r_xy = $conn -> query($sql_xy);
                            while($row_xy = mysqli_fetch_array($r_xy)){
                                echo '<option value="'.$row_xy['xy_id'].'">'.$row_xy['stu_xy'].'</option>';
                            }
                            ?>
                        </select>
                    </dd>
                </dl>
                <dl>
                    <dt></dt>
                    <dd><input class="con_con_canl" type="submit" name="cancel" value="取消"/>
                        <input class="con_con_bing" type="submit" name="bing" value="确认添加"/></dd>
                </dl>
            </form>
        </div>
    </div>
</div>
<?php
if(isset($_POST['bing'])) {
    if ($_POST['ins_km'] == '') {
        echo "<script>alert('科目不能为空,添加失败');history.back();</script>";
        return false;
    } else {
        $sql_naup = 'INSERT INTO km_inf VALUES(
        null,
        "' . $_POST['ins_km'] . '",
        ' . $_POST['ins_kmxy'] . ')';
        if ($conn->query($sql_naup) == TRUE) {
            echo "<script>alert('添加成功');window.location.href='km_inf.php';</script>";
        } else {
            echo "<script>alert('添加失败');history.back();</script>";
        }
    }
}
if(isset($_POST['cancel'])) {
    echo "<script>window.location.href='km_inf.php';</script>";
}
$conn->close();
?>