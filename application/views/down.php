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
        <h1>下载中心</h1>
         
        <div style="font-size: 14px;">

            <?php foreach ($downgallerys as $row):?>
            <span class="time_right"><?php echo date('Y-m-d',strtotime($row->post_time))?></span>
            <a href="<?php echo site_url('down/downdetail');?>/<?php echo $row->downgallery_id;?>" ><?php echo $row->down_name;?></a>
            <br><span style="padding-left: 70px; font-size: 10px;">
                Down Time:<?php echo date('Y-m-d',strtotime($row->start_time))?> to <?php echo date('Y-m-d',strtotime($row->end_time))?>
                Inclue filers:<?php echo count(explode(',',$row->gallery_id))-1 ;?></span>
            <br><br>
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
