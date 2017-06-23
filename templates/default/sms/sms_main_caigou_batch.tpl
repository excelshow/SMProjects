{%include file="../header.tpl"%} 
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
	 $("#treeTable").treeTable();
		$("table#treeTable tbody tr:odd").addClass('even');
		$("table#treeTable tbody tr").mousedown(function() {
		  $("tr.selected").removeClass("selected"); // Deselect currently selected rows
		  $(this).addClass("selected");
		});
         
        $('table#treeTable tbody tr').hover(
			function () {
				$(this).addClass("hover");
				  var tds = $(this).find('td');
				  //alert();
				  $(this).children("td").children(".funShow").css("display","block");
				   //$(this).children("td").children("div").css("display","block");
			},
			function () {
				$(this).removeClass("hover");
				 
				 $(this).children("td").children(".funShow").css("display","none");
			}
		);
 	
	 
 
	
	 $("button[name='page']").bind("click",function(){
					var url = $(this).val();
					if(url!='undefined'){
						window.location=url;
						 
					}
				});

		
 $("input[name=searchBut]").click(function(){
		var t = $("#t").val();
		var k = $("#k").val()
		window.location = "{%site_url('sms/sms/sms_main_caigou/')%}/0/"+k;
	});

 });
    //]]>
   
</script>
 
<div id="showLayout" style="display:none;">
</div>
<div class="h10"  style=" "> </div>
<div class="">
  
  <div  class="pageTitleTop">资产管理 &raquo; 采购列表 &raquo;</div>
  	<div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
     <div class="fleft" >
     <ul>
     	<li><a href="{%site_url('sms/sms/sms_main_caigou/')%}">零星采购</a></li>
        <li><a href="{%site_url('sms/sms/sms_main_caigou_batch/')%}"  class="curren">批量采购</a></li>
     </ul>
     </div>
     <div class="fright" ><input name="k"  id="k" class="searchTopinput fleft" type="text" /> <input name="searchBut" type="button" class="searchTopbuttom fleft" value=""  /></div>
      <div class="clearb"></div>
    </div>
 
  <div id="showLayout" style="display:none;"></div>
  <div class="h10"></div>
  <div id="staffshow">
   <div class="pageNav">{%$links%}</div>
  	<table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th>OA编号</th>
          <th>资产编号</th>
          <th>财务编号</th>
           <th>类别</th>
           <th>规格/型号</th>
         
           <th>详细配置</th>
            <th>单位</th>
         
         <th>数量</th> 
           <th>申请日期</th>
           
          
        </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->scb_id%}">
        <td>{%$row->oa_number%} </td>
        <td>{%$row->sms_number%}</td>
        <td >{%$row->sap_number%}</td> 
         <td >
           
           {%$row->cate_name%}
          
           </td>
         <td>
         {%$row->sms_size%} </td> 
       
        <td>{%$row->sms_detail%}</td> 
        <td  >
        	{%$row->sms_unit%}
            </td>
        
       
        <td>{%$row->reg_total%}  </td>
         <td>
         
        	{%$row->reg_time%} 
         </td>
         
      </tr>
      {%/foreach%}
     
      {%else%}
      <tr>
        <td colspan="14">暂无信息！</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
  <div class="pageNav">{%$links%}</div>
  </div>
 
</div>
 
{%include file="../foot.tpl"%}