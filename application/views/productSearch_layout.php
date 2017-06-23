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

<div id="layout_main"  >

    <div class="layout_left floatLeft" >
     <?php $this->load->view("productCategory_layout"); ?>
     <?php $this->load->view("login_layout"); ?>
    </div>
    <div class="right_home">
    	 
    	<div class="content_link"> 
         <a href="<?php echo site_url()?>">Home</a>  > Search Result
        </div> 
        
        <div id="content_info"  class="content_info_css" >
        <div class="height1"></div>
        	 <div class="boxGre">
             Search Keyword: <?php echo $keyword; ?>
             </div>
           <div class="height1"></div>
            <?php
			 
             	if ($products1){
			 ?>    
               
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
                                
									 html += "<div class='show product_item'> <table width='100%' border='0'>  <tr> <td height='150' align='center' valign='middle'><a href='<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>'  target='_blank' ><img src='<?php echo base_url().'attachments/product/' ?>/<?php echo $prow->proPic?>' /></a></td> </tr> <tr> <td height='30' valign='top' class='productTitle' align='center'><a href='<?php echo site_url('info/productDetail');?>/<?php echo $prow->proId?>' target='_blank' ><?php echo $prow->proName?></a></td>   </tr>   </table> </div>";	
                                //}
                                <?php
                                        endforeach
                                      ?>
                                document.getElementById("hiddenresult").innerHTML = html;
                            </script>
                        </div>
                        <div class="clear"></div>
              <div id="Pagination" class="pagination"><!-- 这里显示分页 --></div>
             
              <?php
				}
				 
			 ?>
              
           
          
             <div class="clear"></div>
          </div>
        </div>
      
    <div style="clear:both"></div>
</div>
<?php $this->load->view("foot.php");?>
