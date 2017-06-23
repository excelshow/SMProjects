<?php $this->load->view("header");?>
  <script type="text/javascript">
	$(document).ready(function(){
		$(document).pngFix();
	      // slider ajax html
		 
    });
	</script>
<div id="layout_main" >
    <div class="left">
        
       <div class="left_link" style="" >
        
              <?php 
			  
			  	foreach ($category as $row): 
				 
			  	 
			  ?>
              
            <a href="<?php echo site_url('products/discover/'. $row->class_id )?>" ><?php echo $row->class_name;?></a><br>
             <?php
				 
				endforeach 
				?>
             </div>
    </div>

    <div class="right">
    	<?php $this->load->view("search");?> 
    	<div class="content_link"> 
         <?php echo $menuInfo->menuName;?> > <?php echo $categoryInfo->class_name;?>
        </div> 
        <div class="clear"></div>
        <div class="content_back" >
        <div class="right_content">
       	<div id="content_info" class="content_info_css" >
        	  <?php 
			  	foreach ($products as $prow): 
			  ?>
               <div class="product_item" >
              <table width="100%" border="0">
  <tr>
    <td height="150" align="center" valign="middle"><a href="<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>"><img src='<?php echo base_url()."attachments/product/" ?>/<?php echo $prow->proLogo?>' style="" /></a></td>
    </tr>
  <tr>
    <td height="30"> <a href="<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>"><?php echo $prow->proName?></a></td>
  </tr>
  </table>
             </div>
              	
              <?php
              	endforeach
			  ?>
             <div class="clear"></div>
          </div>
        </div>
        </div>
    </div>
    <div style="clear:both"></div>
</div>
<?php $this->load->view("foot.php");?>
