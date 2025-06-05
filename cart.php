
<?php include 'connect.php';
//update query
if(isset($_POST['update_product_quantity']))
{$update_value=$_POST['update_quantity'];
    //echo $update_value;
    $update_id=$_POST['update_quantity_id'];
    //echo $update_id;
    //query
    $update_quantity_query=mysqli_query($conn,"update `cartt` set quantity=$update_value 
    where id=$update_id");
   if($update_quantity_query){
    header('location:cart.php');

   }


}
if(isset($_GET['remove'])){
    $remove_id=$_GET['remove'];
    //echo $remove_id;
    mysqli_query($conn, "Delete from `cartt` where id=$remove_id");
    header('location:cart.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "Delete from `cartt`");
    header('location:cart.php');
}






?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart page</title>
     <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
<!--include header-->
<?php include 'header.php';?>
<div class="container">
    <section class="shopping_cart">
        <h1 class="heading">My Cart</h1>
      <table style="border-collapse: collapse;" border="1">
        <?php
        $select_cartt_products=mysqli_query($conn, "Select * from `cartt`");
        $num=1;
        $grand_total=0;
        if(mysqli_num_rows($select_cartt_products)>0){
        echo" 
        <thead>
            <th>Sr. NO</th>
            <th>Product Name</th>
            <th>Product Image</th>
            <th>Product Price</th>
            <th>Product Quantity</th>
            <th>Total Price</th>
            <th>Action</th>

        </thead>
        <tbody>";
        while($fetch_cartt_products=mysqli_fetch_assoc($select_cartt_products)){
            ?>
<tr>
                <td><?php echo $num?></td>
                <td><?php echo $fetch_cartt_products['name']?></td>
                <td>
                    <img src="images/<?php echo $fetch_cartt_products['image']?>" alt="laptop">                </td>
                <td><?php echo $fetch_cartt_products['price']?></td>
                <td>
            <form action="" method="post">
                <input type="hidden" value="<?php echo $fetch_cartt_products['id']?>" name="update_quantity_id">
                <div class="quantity_box">
                    <input type="number" min="1" value="
                    <?php echo $fetch_cartt_products['quantity']?>" name="update_quantity"
                    >
                    <input type="submit" class="update_quantity"
                    value="update" name="update_product_quantity">
                </div>
            </form>
            </td>
                <td><?php echo $subtotal=number_format ($fetch_cartt_products['price']*
                 $fetch_cartt_products['quantity'])?>/-</td>
                 <td>
                    <a href="cart.php?remove=<?php echo $fetch_cartt_products ['id']?>
                 " onclick="return confirm('Are you sure you want to delete this item')">
                        <i class="fas fa-trash"></i>Remove
                    </a>
                </td>
            </tr>

<?php
$grand_total=$grand_total+($fetch_cartt_products['price']*
                 $fetch_cartt_products['quantity']);
$num++;
        }
        

        }else{
            echo"<div class='empty_text'>Cart is empty</div>";
        }
        
        
        ?>
        
            
        </tbody>
       </table>
<!--php code to remove bottom when cart is empty-->

<!--bottom arae-->
<?php
if($grand_total>0){

    echo "<div class='table_bottom'>
    <a href='shop_products.php' class='bottom_btn'>Continue Shopping</a>
    <h3 class='bottom_btn'>Grand total: <span>$grand_total/-</span></h3>
    <a href='checkout.php' class='bottom_btn'>Proceed to checkout</a>
</div>";

?>



<a href="cart.php?delete_all" class="delete_all_btn" onclick="return confirm('Are you sure you want to delete all item')">
    <i class="fas fa-trash"></i>Delete All
</a>
<?php
}else{
    echo "";
}
?>
    </section>


</div>
</body>
</html>