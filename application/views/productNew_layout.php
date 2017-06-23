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
			opt.items_per_page=4; //每页显示1项
		})
		return opt;
	}
	//-------------------------------
	function pageselectCallback(page_index, jq){
		// 从表单获取每页的显示的列表项数目
		var items_per_page = 4;
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
<div id="layout_main">
<?php $this->load->view("search");?> 

    	<div class="content_link_products"> 
         <!-- <a href="<?php echo site_url('products')?>"><?php echo $menuInfo->menuName;?></a>-->
        </div>
         <div class="slideMenu">
         	<ul>
              
            </ul>
              <div class="clear"></div>
		</div>
     <div class="products_map" style="text-align:center; padding-top:60px;">
     <script type="text/javascript">
		$(function(){
			$('.scroll-pane').jScrollPane({showArrows:true, scrollbarWidth: 15, arrowSize: 16});
		});
		</script>
     <div id="Searchresult">Loading...</div>
                    <div id="hiddenresult" style="display:none;">
                            <!-- 列表元素 -->
                            <script type="text/javascript">
                                var $html = "";
                                <?php 
                                    $totalNum = count($newproducts);
									 
                                ?>
                                 
                                <?php 
                                        foreach ($newproducts as $prow):
										
										$str = str_replace("\n",  "",  $prow->seo_description);
										$str = str_replace("\r",  "",  $str);
                                ?>
                                	
									  $html += "<div class='show newProducts'><div class='NPcontents'><div class='NPpic'><a href='<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>'><img src='<?php echo base_url().'attachments/product' ?>/<?php echo $prow->proPic?>'  height='300' /></a></div><div class='NPTitle'><a href='<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId;?>' ><?php echo $prow->proName;?></a></div>   <div class='NPInfo'><div class='osX'><div class='scroll-pane' style=' height:180px;'  ><?php echo $str;?></div></div></div><div class='NPfoodpic'><img src='<?php echo base_url()."attachments/product" ?>/<?php echo $prow->proFoodPic?>' /></div></div></div>";
									 
                               
                                <?php
                                        endforeach
                                      ?>
									    
                                document.getElementById("hiddenresult").innerHTML = $html;
                            </script>
                        </div>
                        <div class="clear"></div>
              <div id="Pagination" class="pagination"><!-- 这里显示分页 --></div>
     
     
      
 
        </div>
    <div style="clear:both"></div>
</div>
<?php $this->load->view("foot.php");?>

