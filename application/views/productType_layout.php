<?php $this->load->view("header");?>
<div id="layout_main" >
     
<?php $this->load->view("search");?> 
    	<div class="content_link_products"> 
      <a href="<?php echo site_url('products')?>"> <?php echo $menuInfo->menuName;?></a>
           <?php
     	if ($proType == 1){
	?>
    	> Vins > <a href="<?php echo site_url('products/type/1')?>">Vin Rouge</a>
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
    <embed src="/assets/flash/04/map4.swf" width="830" height="520" type="application/x-shockwave-flash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-4445535400000" wmode="transparent" quality="high" menu="false" play="true" loop="true" allowfullscreen="true"></embed>  
    	 
<?php
			}
	 ?> 
      <?php
     	if ($proType == 2){
	?>
     <embed src="/assets/flash/03/map3.swf" width="830" height="520" type="application/x-shockwave-flash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-4445535400000" wmode="transparent" quality="high" menu="false" play="true" loop="true" allowfullscreen="true"></embed>  
    	 
    <?php
			}
	 ?> 
      <?php
     	if ($proType == 3){
	?>
     <embed src="/assets/flash/01/map1.swf" width="830" height="520" type="application/x-shockwave-flash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-4445535400000" wmode="transparent" quality="high" menu="false" play="true" loop="true" allowfullscreen="true"></embed>  
    	 
    <?php
			}
	 ?> 
      <?php
     	if ($proType == 4){
	?>
     <embed src="/assets/flash/02/map2.swf" width="830" height="520" type="application/x-shockwave-flash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-4445535400000" wmode="transparent" quality="high" menu="false" play="true" loop="true" allowfullscreen="true"></embed> 
    	 
    <?php
			}
	 ?> 
      <?php
     	if ($proType == 5){
	?>
      <embed src="/assets/flash/05/map1.swf" width="830" height="520" type="application/x-shockwave-flash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-4445535400000" wmode="transparent" quality="high" menu="false" play="true" loop="true" allowfullscreen="true"></embed> 
    	 
    <?php
			}
	 ?> 
       <?php
     	if ($proType == 6){
	?>
    <embed src="/assets/flash/06/map1.swf" width="830" height="520" type="application/x-shockwave-flash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-4445535400000" wmode="transparent" quality="high" menu="false" play="true" loop="true" allowfullscreen="true"></embed> 
    	 
    <?php
			}
	 ?> 
        </div>
    <div style="clear:both"></div>
</div>
<?php $this->load->view("foot.php");?>
