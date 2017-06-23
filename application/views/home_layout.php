<?php $this->load->view("header"); ?>
<div id="layout_main"  >

    <div class="layout_left floatLeft" >
     <?php $this->load->view("productCategory_layout"); ?>
     <?php // $this->load->view("login_layout"); ?>
    </div>
    <div class="right_home">
        
        <div   >
        	<script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.sudoSlider.js"></script>
			  <script type="text/javascript">
				$(document).ready(function(){
				  $("#slider3").sudoSlider({ 
					numeric: true,
					fade: true,
					prevNext: false,
				   // startSlide: 3,
					numericText:[' ', ' ', ' ', ' ', ' '],
					//updateBefore: true,
					auto:true 
					});
			
				});
				</script>
               <div id="slider3" class="home_slider">
                    <ul>
                     <?php foreach ($adPics as $row): ?>
                        <li><a href="<?php echo $row->hUrl ?>"><img src="<?php echo base_url()?>attachments/gallery/<?php echo $row->hPic; ?>" /></a></li>
                    <?php endforeach?>  
                    
                    </ul>
                </div>
           
        </div>
        <div class="homeProductList floatLeft">
        		 <?php
			// print_r($productcategory);
              foreach ($productListHome as $rowSend):
			  ?>
              <div class="homeProductList_item" >
              <div class="homeProPic floatLeft">
              <a href="<?php echo site_url('info/productDetail');?>/<?php echo $rowSend->proId?>"><img src='<?php echo base_url()."attachments/product" ?>/<?php echo $rowSend->proLogo?>' /></a>
              	 <div class="homeProMoreLink">
                        <a href="<?php echo site_url('info/productDetail');?>/<?php echo $rowSend->proId?>">产品详细...</a>
                        </div>
              </div>
              <div class="homeProInfo floatLeft">
                        <div class="homeProTitle"><a href="<?php echo site_url('info/productDetail');?>/<?php echo $rowSend->proId?>">
                        <?php echo strip_tags($rowSend->proName)?></a>
                        </div>
                        <div class="homeProMark">
                                <strong>产品描述：</strong><br />
                          <?php echo $rowSend->proMark?>
                        </div>
                       
                </div>
               <div class="clear"></div>
               </div>
              <?php
			 endforeach
			?> 
        </div>
	  <div class="homeNewsList floatRight">
           	<div class="newNavTitle">企业新闻</div>		 
             <?php foreach ($Articles as $row):?>
            
           	 <div class="newsTitle">
             <a href="<?php echo site_url('info/newsdetail');?>/<?php echo $row->article_id;?>" ><?php echo date('Y-m-d',strtotime($row->post_time))?></a>
            </div>
             <div class="newsHomeMore">
			 <strong><?php echo $row->title;?></strong><br />
			 <?php echo substr($row->description,0,105);?>
        </div>
          		 <div class="height1"></div>
                  
			<?php endforeach?>
        <div class="height1"></div>
        <a href="/index.php/info/index/contact"><img src="/assets/images/linkContactus.jpg" width="228" height="63" border="0" /></a>
        <div class="height1"></div>  
      </div>
        <div class="clear"></div>
    </div>
</div>
<?php $this->load->view("foot.php"); ?>
