<?php $this->load->view("header");?>
  <script type="text/javascript">
	$(document).ready(function(){
		$(document).pngFix();
	      // slider ajax html
		$("#content_info").sudoSlider({ 
        auto:true, // 是否自动播放
		pause:6000,
        prevNext: false,
		//fade: true, // 播放方式
        customLink:'a.customLink',
        updateBefore:true

   		});
    });
	</script>
<div id="layout_main" >
    <div class="left">
      
        <div class="left_images" >
        <img src="/attachments/info/20110531150127.about_left.png"  />
        
        </div>
		 <?php
	   	if ($Info->info_pic){ 
	   ?> <?php
		}
		?>
    </div>

    <div class="right">
    	<?php $this->load->view("search");?> 
    	<div class="content_link"> 
        Home > <?php echo $menuInfo->menuName;?>
        </div><div ></div>
        <div class="clear"></div>
        <div class="slideMenu">
         	<ul>
            <li><a href="javascript:;" class="customLink" rel="1">A tab</a></li>
            <li><a href="javascript:;" class="customLink" rel="2">Tab number</a></li>
            <li><a href="javascript:;" class="customLink" rel="3">Tab number 3 </a></li>
            </ul>
		</div>
        <div class="right_content">
        
 

       	<div id="content_info" class="content_info_css" >
        <ul >
        <li >
        <h1><?php echo $Info->title;?></h1>
                <div class="">
                <?php echo $Info->content;?>
                </div>
        </li>
        <li >Content</li>
        <li >Content</li>
    </ul>
        		
          </div>
        </div>
    </div>
    <div style="clear:both"></div>
</div>

<?php $this->load->view("foot.php");?>
