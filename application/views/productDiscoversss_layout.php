<?php $this->load->view("header");?>
  <script type="text/javascript">
	$(document).ready(function(){
		$(document).pngFix();
	      // slider ajax html
		   // slider ajax html
		$("#content_info").sudoSlider({ 
       // auto:true, // 是否自动播放
		pause:6000,
        prevNext: false,
		//fade: true, // 播放方式
        customLink:'a.customLink',
        updateBefore:true

   		});
		 
    });
	</script>
    <div id="layout_main" >
   <div class="left">    
       <div class="left_link" style="" > 
        <h1><a href="<?php echo site_url('products/category/'. $categoryInfo->class_id )?>"> <?php echo $categoryInfo->class_name;?></a></h1>
         <ul>     <?php 
			  	$classId =  $this->uri->segment(3); 
			  	foreach ($category as $row): 	 
			  ?>
              
           <li> <a href="<?php echo site_url('products/discover/'. $row->class_id )?>" <?php if ($classId == $row->class_id){?> class="curren" <?php }?> ><?php echo $row->class_name;?></a></li>
             <?php
				 
				endforeach 
				?>
               </ul>
               
          <?php 
			  	foreach ($categoryOther as $orow):   	 
			  ?>
               <h1><a href="<?php echo site_url('products/category/'. $orow->class_id )?>"><?php echo $orow->class_name;?></a></h1>
           <?php
				 
				endforeach 
				?> 
             </div>
    </div>

    <div class="right">
    	<?php $this->load->view("search");?> 
    	<div class="content_link"> 
         <a href="<?php echo site_url('products')?>"><?php echo $menuInfo->menuName;?></a> >  <a href="<?php echo site_url('products/category/'. $categoryInfo->class_id )?>"><?php echo $categoryInfo->class_name;?></a> >  <a href="<?php echo site_url('products/discover/'. $discoverInfo->class_id )?>"><?php echo $discoverInfo->class_name;?></a>
        </div> 
        <div class="clear"></div>
         
         <div class="slideMenu">
         	<ul>
             <?php
			 	$i = 0;
             	if ($products1){
					$i++;
			 ?>
             <li><a href="javascript:;" class="customLink" rel="<?php echo $i;?>">Vin Rouge</a></li>
              <?php
				}
				if ($products2){
					$i++;
			 ?>
             <li><a href="javascript:;" class="customLink" rel="<?php echo $i;?>">Vin Blanc</a></li>
              <?php
				}
				if ($products3){
					$i++;
			 ?>
             <li><a href="javascript:;" class="customLink" rel="<?php echo $i;?>">Vin Rosé</a></li>
              <?php
				 
			 }
				if ($products4){
					$i++;
			 ?>
             <li><a href="javascript:;" class="customLink" rel="<?php echo $i;?>">Spiritueux</a></li>
           
                <?php
				 
			 }
				if ($products5){
					$i++;
			 ?>
             <li><a href="javascript:;" class="customLink" rel="<?php echo $i;?>">Champagne</a></li>
               <?php
				 
			 }
				if ($products6){
					$i++;
			 ?>
             <li><a href="javascript:;" class="customLink" rel="<?php echo $i;?>">Blanc de Blancs Brut</a></li>
              <?php
				}
			 ?>
            </ul>
              <div class="clear"></div>
		</div>
        <div class="content_back" >
        <div class="right_content">
       
       	<div id="content_info" class="content_info_css" >
       
 
        
        	<ul> 
            
            <?php
			 	 
             	 if ($products1){
			 ?>
            <li > 
             <?php 
			  	foreach ($products1 as $prow): 
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
               </li>
             <?php
				 }
				 ?>
                
             
              	
                 <?
				 if ($products2){
			 ?><li>
                <?php 
			  	foreach ($products2 as $prow): 
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
			  ?> </li>
             <?php
				 }
				 ?>
                
             
              	
                 <?
				 if ($products3){
			 ?><li>
                 <?php 
				 
			  	foreach ($products3 as $prow): 
			
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
              	 </li>
              <?php
              	endforeach
			  ?>
             <?php
				 }
				 ?>
                
             
              	
                 <?
				 if ($products4){
			 ?><li>
             <?php 
			  	foreach ($products4 as $prow): 
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
			  ?>  </li>
             <?php
				 }
				 ?>
               
             
              	
                 <?
				 if ($products5){
			 ?><li>
             <?php 
			  	foreach ($products5 as $prow): 
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
               </li>
              <?php
			 	}
			 ?>
           	  <?
				 if ($products6){
			 ?><li>
             <?php 
			  	foreach ($products6 as $prow): 
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
               </li>
              <?php
			 	}
			 ?>
            </ul>
             <div class="clear"></div>
          </div>
        </div>
        </div>
    </div>
    <div style="clear:both"></div>
</div>
<?php $this->load->view("foot.php");?>
