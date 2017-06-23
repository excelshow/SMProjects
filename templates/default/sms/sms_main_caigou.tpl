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
<div class=""  style=" ">
<div class="pad10">
  
  <div  class="pageTitleTop">资产管理 &raquo; 采购列表 &raquo;</div>
  	<div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
     <div class="fleft">
     <ul>
     	<li><a href="{%site_url('sms/sms/sms_main_caigou/')%}" class="curren">零星采购</a></li>
        <li><a href="{%site_url('sms/sms/sms_main_caigou_batch/')%}" >批量采购</a></li>
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
          <th>OA编号</th><th>申请人 </th>
           <th>类别</th>
           <th>主机</th>
         
           <th>显示器</th>
            <th>一体机</th>
         
         <th>笔记本</th>
         <th>手写板</th> 
           <th>申请日期</th>
           <th>装机人</th>
          
        </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->scg_id%}">
        <td>{%$row->oa_number%} </td>
        <td>{%$row->cname%}/{%$row->itname%}</td> 
         <td width="150">
           {%if ($row->reg_type==1)%}
           零星采购
           {%else%}
           批量采购
         {%/if%}
           </td>
         <td>
         {%$row->sms_number_4%} {%$row->sms_ip%}<br />
{%$row->sap_number_4%}
         
         </td> 
       
        <td>{%$row->sms_number_8%}<br />
{%$row->sap_number_8%}</td> 
        <td  >
        	{%$row->sms_number_11%} <br />
{%$row->sap_number_11%}
            </td>
        
       
        <td>{%$row->sms_number_19%}<br />
{%$row->sap_number_19%} </td>
        <td>{%$row->sms_number_39%}<br />
{%$row->sap_number_39%} </td>
         <td>
         
        	{%$row->reg_time%} 
         </td>
         <td>{%$row->so_itname%} </td>
          
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
</div>
 
{%include file="../foot.tpl"%}