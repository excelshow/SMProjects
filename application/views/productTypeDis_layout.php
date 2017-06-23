<?php $this->load->view("header");?>
 
<div id="layout_main" >
    <div class="left">
        
       <div class="left_link" style="" >
        <h1><a href="<?php echo site_url('products/typelist/'.$proType."/". $categoryInfo->class_id )?>"><?php echo $categoryInfo->class_name;?></a></h1>
         <ul>     <?php 
			  $classId =  $this->uri->segment(4); 
			  	foreach ($category as $row): 
				 
			  	 
			  ?>
              
            <li><a href="<?php echo site_url('products/typedis/'.$proType."/". $row->class_id )?>"  <?php if ($classId == $row->class_id){?> class="curren" <?php }?> ><?php echo $row->class_name;?></a></li>
             <?php
				 
				endforeach 
				?>
                </ul>
              <?php 
			  	foreach ($categoryOther as $orow):   	 
			  ?>
               <h1><a href="<?php echo site_url('products/typelist/'.$proType."/". $orow->class_id )?>"><?php echo $orow->class_name;?></a></h1>
           <?php
				 
				endforeach 
				?> 
             </div>
    </div>

    <div class="right">
    	<?php $this->load->view("search");?> 
    	<div class="content_link"> 
           <a href="<?php echo site_url('products')?>"> <?php echo $menuInfo->menuName;?></a>
           <?php
     	if ($proType == 1){
	?>
    	 Vins > <a href="<?php echo site_url('products/type/1')?>">Vin Rouge</a>
<?php
			}
	 ?> 
      <?php
     	if ($proType == 2){
	?>
    	> Vins > <a href="<?php echo site_url('products/type/2')?>">Vin Blanc</a>
    <?php
			}
	 ?> 
      <?php
     	if ($proType == 3){
	?>
    	> Vins > <a href="<?php echo site_url('products/type/3')?>">Vin Rosé</a>
    <?php
			}
	 ?> 
      <?php
     	if ($proType == 4){
	?>
    	> <a href="<?php echo site_url('products/type/4')?>">Spiritueux</a>
    <?php
			}
	 ?>
      <?php
     	if ($proType == 5){
	?>
    	> <a href="<?php echo site_url('products/type/5')?>">Champagne</a>
    <?php
			}
	 ?> 
      <?php
     	if ($proType == 6){
	?>
    	> <a href="<?php echo site_url('products/type/6')?>">Blanc de Blancs Brut</a>
    <?php
			}
	 ?>
     > <a href="<?php echo site_url('products/typelist/'.$proType."/". $categoryInfo->class_id )?>" ><?php echo $categoryInfo->class_name;?></a>
     > <a href="<?php echo site_url('products/typedis/'.$proType."/". $discoverInfo->class_id )?>"> <?php echo $discoverInfo->class_name;?></a>
        </div> 
        <div class="clear"></div>
        <div class="slideMenu">
         	<ul>
              
            </ul>
              <div class="clear"></div>
		</div>
        <div class="content_back" > 
        <div class="right_content">
       <script type="text/javascript">
		$(function(){
			$('.scroll-pane').jScrollPane({showArrows:true, scrollbarWidth: 15, arrowSize: 16});
		});
		</script>
       	<div id="content_info" class="content_info_css" >
        	<div class=" osX">
					<div class="scroll-pane" id="pane2" style="height:520px;"> 
             <?php 
			 
			  	foreach ($products as $trow): 
			  ?> 
               <div class="product_item" >
              <table width="100%" border="0">
  <tr>
    <td height="150" align="center" valign="middle"><a href="<?php echo site_url('info/productDetail');?>/<?php echo $trow->proId?>"><img src='<?php echo base_url()."attachments/product/" ?>/<?php echo $trow->proLogo?>' style="" /></a></td>
    </tr>
  <tr>
    <td height="30"> <a href="<?php echo site_url('info/productDetail');?>/<?php echo $trow->proId?>"><?php echo $trow->proName?></a></td>
  </tr>
  </table>
              </div>
              	 
              <?php
              	endforeach
			  ?>
                      </div>
</div>  
          </div>
        </div>
        </div>
    </div>
    <div style="clear:both"></div>
</div>
<?php $this->load->view("foot.php");?>
