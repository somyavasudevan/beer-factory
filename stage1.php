<?php
include_once("config.lib.php");
session_start();
$id=$_POST['name'];
//$_SESSION['id']=$_POST['name'];
$result = mysqli_query($conn,"SELECT * FROM team WHERE Player1=$id");

while($row = mysqli_fetch_array($result))
  {
  $curr=$row['Player1']; $next=$row['Player2']; 
  }

//echo $curr.$next;
echo "<script>var curr=".$curr.";var next=".$next.";</script>"
?>
<html>
<head>
<script type="text/javascript" src="jquery.js"></script>
<script src="retailer.js"></script>
<script src="stage.js"></script>
<script src="transaction.js"></script>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css"> 
<link rel="stylesheet" type="text/css" href="lightbox.css">
<!-- Magnific Popup core JS file -->
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
	<h2>CUSTOMER</h2>
</center>
</div>
<div class="innerBox2">
<center>
	<h2>RETAILER</h2>
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
	<h2>WHOLESALER</h2>
</center>
</div>
</div>
<button onclick="show()">View Transactions</button>
</body>
<script type="text/javascript">

     var flag=0;

	 function supply(){  
                         flag=1;         
						 $('#Porder').text(parseInt($('#Porder').text())-parseInt($('#supply').val()));
                         
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
                            data: {curr:curr,next:next},
                            success:function(data){
                                if(data!='None')
                                 {setTimeout(function(){ alert(data);
								 var res = data.split(" ");
								 //alert(res[3]);
								 $('#Inv').text(parseInt($('#Inv').text())+parseInt(res[3]));}, 5000); } 
                                 }
                             });}, 1000);         

          
         
</script>
</html>