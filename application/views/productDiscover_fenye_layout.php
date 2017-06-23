<?php $this->load->view("header");?>
 
 <script type="text/javascript" src="<?php echo base_url() ?>assets/pagination/jquery.pagination.js"></script>
 <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url() ?>assets/pagination/pagination.css" />
 <script type="text/javascript">
$(function(){
	//总数目
	var length = $("#hiddenresult .show").length;
	//从表单获取分页元素参数
	var optInit = getOptionsFromForm(); 
	$("#Pagination").pagination(length, optInit);
	 
	function getOptionsFromForm(){
		var opt = {callback: pageselectCallback};
		// 从文本域中收集参数 - 这些空间名与参数名相对应
		 
		//避免demo重引入HTML
		var htmlspecialchars ={ "&":"&amp;", "<":"&lt;", ">":"&gt;", '"':"&quot;"}
		$.each(htmlspecialchars, function(k,v){
			opt.prev_text = "Prev";
			opt.next_text = "Next";
			opt.num_edge_entries =  0; //边缘页数
			opt.num_display_entries= 6; //主体页数
			opt.items_per_page=16; //每页显示1项
		})
		return opt;
	}
	//-------------------------------
	function pageselectCallback(page_index, jq){
		// 从表单获取每页的显示的列表项数目
		var items_per_page = 16;
		var max_elem = Math.min((page_index+1) * items_per_page, length);
		
		$("#Searchresult").html("");
		// 获取加载元素
		for(var i=page_index*items_per_page;i<max_elem;i++){
			$("#Searchresult").append($("#hiddenresult .show:eq("+i+")").clone());
		}
		//阻止单击事件
		return false;
	}
});
</script>
  <script type="text/javascript">
	$(document).ready(function(){
		$(document).pngFix();
	      // slider ajax html
		   // slider ajax html
		$("#content_info").sudoSlider({ 
       // auto:true, // 是否自动播放
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
        
       <div class="left_link" style="" >
        <h1><a href="<?php echo site_url('products/category/'. $categoryInfo->class_id )?>"> <?php echo $categoryInfo->class_name;?></a></h1>
         <ul>     <?php 
			  	$classId =  $this->uri->segment(3); 
			  	foreach ($category as $row): 	 
			  ?>
              
           <li> <a href="<?php echo site_url('products/discover/'. $row->class_id )?>" <?php if ($classId == $row->class_id){?> class="curren" <?php }?> ><?php echo $row->class_name;?></a></li>
             <?php
				 
				endforeach 
				?>
               </ul>
               
          <?php 
			  	foreach ($categoryOther as $orow):   	 
			  ?>
               <h1><a href="<?php echo site_url('products/category/'. $orow->class_id )?>"><?php echo $orow->class_name;?></a></h1>
           <?php
				 
				endforeach 
				?> 
             </div>
    </div>

    <div class="right">
    	
        <div class="content_back" >
        <div class="right_content">
       
       	<div id="content_info" class="content_info_css" >
       
 
        
        	<ul>
            <?php
			 	//print_r($products1);
             	if ($products1){
			 ?>
             <li > 
            
              <div id="Pagination" class="pagination"><!-- 这里显示分页 --></div>
             <div id="Searchresult">Loading...</div>
                    <div id="hiddenresult" style="display:none;">
                            <!-- 列表元素 -->
                            <script type="text/javascript">
                                var html = "";
                                <?php 
                                    $totalNum = count($products1);
									 
                                ?>
                                 
                                <?php 
                                        foreach ($products1 as $prow): 
                                ?>
                                //for(var i=1; i<<?=$totalNum?>; i+=1){
                                 //   html += "<div class='show product_item'><a href='<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>'  target='_blank' ><img src='<?php echo base_url().'attachments/product/' ?>/<?php echo $prow->proLogo?>' /></a><br /><a href='<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>' target='_blank' ><?php echo $prow->proName?></a></div>";
								  html += "<div class='show product_item'> <table width='100%' border='0'>  <tr> <td height='150' align='center' valign='middle'><a href='<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>'  target='_blank' ><img src='<?php echo base_url().'attachments/product/' ?>/<?php echo $prow->proLogo?>' /></a></td> </tr> <tr> <td height='30'><a href='<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>' target='_blank' ><?php echo $prow->proName?></a></td>   </tr>   </table> </div>";		
                                //}
                                <?php
                                        endforeach
                                      ?>
                                document.getElementById("hiddenresult").innerHTML = html;
                            </script>
                        </div>

              </li>
              <?php
				}
				if ($products2){
			 ?>
              	<li>
                <?php 
			  	foreach ($products2 as $prow): 
			  ?>
               <div class="product_item" >
              <table width="100%" border="0">
  <tr>
    <td height="150" align="center" valign="middle"><a href="<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>"><img src='<?php echo base_url()."attachments/product/" ?>/<?php echo $prow->proLogo?>' style="" /></a></td>
    </tr>
  <tr>
    <td height="30"> <a href="<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>"><?php echo $prow->proName?></a></td>
  </tr>
  </table>
              </div>
              	
              <?php
              	endforeach
			  ?>
              </li>
              <?php
				}
				if ($products3){
			 ?>
               <li>
                 <?php 
			  	foreach ($products3 as $prow): 
			  ?>
               <div class="product_item" >
               <table width="100%" border="0">
  <tr>
    <td height="150" align="center" valign="middle"><a href="<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>"><img src='<?php echo base_url()."attachments/product/" ?>/<?php echo $prow->proLogo?>' style="" /></a></td>
    </tr>
  <tr>
    <td height="30"> <a href="<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>"><?php echo $prow->proName?></a></td>
  </tr>
  </table>
              </div>
              	
              <?php
              	endforeach
			  ?>
              </li>
              <?php
				 
			 }
				if ($products4){
			 ?>
             <li>
             <?php 
			  	foreach ($products4 as $prow): 
			  ?>
               <div class="product_item" >
               <table width="100%" border="0">
  <tr>
    <td height="150" align="center" valign="middle"><a href="<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>"><img src='<?php echo base_url()."attachments/product/" ?>/<?php echo $prow->proLogo?>' style="" /></a></td>
    </tr>
  <tr>
    <td height="30"> <a href="<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>"><?php echo $prow->proName?></a></td>
  </tr>
  </table>
              </div>
              	
              <?php
              	endforeach
			  ?>
              <div class="clear"></div>
              </li>
              <?php
				}
			 ?>
           	 
            </ul>
             <div class="clear"></div>
          </div>
        </div>
        </div>
    </div>
    <div style="clear:both"></div>
</div>
<?php $this->load->view("foot.php");?>
