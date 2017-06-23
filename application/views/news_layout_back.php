<?php $this->load->view("header");?>
<div id="layout_main" >
   <div class="left">
       sdfdsf
        <?php
        	if (!empty($menuChilds)){		 
		?> <div class="left_link" style="" >
        <?php foreach ($menuChilds as $rowm):?>
             
            sdfsdf<a href="<?php echo site_url('info/index/'.$menuInfo->menuUrl."/".$rowm->menuUrl);?>/<?php echo $rowm->id;?>" ><?php echo $rowm->menuName;?></a><br>
            <?php endforeach?>
             </div>
        <?php
			}else{
		?>   
        <div class="left_images" >
         
        </div>
        <?php
			}
		?>
       
        
  </div>

    <div class="right">
    	<?php $this->load->view("search");?> 
    	<div class="content_link"> 
        Home > <?php echo $menuInfo->menuName;?>
        </div><div ></div>
        <div class="clear"></div>
        <div class="content_back">
        <div class="right_content">
        
       	<div id="content_info" class="content_info_css" >
        	<h1><?php echo $menuInfo->menuName;?></h1>
             <?php foreach ($Articles as $row):?>
            <span class="time_right"><?php echo date('Y-m-d',strtotime($row->post_time))?></span>
            <a href="<?php echo site_url('info/newsdetail');?>/<?php echo $row->article_id;?>" ><?php echo $row->title;?></a><br>
            <?php endforeach?>
          </div>
        </div>
        </div>
    </div>
    <div style="clear:both"></div>
</div>
 
<?php $this->load->view("foot.php");?>
