<?
$chuanboid = $_GET['chuanboid'];
$date = $_GET['date'];

//判断是否登录

include($_SERVER['DOCUMENT_ROOT'].'/common/conn.php');
include_once ($_SERVER['DOCUMENT_ROOT'].'/common/access.php');

//获取当前PHP文件路径，包括带参数网页路径
$php_file=$_SERVER['PHP_SELF'];
$php_path=array_slice(explode("?",$php_file),0);
$path=$php_path[0];

$logininfo=access::getLoginInfo($conn);
$groupid=$logininfo['groupid'];
$sql_acl="SELECT webpath,acl FROM `OSS_SanMao`.`sys_web_acl` ORDER BY `id`";
$rs=mysql_query($sql_acl,$conn);

while($rows=mysql_fetch_array($rs)){
    $webpath=$rows['webpath'];
    $acl=$rows['acl'];
    $acl_list=split(",",$acl);
    $web[$webpath]=$acl_list;
    }   

if((!isset($_COOKIE['userinfo']))||(!isset($logininfo['groupid']))){
    echo "<script>location.href='/login.php'</script>";
    }
else{
    //没有访问权限跳转到/report/tongji/index.php
    if(array_search($groupid,$web[$path])!=""){
        echo ("<script>location.href=\"/index.php\"</script>");
        }   

    else{
    //把页面类型设为excel
        HEADER('Content-Type: application/vnd.ms-excel');
        HEADER('Accept-Ranges: bytes');
        HEADER('Content-Disposition: attachment; filename='.$chuanboid ."-" .$date);
        HEADER('Pragma: no-cache');
        HEADER('Expires: 0');
        }   
    }   

?>

<html>
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>合作QQ群明细</title>

</head>

<?
//$chuanboid = $_GET['chuanboid'];
//$date = $_GET['date'];

//HEADER('Content-Disposition: attachment; filename='.$chuanboid ."-" .$date);



if(empty($date)) $date=date('Y-m-d');
?>



<?
$table = 'oss_chuanboqun_' . date('Ym',strtotime($date));
$sql=" 
SELECT  DATE,`qqqun`,`qq`,`name`,`chuanboqun_chongfu`,`Qqun_chongfu`,`isdaka` 
FROM  `OSS_SanMao`.$table AS a WHERE a.`chuanboid`='$chuanboid' and a.date='$date'
order by qqqun
";

//echo $sql;
//die;



echo("<table cellSpacing=\"0\" cellpadding=\"1\" width=\"89%\" class=\"sort-table\"  id=\"table-1\" border=1> 
	<thead>  <tr>
	<td>日期</td>
	<td>QQ群</td>
	<td>qq</td>
	<td>传播群重复</td>
	<td>自建群重复</td>
        <td>是否打卡</td>
	</tr>
	</thead> <tbody>");


//echo $sql;
$result = mysql_query($sql,$conn);
while ($row = mysql_fetch_array($result))
{
 
$chuanboid=		$row['chuanboid'];
$qq=		$row['qq'];
$qqqun=		$row['qqqun'];
$isdaka=		$row['isdaka'];
$chuanboqun_chongfu=		$row['chuanboqun_chongfu'];
$Qqun_chongfu=		$row['Qqun_chongfu'];

echo("<tr>
<td>$date </td>
<td  bgcolor=\"#66ffff\">$qqqun</td>
<td bgcolor=\"#E9C2A6\">$qq</td>
<td  bgcolor=\"#66ffff\">$chuanboqun_chongfu</td>
<td bgcolor=\"#E9C2A6\">$Qqun_chongfu</td>
<td bgcolor=\"#66ffff\">$isdaka</td>
</tr>");

}


echo("</tbody> </table>");


?>




<script type="text/javascript">

var st1 = new SortableTable(document.getElementById("table-1"),
["Date", "Number", "Number", "Number", "String","Number","Number", "Number","Number","Number","Number"]);

</script>


<script>
function checkbox()
{
var str=document.getElementsByName("box");
var objarray=str.length;
var chestr="";
for (i=0;i<objarray;i++)
{ 
  if(str[i].checked == true)
  {
   chestr+=str[i].value+",";
  }
} 
if(chestr == "")
{
  alert("至少选择一项");
}
else
{
  //alert("您先择的是："+chestr);
	window.location.href="/report/qqQunTongJi_sort.php?item="+chestr;
}
}
</script>


</html>
