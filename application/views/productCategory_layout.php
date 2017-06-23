 <div class="layoutLeftNav" >
      
        <?php
		//
		if (isset($productDetail)){
			$proId = $productDetail->proId;
			}else{
				$proId = 0;
				}
		
	 	foreach ($productcategory as $row):
		
		?>
		<?php if ($row->parent_id == 0): ?>
         <h1><?php echo $row->class_name ?></h1>
         <ul>
         	<?php
			// print_r($productcategory);
              foreach ($productList as $rowSend):
			  if ($rowSend->classId == $row->class_id){
			?> 
              <li ><a href="<?php echo site_url('info/productDetail/' . $rowSend->proId); ?>" <?php if($proId == $rowSend->proId):?> class="curren" <? endif?>> <?php echo $rowSend->proName ?></a> </li>
            <?php
			  }
			 endforeach
			?> 
           </ul>
         <div class="height1"></div>
		 <?php endif; ?>
       
		<?php
		 endforeach
		?> 
     
       
       </div>