<?php
	session_start();
	include('admincp/modules/config.php');
	if(isset($_POST['type'])&&$_POST['type']=='add'){
		$product_id=$_POST['product_id'];
		$product_qty=$_POST['qty'];
		$return_url=base64_decode($_POST['return_url']);
		if($product_qty>10){
			echo '<script>alert("nho hon 10 san pham")</script>';
			echo '<a href="'.$return_url.'">Back</a>';
		}
		$sql="select product_image,product_price,product_title from products where product_id='$product_id' limit 1";
		$run_pro=mysqli_query($conn,$sql);
		$row_pro=mysqli_fetch_array($run_pro);
		if($row_pro){
			$new_pro=array(array('image'=>$row_pro['product_image'],'name'=>$row_pro['product_title'],'id'=>$product_id,'qty'=>$product_qty,'price'=>$row_pro['product_price']));
			if(isset($_SESSION['product'])){
				$found=false;
				foreach($_SESSION['product'] as $cart_itm){
					if($cart_itm['id']==$product_id){
					
					$product[]=array('image'=>$cart_itm['image'],'name'=>$cart_itm['name'],'id'=>$product_id,'qty'=>$product_qty,'price'=>$cart_itm['price']);
					$found=true;
				}else{
					$product[]=array('image'=>$cart_itm['image'],'name'=>$cart_itm['name'],'id'=>$cart_itm['id'],'qty'=>$cart_itm['qty'],'price'=>$cart_itm['price']);
				}
			}
			if($found==false){
				$_SESSION['product']=array_merge($product,$new_pro);
			}else{
				$_SESSION['product']=$product;
			}
			}else{
				$_SESSION['product']=$new_pro;
			}
		}
		header('location:index.php?xem=cart');
	}
	//empty cart
	if(isset($_GET['emptycart'])&&$_GET['emptycart']==1){
		session_destroy();
		$return_url=base64_decode($_GET["return_url"]);
		header('location:'.$return_url);
	}
	//delete cart
	if(isset($_GET['removep'])&&isset($_GET['return_url'])&&isset($_SESSION['product'])){
		$return_url=base64_decode($_GET['return_url']);
		$product_id=$_GET['removep'];
		foreach($_SESSION['product'] as $cart_itm){
		if($cart_itm['id']!=$product_id){
			$product[]=array('image'=>$cart_itm['image'],'name'=>$cart_itm['name'],'id'=>$cart_itm['id'],'qty'=>$cart_itm['qty'],'price'=>$cart_itm['price']);			
		}
		$_SESSION['product']=$product;
		}
		header('location:'.$return_url);
	}
?>