<?php
	include("header.php")
?>
<div id="layout_main" >
    <div class="left">
        <h1>最新下载</h1>
        <div >

            <?php foreach ($downgallerynew as $row):?>
            <span class="time_right"><?php echo date('Y-m-d',strtotime($row->post_time))?></span>
            <a href="<?php echo site_url('down/downdetail');?>/<?php echo $row->downgallery_id;?>" ><?php echo $row->down_name;?></a><br>
            <?php endforeach?>
            <br>
             <a href="<?php echo site_url('down');?>"> <div class="f-left buttom" >&nbsp;更多下载 >>&nbsp;</div></a>
            <br>
        </div>
    </div>

    <div class="right">
        <div class="link"><a href="<?php echo site_url('down/downlist');?>" >下载中心</a> >> 下载详细</div>
         
         
        <div style="font-size: 14px;">

            <?php foreach ($downgallerys as $row):?>
            <h2> <?php echo $row->down_name;?></h2>
            <span  style="font-size:12px;">
                上传日期:<?php echo date('Y-m-d',strtotime($row->post_time))?> &nbsp;&nbsp;&nbsp;&nbsp;
                下载周期：<?php echo date('Y-m-d',strtotime($row->start_time))?>
                    至 <?php echo date('Y-m-d',strtotime($row->end_time))?>

            </span>
            
            <br><br>
             <div class="newcontents">
                <?php echo $row->down_optional;?>
            </div>
            <br><br>
             下载文件列表
            <div class="down_filer" >
                <?php
               // echo $row->gallery_id;
                ?>
                <?php //echo $row->gallery_id?>
                  <?php
                     //echo $row->gallery_id;
                        $res=explode(",",$row->gallery_id);
                       for($i=0;$i<count($res);$i++){
                       if($aa = $this->gallery_model->get_gallery_byid($res[$i]))
                               {
                   ?>
                  
				<div class="filer_tile"><?php  echo $aa->title;?></div>
                <div >
                   <div class="filer_nanme">
                   			<?php
                            //..show pic start
                            $where = 'gallery_id = '.$aa->gallery_id.' AND is_cover = 1';//
                            $filers = $this->gallery_model->get_attachments($where);
                            foreach ($filers as $frow):
								$path = site_url('attachments').$frow->path."/";
                         		$fname = $frow->real_name;
                            ?> 
                               <div style=" float:right;"><img src="<?php echo $path.$fname;?>" width="160"   /></div>                            
                            <?php	
								
                               // echo $frow->file_type;
                            endforeach
                            //....show pic end
                            ?>
                   <ul>
                           <?php
                            //..show pic start
                            $where = 'gallery_id = '.$aa->gallery_id.' AND is_cover = 0';//
                            $filers = $this->gallery_model->get_attachments($where);
                            foreach ($filers as $frow):
							
                            ?> 
                               <li style="background:url(/assets/fileico/<?php echo $frow->file_type; ?>.png) no-repeat;" >
                               <a href="<?php echo site_url('down/download');?>/<?php echo $row->downgallery_id;?>/<?php echo $frow->id;?>" target="_blank" >
                                   点击下载</a>
                               </li>
                            
                            <?php	
								
                               // echo $frow->file_type;
                            endforeach
                            //....show pic end
                            ?>
                     </ul>
                   </div>
                   </div>
				   <div class="filer_des"><?php echo $aa->description;?></div>
  					<br />
                   
                    <?php
  
                               }


                          }
                        ?>
  </div>
            <?php endforeach?>
            <br><br>
            <div align="center"><?php echo $links;?>

                <br>
        </div>
    </div>
</div>
</div>
<?php
 include("foot.php")
?>
