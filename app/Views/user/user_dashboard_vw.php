<?php include("header.php"); ?>


<?php 
use App\Models\UserModel;
$db = db_connect();
$this->UserModel = new UserModel($db);

foreach( $singleuser as $user_data){ } 
?>

 
<main id="content">

<section class="uk-section-small" style="background-color: #f1f1f1;">
        <div class="uk-container uk-container" style="max-width:1400px";>
           <div class="uk-margin-top uk-margin-bottom">
              <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-margin-remove-top uk-margin-bottom">
                 <ul class="uk-breadcrumb">
                    <li><a href="./"><span uk-icon="home" class="uk-icon"></span></a></li>
                    <li><span>User Dashboard</span></li>
                 </ul>
              </div>
              <div class="uk-grid" uk-grid="">
                 <div class="uk-width-1-4@m uk-first-column">
                  <div class="uk-card uk-card-default uk-card-body uk-margin-bottom uk-padding-small">
                        
                        <div class="uk-text-center">
                        
                         <img src="<?php echo base_url(); ?>/uploads/<?php if($user_data->profile_image!="") {echo $user_data->profile_image;}else{echo "default.png";}?>" class="uk-border-circle uk-text-right" width="100"><br>
                            <small>Hello,</small>
                            <h4 class="uk-margin-remove"><?= $user_data->full_name;?></h4>
                        </div>
                  </div>
                  <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-padding-remove" style="position: sticky; top: 125px;">
                    <ul class="uk-tab-left uk-list-divider uk-background-default uk-tab mtab" uk-tab="connect: #component-tab-left; animation: uk-animation-fade " tabindex="0" aria-expanded="true">
                       <li class=""><a href="#" aria-expanded="false"> My Orders</a></li>
                        <li class="uk-padding-small uk-padding-remove-horizontal uk-padding-remove-bottom"><a href="#" aria-expanded="false"> Personal Information</a></li>
                        <li><a href="#modal-logout" uk-toggle="" aria-expanded="false"> Logout </a></li>
                        
                     </ul>
                  </div>
                 </div>
                 <div class="uk-width-expand@m">
                    <ul id="component-tab-left" class="uk-switcher " style="touch-action: pan-y pinch-zoom;">
                    <li class="" style="width:100%">
                          <div class="uk-card uk-card-default uk-card-body">
                             <h4 class="uk-heading-line headings"><span>My Orders</span></h4>
                           
                             <div class="uk-overflow-auto">
                                <table  class="uk-table uk-table-divider uk-table-small">
                <thead>
                <tr>
                   <td>Sl No.</td>
                   <td>View</td>
                   <td>Status</td>
                   <td>Order ID</td>
                   <td>Order Date</td>
                   <td>Amount</td>
                   <td>Action</td>
                   
                   
                  
                </tr>
                </thead>
                <tbody>
                                    <?php  
									$i=1;
									$subtotal_price=0;
									foreach($Orderdtls as $order){
									?>
                                    <tr>
                                        <td><?= $i++;?></td>
                                        <td><a href="#modal-center<?= $order->orders_id?>" class="uk-button  uk-button-primary uk-button-small uk-border-rounded" uk-toggle> View</a>
                                        <div id="modal-center<?= $order->orders_id?>" class="uk-modal-container" uk-modal>
    									<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                                        <div>
                                        <table style="width:100%;">
                                        	<tr>
                                            <td><img src="<?php echo base_url(); ?>/uploads/<?= $setting_data->logo;?>" width="120" /></td>
                                            	<td>&nbsp;</td>
                                            	
                                            	<td style="text-align:right;">Order Date:<?= $order->order_id?>
												<br />Order ID : <?= $order->created_date?></td>
                                            </tr>
                                        </table>
                                      <p>&nbsp;</p>
                                        <table width="100%" border="0" cellpadding="5" cellspacing="0" style="border:solid 1px #ccc;" class="uk-table uk-table-small">
                                        <?php
										
										$items=$this->UserModel->IteamDetails($order->order_id);
										?>
  <tr>
    <td style=" width:50px; border: solid 1px #ccc;">Sl no</td>
    <td style=" width:350px; border: solid 1px #ccc;">Product nmae</td>
    <td style=" width:100px; border: solid 1px #ccc;">Qty</td>
    <td style=" width:150px; border: solid 1px #ccc;">Price </td>
    <td style=" width:150px; border: solid 1px #ccc;">Total</td>
  </tr>
<?php  
$j=1;
$sum = 0;
$qty=0;
foreach($items as $produ){ ?>
 <tr>
    <td style=" width:50px; border: solid 1px #ccc;"><?= $j++;?></td>
    <td style=" width:350px; border: solid 1px #ccc;"><?= $produ->productname?><br /></td>
    <td style=" width:100px; border: solid 1px #ccc;"><?= $produ->qty?> </td>
    <td style=" width:150px; border: solid 1px #ccc;">Rs. <?= $produ->price?> </td>
    <td style=" width:150px; border: solid 1px #ccc;">Rs. <?php  $totall= $produ->price*$produ->qty;
		echo number_format($totall, 2, '.', '');
	?>
    <?php  $sum+= $produ->price*$produ->qty;
		   $qty+=$produ->qty;
	?>
    </td>
  </tr>
<?php } ?>
<tr>
    <td colspan="2" style=" width:50px; border: solid 1px #ccc; text-align:right"><strong>TOTAL QTY</strong></td>
    <td style=" width:100px; border: solid 1px #ccc;"><?= $qty?> </td>
    <td style=" width:50px; border: solid 1px #ccc; text-align:right"><strong>TOTAL PRICE</strong></td>
    <td style=" width:150px; border: solid 1px #ccc;">Rs. <?php echo number_format($sum, 2, '.', ''); ?>  </td>
    
  </tr>
  
  <!--<tr>
    <td colspan="3" style=" width:50px; border: solid 1px #ccc; text-align:right; border-bottom:0"></td>
    <td style=" width:50px; border: solid 1px #ccc; text-align:right"><strong>Discount</strong></td>
    
  </tr>-->
  <tr>
    <td colspan="3" style=" width:50px; border: solid 1px #ccc; text-align:right; border-top:0; border-bottom:0"></td>
    <td style=" width:50px; border: solid 1px #ccc; text-align:right"><strong>Shipping Charge</strong></td>
    <td style=" width:150px; border: solid 1px #ccc;">Rs. <?php echo number_format($order->shipping_charge, 2, '.', ''); ?>  </td>
    
  </tr>
  <tr>
    <td colspan="3" style=" width:50px; border: solid 1px #ccc; border-top:0; text-align:right"></td>
    <td style=" width:50px; border: solid 1px #ccc; text-align:right"><strong>GRAND TOTAL</strong></td>
    <td style=" width:150px; border: solid 1px #ccc;">Rs.  <?php echo number_format($order->shipping_charge+$sum, 2, '.', ''); ?>
	
    
    </td>
    
  </tr>
</table>

<h4>Delivery Address</h4>
<?php $addre_id=$order->address_id ?>
<?php  $address11=$this->UserModel->getsingleaddress($addre_id); 
foreach($address11 as $addre){?>

Name : <?=$addre->first_name ?> <?=$addre->last_name ?><br />
Contat No : <?=$addre->number ?><br />
E-Mail :  <?=$addre->email ?><br />

Address : <?=$addre->address1 ?><br />
<?=$addre->adress2 ?>
	
	<?php }
?>


                                        </div>
                                        </div>
                                        </div>
                                        </td>
                                        
                                        <td>
                                         <?php if ($order->status == 0){ ?>
											<a href="#" class="uk-button uk-button-primary uk-button-small uk-border-rounded">New Order </a>
											<?php }elseif ($order->status == 1){?>
                                            <a href="#" class="uk-button button-secondary uk-button-small uk-border-rounded">Processing Order </a>
                                            <?php }elseif ($order->status == 2){?>
                                            <a href="#" class="uk-button btn-success uk-button-small uk-border-rounded">Completed Order </a>
                                            <?php }elseif ($order->status == 3){?>
                                            <a href="#" class="uk-button btn-danger uk-button-small uk-border-rounded">Canceled Order </a>
                                            <?php }elseif ($order->status == 4){?>
                                            <a href="#" class="uk-button uk-button-default uk-button-small uk-border-rounded">Out of Delivery </a>
                                            <?php }elseif ($order->status == 5){?>
                                            <a  href="#" class="uk-button btn-danger uk-button-small uk-border-rounded">order delivered</a>
                                            <?php }?>
                                         
                                        </td>
                                        </td>
                                        
                                        <td><?= $order->order_id?></td>
                                        <td><?= $order->created_date?></td>
                                        <td>Rs.  <?php echo number_format($order->shipping_charge+$sum, 2, '.', ''); ?>   </td>
                                        
                                        
                                        <td>
                                            <?php
                                           $created_date = new DateTime($order->created_date); // create a DateTime object from the created date string
$created_date->add(new DateInterval('PT3H')); // add 3 hours to the DateTime object
$new_date = $created_date; // assign the DateTime object to the $new_date variable
$current_date = new DateTime();

if ($current_date <= $new_date) {
    echo '<a href="javascript:void(0);" onClick="deleteRecord(\''. $order->orders_id .'\');" class="uk-button uk-button-danger">Cancel</a>';
}

                                            ?>
                                            
                                            
                                            
                                          

                                        
                                    </tr>
                                    
                                    <?php }?>
                                   
                                    </tbody>
                
              </table>
                                
                            </div>
     
                          </div>
                       </li>
                       <li class="" style="width:100%">
                          <div class="uk-card uk-card-default uk-card-body">
                             <h4 class="uk-heading-line headings"><span>Personal Information</span></h4>
                             
                             <form action="<?php echo base_url();?>/Home/pro" method="post" enctype="multipart/form-data">
            <div class="form-group">
                  <label for="exampleInputEmail1"> Name</label>
                  <input type="text" class="form-control" name="fullname" id="fullname" value="<?= $user_data->full_name;?>">
                   <?php if(isset($validation)) { ?>
					<span class="text-danger"><?= $error = $validation->getError('fullname'); ?></span>
                    <?php } ?>

                </div>
             
             <div class="form-group">
                  <label for="exampleInputEmail1">Email </label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= $user_data->email;?>">
                  <?php if(isset($validation)) { ?>
				 	<span class="text-danger"><?= $error = $validation->getError('email'); ?></span>
                 <?php } ?>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Contat No </label>
                  <input type="tel" class="form-control" id="contact" name="contact" value="<?= $user_data->contact_no;?>">
                  <?php if(isset($validation)) { ?>
					<span class="text-danger"><?= $error = $validation->getError('contact'); ?></span>
                  <?php } ?>
                </div>
                
                 <div class="form-group">
                  <label for="exampleInputEmail1">Username </label>
                  <input type="text" class="form-control"  value="<?= $user_data->user_name;?>" readonly>
                  
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="text" class="form-control" name="password" id="password" value="<?= base64_decode(base64_decode($user_data->password));?>">
                  <?php if(isset($validation)) { ?>
					<span class="text-danger"><?= $error = $validation->getError('password'); ?></span>
                   <?php } ?>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" class="form-control" id="img" name="img">
                
                <?php if($user_data->profile_image<>''){?>
        <img src="<?php echo base_url();?>/uploads/<?= $user_data->profile_image;?>"  width="100" height="100" >
        <?php }else{?>
         <img src="<?php echo base_url();?>/uploads/default.png" style="width:100px;"  >
        <?php }?>
                
                </div>
                
                
                
            <button class="btn btn-primary" type="submit">submit</button>
            </form>
                             
   
                          </div>
                       </li>
                       
                      
                       
                       
                       <li>
                       	<div id="modal-logout" class="uk-flex-top uk-modal" uk-modal="">
                           <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" aria-expanded="false">
                              <button class="uk-modal-close-default uk-icon uk-close" type="button" uk-close=""></button>
                              <h5 class="uk-text-warning uk-text-center">Are you sure want to logout? Click the button Bellow</h5>
                              <div class="uk-modal-footer uk-text-center">
                                 <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                                 <a href="<?php echo base_url(); ?>/Logout" class="uk-button uk-button-danger" type="button">Logout</a>
                              </div>
                           </div>
                        </div>
                        </li>
                       </ul>
                    </ul>
                 </div>
              </div>
           </div>
        </div>
     </section>



</div>

<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url();?>/Home/cancelorder" method="post">
 <input type="hidden" name="operation" id="operation" value="">
 <input type="hidden" name="user_id" id="user_id" value="">
 </form>
<script type="text/javascript">
function deleteRecord(id){
	$("#operation").val('delete');
	$("#user_id").val(id);
	var conf=confirm("Are you sure want to cancel the order");
	if(conf){
	   $("#frm_deleteBanner").submit();
	}
}
</script>
<?php include("footer.php"); ?>
