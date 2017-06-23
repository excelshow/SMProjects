<?php $this->load->view("header");?>
<div id="layout_main" >
    <div class="left">
        
        <div class="left_images" >
        <img src="/assets/images/bingzi.png" width="99" height="420" /></div>
    </div>

    <div class="right">
    	<?php $this->load->view("search");?> 
    	<div class="content_link"> 
         <?php echo $menuInfo->menuName;?>
        </div><div ></div>
        <div class="clear"></div>
        <div class="content_back">
        <div class="right_content">
        
       	<div id="content_info" class="content_info_css" >
        		<h1><?php echo $Articles->title;?></h1>
                <div class="">
                <?php echo $Articles->content;?>
                </div>
          </div>
        </div>
        </div>
    </div>
    <div style="clear:both"></div>
</div>

<?php $this->load->view("foot.php");?>
