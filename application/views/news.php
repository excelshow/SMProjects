<?php
	include("header.php")
?>
<div id="layout_main" >
    <div class="left">
        <h1>最新新闻</h1>
        <div >
            <?php foreach ($articlesnew as $row):?>
            <span class="time_right"><?php echo date('Y-m-d',strtotime($row->post_time))?></span>
            <a href="<?php echo site_url('news/newsdetail');?>/<?php echo $row->article_id;?>" ><?php echo $row->title;?></a><br>
            <?php endforeach?>
            <br>
             <a href="<?php echo site_url('news');?>"> <div class="f-left buttom" >&nbsp;更多新闻 >>&nbsp;</div></a>
             <br>
        </div>
    </div>

    <div class="right">
        <h1>新闻中心</h1>
        <div style="line-height: 30px; font-size: 14px;">

            <?php foreach ($articles as $row):?>
            <span class="time_right"><?php echo date('Y-m-d',strtotime($row->post_time))?></span>
            <a href="<?php echo site_url('news/newsdetail');?>/<?php echo $row->article_id;?>" ><?php echo $row->title;?></a><br>
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
