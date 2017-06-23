<?php $this->load->view("header");?>
<div id="layout_main" >
   <div class="layout_main">
        <div class="layout_left floatLeft" >
            <?php $this->load->view("productCategory_layout"); ?>
            <?php $this->load->view("login_layout"); ?>
        </div>
    </div>

     <div class="right_home">

        <div class="content_link">
            <a href="/">首页</a> > <?php echo $menuInfo->menuName; ?>
        </div>       
       	<div id="content_info"  class="content_info_css" > 
         
        	<h1><?php echo $menuInfo->menuName;?></h1>
            <div class="right_content_new">
             <?php foreach ($Articles as $row):?>
             <div class="newsTime"><?php echo date('Y-m-d',strtotime($row->post_time))?></div>
           	 <div class="newsTitle">
             <a href="<?php echo site_url('info/newsdetail');?>/<?php echo $row->article_id;?>" ><?php echo $row->title;?></a>
             </div>
             <div class="newsMore"><?php echo $row->description;?></div>
          		 <div class="height1"></div>
                 <div class="height1"></div>
			<?php endforeach?>
            </div>
        </div>
     
    </div>
    <div style="clear:both"></div>
</div>
 
<?php $this->load->view("foot.php");?>
