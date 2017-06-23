<?php $this->load->view("header");?>
 
<div id="layout_main" >
   
        <div class="layout_left floatLeft" >
            <?php $this->load->view("productCategory_layout"); ?>
            <?php $this->load->view("login_layout"); ?>
        </div>
  

    <div class="right_home">
    	<div class="content_link"> 
           <a href="/">首页</a> > <a href="<?php echo site_url('info/index/product')?>"><?php echo $menuInfo->menuName;?></a>
        </div> 
        <div class="clear"></div>
        <div id="content_info"  class="content_info_css" > 
        <?php
		$index = 0;
		 
		foreach ($productcategory as $row):
		
		?>
		<?php if ($row->parent_id == 0): ?>
         <h1><?php echo $row->class_name ?></h1>
          <div class="productList">
         	 <?php
			// print_r($productcategory);
              foreach ($productList as $rowSend):
			
			  if ($rowSend->classId == $row->class_id){
				// $productList = $this->product_model->get_productlist_byClassid();
               
			  ?>
              <div class="product_item" >
              <table width="100%" border="0">
              <tr>
                <td height="150" align="center" valign="middle"><a href="<?php echo site_url('info/productDetail');?>/<?php echo $rowSend->proId?>"><img src='<?php echo base_url()."attachments/product/" ?>/<?php echo $rowSend->proPic?>' style="" /></a></td>
                </tr>
              <tr>
                <td height="30" valign="top" class="productTitle"> <a href="<?php echo site_url('info/productDetail');?>/<?php echo $rowSend->proId?>"><?php echo $rowSend->proName?></a></td>
              </tr>
              </table>
                         </div>
              <?php
           
			  }
			 endforeach
			?> 
        </div>
        
		 <?php endif; ?>
        <div class="clear"></div>
		<?php
		 endforeach
		?> 
        </div>
    </div>
    <div style="clear:both"></div>
</div>
<?php $this->load->view("foot.php");?>
