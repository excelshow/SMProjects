<?php $this->load->view("header");?>
 
<div id="layout_main">
<?php $this->load->view("search");?> 

    	<div class="content_link_products"> 
          <a href="<?php echo site_url('products')?>"><?php echo $menuInfo->menuName;?></a>
        </div>
         <div class="slideMenu">
         	<ul>
              
            </ul>
              <div class="clear"></div>
		</div>
     <div class="products_map" style="text-align:center;">
     <?php
     	if ($proType == 1){
	?>
    	<a href="<?php echo site_url('products/type/1')?>">View All 红葡萄酒</a>
<?php
			}
	 ?> 
      <?php
     	if ($proType == 2){
	?>
    	View All 白葡萄酒
    <?php
			}
	 ?> 
      <?php
     	if ($proType == 3){
	?>
    	View All 桃红葡萄酒
    <?php
			}
	 ?> 
      <?php
     	if ($proType == 4){
	?>
    	View All 烈酒
    <?php
			}
	 ?> 
     <?php
     	if (!$proType){
	?>
     	<?php 
			  
			  	foreach ($category as $row): 
				 
			  	if ($row->parent_id == 0){
			  ?>
              
<!--<a href="<?php echo site_url('products/category/'. $row->class_id )?>" ><?php echo $row->class_name;?></a>/-->
             <?php
				}
				endforeach 
				?>
     <?php
		}
	 ?>	 
     <embed src="/assets/flash/00/map.swf" width="830" height="520" type="application/x-shockwave-flash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-4445535400000" wmode="transparent" quality="high" menu="false" play="true" loop="true" allowfullscreen="true"></embed>  
 
        </div>
    <div style="clear:both"></div>
</div>
<?php $this->load->view("foot.php");?>

