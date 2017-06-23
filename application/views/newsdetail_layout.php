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
            <a href="/">首页</a> >  <a href="<?php echo site_url('info/index/' . $menuInfo->menuUrl); ?>" ><?php echo $menuInfo->menuName; ?></a>
        </div>       
       	<div id="content_info"  class="content_info_css" > 
         	<?
            if ($Articles){
			?>
           
        	<h1><?php echo $Articles->title;?></h1>
              <div class="newsTime"><?php echo date('Y-m-d',strtotime($Articles->post_time))?></div>
              <div class="clear"></div>
            <div class="news_detail_pic" >
				<?php 
                if($Articles->article_pic){
                    
                ?>
                <img src="/attachments/article/<?php echo $Articles->article_pic;?>" width="350" height="530" />
                <?php
                }
                ?>
                </div>
                  
                
                  <div class="news_detail" ><?php echo $Articles->content;?></div>
          <?php
			}else
			{
				echo "此条信息已被删除或不存在！";
				}
		  ?>
             
        </div>
     
    </div>
    <div style="clear:both"></div>
</div>
 
<?php $this->load->view("foot.php");?>

         

