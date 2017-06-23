<?php $this->load->view("header");?>
 <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/galleryshow/gShow.css"/>
<script type="text/javascript" src="<?php echo base_url() ?>assets/galleryshow/jquery.jqia.scroll.js"></script>
 
<div id="layout_main" >
   <div class="left">

        <?php
        	if (!empty($galleryCategory)){		 
		?> <div class="left_news" style="" >
   
      <div class="LeftTBContainer">
            <a href="javascript:;" class="directionAtag topAtag" rel="down" style="width:200px;" ></a>
            <div class="upAndDownUlContainer" style="height:490px;">
        <ul class="">
         <?php
		  $i = 1;
		  foreach ($galleryCategory as $row):
		  if ($i==1){
			  $cssId = "curren";
			  }else{
				$cssId = "";  
				  }
		  ?>
          
           <li> <a href="javascript:;"  onclick="newsdetail('<?php echo $row->class_id;?>');$('.eventCssId').removeClass('curren');$(this).addClass('curren');" class="eventCssId  <?php echo $cssId;?>" ><?php echo $row->class_name;?></a></li>
            <?php
			$i++;
			//echo $i;
			 endforeach?>
           
            </ul>
            </div>
            <a href="javascript:;" class="directionAtag bottomAtag" rel="up" style="width:200px;" ></a>
        </div>
             </div>
        <?php
			}else{
		?>   
        <div class="left_link" style="" >
         Null!
        </div>
        <?php
			}
		?>
       
        
  </div>

    <div class="right">
    	<?php $this->load->view("search");?> 
    	<div class="content_link"> 
       &nbsp;<!-- Home > <?php echo $menuInfo->menuName;?>-->
        </div> 
        
        <div class="clear"></div>
         <div class="slideMenu">
         	<ul>
              
            </ul>
              <div class="clear"></div>
		</div>
        <div class="content_back"> 
        <div class="right_content_new">
        <script language="javascript" type="text/javascript">
		    newsdetail("<?php echo $galleryTop->class_id ?>");
			function newsdetail(val){
				//alert(val);
				 
				$.ajax({
				   type: "POST",
				   url: "<?php echo site_url('info/galleryShow');?>/"+val,
				   data: "",
				   success: function(msg){
					   $("#content_info").html(msg);
					  // alert(msg);
				   }
				});
				}
		</script> 
       	<div id="content_info" > <!--class="content_info_css" -->
        
        	<h1>Loading...</h1>
            
          </div>
        </div>
        </div>
    </div>
    <div style="clear:both"></div>
</div>
<?php $this->load->view("foot.php");?>
