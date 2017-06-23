<?php $this->load->view("header");?>
<script type="text/javascript" src="<?php echo base_url() ?>assets/pagination/jquery.pagination.js"></script>
 <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url() ?>assets/pagination/pagination.css" />
 <script type="text/javascript">
$(function(){
	//总数目
	var length = $("#hiddenresult .show").length;
	//从表单获取分页元素参数
	var optInit = getOptionsFromForm(); 
	// ---------------------------------------
	// 判读是否显示 分页链接 在 jquery.pageination.js 的 158行 lizd11 
	//--------------------------------
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
			opt.items_per_page=32; //每页显示1项
		})
		return opt;
	}
	//-------------------------------
	function pageselectCallback(page_index, jq){
		// 从表单获取每页的显示的列表项数目
		var items_per_page = 32;
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
<div id="layout_main" >
    <div class="left">
        
       <div class="left_link" style="" >
         <h1><a href="<?php echo site_url('products/typelist/'.$proType."/". $categoryInfo->class_id )?>"><?php echo $categoryInfo->class_name;?></a></h1>
          <ul>    
		  <?php 
			foreach ($category as $row):  
		  ?> 
           <li> <a href="<?php echo site_url('products/typedis/'.$proType."/". $row->class_id )?>" ><?php echo $row->class_name;?></a></li>
             <?php
				 
				endforeach 
				?>
          </ul>
          <?php 
			  	foreach ($categoryOther as $orow):   	 
			  ?>
               <h1><a href="<?php echo site_url('products/typelist/'.$proType."/". $orow->class_id )?>"><?php echo $orow->class_name;?></a></h1>
           <?php
				 
				endforeach 
				?> 
       </div>
    </div>

    <div class="right">
    	<?php $this->load->view("search");?> 
    	<div class="content_link"> 
      <a href="<?php echo site_url('products')?>"> <?php echo $menuInfo->menuName;?></a>
           <?php
     	if ($proType == 1){
	?>
    	> Vins > <a href="<?php echo site_url('products/type/1')?>">Vin Rouge</a>
<?php
			}
	 ?> 
      <?php
     	if ($proType == 2){
	?>
    	> Vins > <a href="<?php echo site_url('products/type/2')?>">Vin Blanc</a>
    <?php
			}
	 ?> 
      <?php
     	if ($proType == 3){
	?>
    	> Vins > <a href="<?php echo site_url('products/type/3')?>">Vin Rosé</a>
    <?php
			}
	 ?> 
      <?php
     	if ($proType == 4){
	?>
    	> <a href="<?php echo site_url('products/type/4')?>">Spiritueux</a>
    <?php
			}
	 ?>  
      <?php
     	if ($proType == 5){
	?>
    	> <a href="<?php echo site_url('products/type/5')?>">Champagne</a>
    <?php
			}
	 ?> 
      <?php
     	if ($proType == 6){
	?>
    	> <a href="<?php echo site_url('products/type/6')?>">Blanc de Blancs Brut</a>
    <?php
			}
	 ?>
     > <a href="<?php echo site_url('products/typelist/'.$proType."/". $categoryInfo->class_id )?>" ><?php echo $categoryInfo->class_name;?></a>
        </div> 
        <div class="clear"></div>
        <div class="slideMenu">
         	<ul>
              
            </ul>
              <div class="clear"></div>
		</div>
        <div class="content_back" > 
        <div class="right_content">
       <script type="text/javascript">
		$(function(){
			$('.scroll-pane').jScrollPane({showArrows:true, scrollbarWidth: 15, arrowSize: 16});
		});
		</script>
       	<div id="content_info" class="content_info_css" >
        	 <div class=" osX">
					<div class="scroll-pane" id="pane2" style="height:520px;">   
             <div id="Searchresult">Loading...</div>
                    <div id="hiddenresult" style="display:none;">
                            <!-- 列表元素 -->
                            <script type="text/javascript">
                                var html = "";
                                <?php 
                                    $totalNum = count($products);
									 
                                ?>
                                 
                                <?php 
                                        foreach ($products as $trow): 
                                ?>
                                //for(var i=1; i<<?=$totalNum?>; i+=1){
                                   // html += "<div class='show product_item'><a href='<?php echo site_url('info/productDetail');?>/<?php echo $trow->proId?>'  target='_blank' ><img src='<?php echo base_url().'attachments/product/' ?>/<?php echo $trow->proLogo?>' /></a><br /><a href='<?php echo site_url('info/productDetail');?>/<?php echo $trow->proId?>' target='_blank' ><?php echo $trow->proName?></a></div>";	
									  html += "<div class='show product_item'> <table width='100%' border='0'>  <tr> <td height='150' align='center' valign='middle'><a href='<?php echo site_url('info/productDetail');?>/<?php echo $trow->proId?>'  target='_blank' ><img src='<?php echo base_url().'attachments/product/' ?>/<?php echo $trow->proLogo?>' /></a></td> </tr> <tr> <td height='30'><a href='<?php echo site_url('info/productDetail');?>/<?php echo $trow->proId?>' target='_blank' ><?php echo $trow->proName?></a></td>   </tr>   </table> </div>";	
                                //}
                                <?php
                                        endforeach
                                      ?>
                                document.getElementById("hiddenresult").innerHTML = html;
                            </script>
                        </div>
                        <div class="clear"></div>
              <div id="Pagination" class="pagination"><!-- 这里显示分页 --></div>
            
             </div>
             </div>
          </div>
        </div>
        </div>
    </div>
    <div style="clear:both"></div>
</div>
<?php $this->load->view("foot.php");?>
