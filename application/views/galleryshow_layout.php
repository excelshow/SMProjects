<script type="text/javascript">
$(function(){
	var upAndDownUlContainer = $('.upAndDownUlContainer');
	var leftAndRightUlContainer = $('.leftAndRightUlContainer');
	(function(){
		var ul       = $("ul", leftAndRightUlContainer);  
        var li       = $("li", ul);  
        var liSize   = li.size();
        var liWidth  = li.width() + 5;
        var width    = liWidth * liSize;
		ul.css('width',width);
	})();
	$('.directionAtag').click(function(){
		$("div[class]", $(this).parent()).scrollPlug({direction:this.rel,step:10});
		return false;
	});		   
})

</script><?
if(!$gallerys){
	echo "Null!";
	exit();
	}
	 
?>
 <div class="galleryShow">
<div class="galleryLeft">
	<!--<div id="showPicTitle"></div>-->
    &nbsp;
	 <table width="530" height="530" border="0">
  <tr>
    <td align="center" valign="middle"><div id="showPic" class="showPic" >Loading...</div> </td>
    </tr>
</table>
 
	
     
</div>
<div class="galleryRight">

        <div class="boxTBContainer">
            <a href="#" class="directionAtag topAtag" rel="down"></a>
            <div class="upAndDownUlContainer">
                <ul>
             
                 <?php
                // print_r($gallerys);
				 
                  foreach ($gallerys as $row):?>
                     <li><a href="javascript:;" onclick='showBigpic("<?php echo $row->Pic;?>,<?php echo $row->galleryName;?>");' ><img src="<?php echo base_url() ?>attachments/gallery/<?php echo $row->Pic;?>" /></a></li>
                  
                    <?php
					
					 endforeach?>
                </ul>
            </div>
            <a href="#" class="directionAtag bottomAtag" rel="up"></a>
        </div>
 </div>
 <script type="text/javascript">
 //show Pic
 showBigpic("<?php echo $gallerysTop->Pic;?>,<?php echo $gallerysTop->galleryName;?>");
function showBigpic(val){
	//alert(val);//showPic
	var temp = val.split(",");
	//alert(temp[0]);
	var imag = "<img src=<?php echo base_url() ?>attachments/gallery/"+ temp[0] +">";
	//$('#showPic').stop().animate({opacity: '1'},2000);   ;
	$('#showPic').html(imag);
	$('#showPicTitle').html( temp[1]);
	}
 </script>
 <div class="clear"></div>
</div>

