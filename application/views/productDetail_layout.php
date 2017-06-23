<?php $this->load->view("header");?>
<div id="layout_main" >
 
        <div class="layout_left floatLeft" >
            <?php $this->load->view("productCategory_layout"); ?>
            <?php $this->load->view("login_layout"); ?>
        </div>
 
    <div class="right_home">
    	<div class="content_link"> 
         <a href="/">首页</a> > 
         <a href="<?php echo site_url('products')?>"><?php //echo $menuInfo->menuName;?></a> 
          
         <?php echo $categoryInfo->class_name;?> 
        </div> 
        <div class="clear"></div>
        
        
        
       	<div id="content_info" class="content_info_css" >
        	 
        
    				 
         <h1>
		 <div class="productDetail_pdf floatRight">
                        <?php
                            if ($productDetail->proPdf){
                        ?>
                            <div class="pdf"><a href="<?php echo base_url()."attachments/productPdf/".$productDetail->proPdf?>" target="_blank">下载PDF</a></div>
                        <?php
                            }
                             
                        ?>
                        <div class="printIco"><a href="javascript:;" onclick="window.print();">打印本页</a></div>        
                      <div class="clear"></div>
                  	</div><?php echo $productDetail->proName?>
          </h1>
                      
         <div class="proNameFu">  
         	<?php // echo $productDetail->proNameFu?>
         </div>
         	<div class="proMark floatLeft">
            
            <?php 
				if($productDetail->proPic){
			?>
            <img src='<?php echo base_url()."attachments/product/" ?>/<?php echo $productDetail->proPic?>' />
            <?php		
				}
			?>
            </div>
        	<div class="productDetail floatLeft">
			<?php echo $productDetail->proContent?>
            
            </div>
            <div class="clear height1"></div>
             <div class="clear height1"></div>      
           <div class="productConMore">
		   <?php echo $productDetail->proContentMore?>
           </div>
                  
             
          </div>
    <div style="clear:both"></div>
     <div class="productDetail_pdf floatRight">
                        <?php
                            if ($productDetail->proPdf){
                        ?>
                            <div class="pdf"><a href="<?php echo base_url()."attachments/productPdf/".$productDetail->proPdf?>" target="_blank">下载PDF</a></div>
                        <?php
                            }
                             
                        ?>
                        <div class="printIco"><a href="javascript:;" onclick="window.print();">打印本页</a></div>        
                      <div class="clear"></div>
                  	</div>
</div>
<?php $this->load->view("foot.php");?>
