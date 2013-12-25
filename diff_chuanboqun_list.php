<?
include($_SERVER['DOCUMENT_ROOT'].'/common/acl.php');
?>
<html>
  <head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>合作QQ群明细</title>

    <script type="text/javascript" src="/resources/scripts/sort/sort.js"></script>
    <link rel="stylesheet" href="/resources/scripts/sort/sort.css" type="text/css"/>
	<script type="text/javascript" src="/resources/scripts/jquery-1.5.2.min.js"></script> 

<script type="text/javascript"> 
  $(function(){ 
       $("#filterName").keyup(function(){ 
           $("table tbody tr") 
                    .hide() 
                    .filter(":contains('"+( $(this).val() )+"')") 
                    .show(); 
       }).keyup(); 
  }) 
</script> 

</head>

日期：<?php echo date('Y-m-d'); ?>
<hr/>

<?


include($_SERVER['DOCUMENT_ROOT'].'/common/conn.php');

$chuanboid = $_GET['chuanboid'];
$date = $_GET['date'];

if(empty($date)) $date=date('Y-m-d');
$table = 'oss_chuanboqun_' . date('Ym',strtotime($date));

?>

<script src="My97DatePicker/My97DatePicker/WdatePicker.js" type="text/javascript"></script>
<form method="get" action="" style="margin:0;padding:0;" method="get" onsubmit="return checkform();">
时间:
<input name='date' type="text" onFocus="WdatePicker({skin:'whyGreen',startDate:'%y-%M-%d',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"/>
传播员：
<input name="chuanboid" type="text" value="<?echo $chuanboid?>"> 
<input name="Submit1" type="submit" value="查询" />
筛选： <input id="filterName" name="filterName" /> 
</form>


<?
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
	window.location.href="http://oss.hrloo.com/report/qqQunTongJi_sort.php?item="+chestr;
}
}
</script>


</html>
