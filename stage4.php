<?php
include_once("config.lib.php");
session_start();
$id=$_POST['name'];
$result = mysqli_query($conn,"SELECT * FROM team WHERE Player4=$id");

while($row = mysqli_fetch_array($result))
  {
  $curr=$row['Player4'];  $prev=$row['Player3'];
  }

//echo $curr.$prev;

echo "<script>var curr=".$curr.";var prev="."$prev".";</script>"
?>


<html>
<head>
<script type="text/javascript" src="jquery.js"></script>
<script src="stage.js"></script>
<script src="transaction.js"></script>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css"> 
<link rel="stylesheet" type="text/css" href="lightbox.css">
<script src="magnific-popup/jquery.magnific-popup.js"></script>
<link rel="stylesheet" type="text/css" href="layout.css">
</head>

<body>
<center>
	<h1>BEER Factory</h1>
</center>

<div class="cost">
<p id="Icost">Inventory cost:<span>200</span></p>
	<p id="Bcost">Backlog cost:<span>300</span></p>
	</div>
	
	
	

<div class="box effect">
	<p id="Round">Round No:<span>1</span></p>
<div class="innerBox1">
<center>
	<h2>DISTRIBUTOR</h2>
</center>
</div>
<div class="innerBox2">
<center>
	<h2>FACTORY</h2>
</center>
<div id="orderdiv" >
	<p>ORDER:</p>
	<input type="number" id="order" class="field" name="order" min="1">
	<input type="button" id="orderbutton" class="button" onclick="order()" value="ok">
</div>
<br>
<div id="supplydiv" >
	<p>SUPPLY:</p>
	<input type="number" id="supply" class="field" name="supply" min="1">
	<input type="button" id="supplybutton" class="button" onclick="supply()" value="ok">

</div>
<br>
<div class="details">
	<p>Pending order:<span id="Porder">20</span></p><br>
	<p>Inventory:<span id="Inv">30</span></p>
	</div>
</div>
<div class="innerBox3">
<center>
	<h2>SHIPPING</h2>
</center>
</div>
</div>
<button id="show" onclick="show()">View Transactions</button>
</body>
<script type="text/javascript">

     var flag=0;

	 function supply(){  
                         flag=1;               
                         $.ajax({
                            type:"post",
                            url:"player.php",
                            data: {id:curr,supply:$('#supply').val(), 
									order:'0',
                                   round:$('#Round>span').text(),
                                   f:flag},
                            success:function(data){
                                //$("#result").html(data);
								alert(data);
								$('#Porder').text(parseInt($('#Porder').text())-parseInt($('#supply').val()));
                             },
                             
                          });
                      }
              function order(){  
                         flag=2;               
                         $.ajax({
                            type:"post",
                            url:"player.php",
                            data: {id:curr,order:$('#order').val(),
									supply:'0',
                                   round:$('#Round>span').text(),
                                   f:flag},
                            success:function(data){
                                //alert("order has been placed");
                      }
                             });
                             
                      }
            
 

 setInterval(function(){$.ajax({
                            type:"post",
                            url:"player.php",
                            data: {curr:curr,prev:prev},
                            success:function(data){
                                if(data!='None')
                                 {setTimeout(function(){ alert(data); 
								 var res = data.split(" ");
								 //alert(res[3]);
								 $('#Porder').text(parseInt($('#Porder').text())+parseInt(res[5]))}, 5000); } 
                                 }
                             });}, 1000);  
                      
</script>

</html>