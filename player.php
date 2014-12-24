<?php
session_start();
include_once("config.lib.php");

if(isset($_POST["f"])){
$supply=$_POST["supply"];
$order=$_POST["order"];
$round=$_POST["round"];
$flag=$_POST["f"];
$seen=0;
$id=$_POST["id"];


//Flag-2 stands for order so same for supply..dont update table just insert new row like below
if($flag==2 || $flag==1){
$sql = "INSERT INTO player (playerid, round, placedorder, supply, flag, seen)
VALUES ($id,$round,$order,$supply,$flag,$seen)";

if ($conn->query($sql) === TRUE) {
    echo " New record created successfully";
} else {
    echo " Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
}

}


if(isset($_POST['show'])){
$id=$_SESSION['id'];
$query ="SELECT * FROM player WHERE playerid=$id";
$result=mysqli_query($conn,$query);
$found=mysqli_num_rows($result); 
$string="<br><table >";

 if($found>0){ 
  $string=$string."<tr style='border: 1px solid rgb(22, 92, 131);'> 
        
        <td width='1000' style='border: 1px solid rgb(22, 92, 131);'><center>ROUND</center></td>
        <td width='1000' style='border: 1px solid rgb(22, 92, 131);'><center>ORDERED</center></td>
        <td width='1000' style='border: 1px solid rgb(22, 92, 131);'><center>DELIVERED</center></td>
        </tr>";
  while($row=mysqli_fetch_array($result)){
   $string=$string."
        <tr style='border: 1px solid rgb(22, 92, 131);'> 
        <td width='1000' style='border: 1px solid rgb(22, 92, 131);'><center>$row[round]</center></td>
        <td width='1000' style='border: 1px solid rgb(22, 92, 131);'><center>$row[placedorder]</center></td>
        <td width='1000' style='border: 1px solid rgb(22, 92, 131);'><center>$row[supply]</center></td>
        </tr>" ;
     }  
  $string=$string."</table>"; 
  echo $string;
   }
else {echo "No records found";} }


if(isset($_POST["curr"])){
if(isset($_POST["prev"])){
$prev=$_POST["prev"];
$query ="SELECT * 
FROM  `player` 
WHERE  `playerid` =  '$prev' AND `seen`='0' AND `flag`='2'
ORDER BY `sno` DESC
LIMIT 1 ";
$set=0;
$result=mysqli_query($conn,$query);
if($result){
$found=mysqli_num_rows($result); 
 if($found>0){ 
  while($row = mysqli_fetch_array($result))
  {
  echo 'You have an order of '.$row['placedorder']; 
  $set=1;
  } 
  $query ="UPDATE player SET seen='1' WHERE playerid =  '$prev' AND seen='0' ORDER BY sno DESC LIMIT 1"; 
  $result=mysqli_query($conn,$query); }  }
  if($set==0)
	echo "None";
 }
 
 if(isset($_POST["next"])){
$next=$_POST["next"];
$query ="SELECT * 
FROM  `player` 
WHERE  `playerid` =  '$next' AND `seen`='0' AND `flag`='1'
ORDER BY `sno` DESC
LIMIT 1 ";
$set=0;
$result=mysqli_query($conn,$query);
if($result){
$found=mysqli_num_rows($result); 

 if($found>0){ 
  while($row = mysqli_fetch_array($result))
  {
  echo "you have received ".$row['supply']." Items"; 
  $set=1;
  } 
  $query ="UPDATE `player` SET `seen`='1' WHERE  `playerid` =  '$next' AND `seen`='0' ORDER BY `sno` DESC LIMIT 1"; 
  $result=mysqli_query($conn,$query); }  }
  if($set==0)
	echo "None";
 }
 }
 
 if(isset($_POST["backup"]) && isset($_POST["curr"]))
 {
$backup=$_POST["backup"];
$curr=$_POST["curr"];
$inventory=$_POST["inventory"];
$porder=$_POST["porder"];

  $sql= "SELECT * FROM  `backup` WHERE  `id` = '$curr'";
  $result=mysqli_query($conn,$sql); 
  $found=mysqli_num_rows($result); 




if ($found>=1) {
  if(isset($_POST['inventory']) && isset($_POST["porder"]))
    {$sql1="UPDATE  `backup` SET  `inventory` =$inventory,`pendingorder` =$porder WHERE  `id` ='$curr'";
       if ($conn->query($sql1) === TRUE) {echo "updated" ;}
        else echo " Error: " . $sql . "<br>" . $conn->error;
    }
  
}
else {
   if(isset($_POST['inventory'])&&isset($_POST['porder']))
    {$sql1="INSERT INTO  `backup` (`id`,`inventory`,`pendingorder`) VALUES ($curr,$inventory,$porder)";
     if ($conn->query($sql1) === TRUE) {echo $curr;}
     else echo " Error: " . $sql . "<br>" . $conn->error;
    }
  
}


}

?>