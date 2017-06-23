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
         
  $("input[name=searchBut]").click(function(){
		var t = $("#t").val();
		var k = $("#k").val()
		window.location = "{%site_url('sms/sms/staff_sms_oa_return/')%}/0/"+k;
	});
 });
    //]]>
   
</script>
 
<div id="showLayout" style="display:none;">
</div>
<div class="h10"  style=" "></div>
<div class=" ">
  
  <div  class="pageTitleTop">资产管理 &raquo; 退仓列表 &raquo;</div>
  	<div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
     <div class="fleft">
    
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
            
         
           <th>资产编号</th>
            
           <th>申请日期</th>
           
        </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->st_id%}">
        <td>{%$row->oa_number%} </td>
        <td>{%$row->cname%}/{%$row->itname%}</td> 
         
       
        <td>{%$row->sms_number%}</td> 
        
         <td>
         
        	{%$row->reg_time%} 
         </td>
         
      </tr>
      {%/foreach%}
     
      {%else%}
      <tr>
        <td colspan="13">暂无信息！</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
  <div class="pageNav">{%$links%}</div>
  </div>
  
</div>
 
{%include file="../foot.tpl"%}