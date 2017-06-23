{%include file="../header.tpl"%} 
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
	 $("#treeTable").treeTable();
		$("table#treeTable tbody tr:odd").addClass('even');
		$("table#treeTable tbody tr").mousedown(function() {
			
			//$("table#treeTable tbody tr td span").show();
		  $("tr.selected").removeClass("selected"); // Deselect currently selected rows
		  $(this).addClass("selected");
		});
         
       
 	 // 浏览器的高度和div的高度  
     
	$("input[name=searchBut]").click(function(){
		 $("#searchForm").submit();
	});
	
	 
 });
    //]]>
   
</script>
 
<div id="showLayout" style="display:none;"></div>
 
<div class=""  style=" "> 
<div class="pad10">
  
     
  <div  class="pageTitleTop">操作日志 &raquo;  </div>
  	<div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
      
      <form id="searchForm" method="post"> 
       <span class="fleft">&nbsp;</span><input name="k" type="text" class="searchTopinput fleft"  id="k" size="40" fs="请输入关键字" /> 
       <input type="submit" name="searchBut" id="searchBut"  class="searchTopbuttom fleft"  value=" " />
        
       </form>
      <div class="clearb"></div>
    </div>
 
  <div id="showLayout" style="display:none;"></div>
  <div class="h10"></div>
  <div id="staffshow">
   
  	<table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>操作人</th>
           <th>操作时间</th>
           <th>操作项目</th>
           <th>操作功能</th>
           <th>关联信息</th>
           <!-- <th >使用人</th>
          <th>部门</th>-->
          </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->ul_id%}">
      
        <td>{%$row->ul_id%}</td> 
         <td>{%$row->ul_username%}</td> 
        <td>
          
           
         {%$row->ul_time%}
          
          
        </td> 
        <td>{%$row->ul_model%} </td>
        <td>
           {%$row->ul_title%} 
        </td>
        <td>
          <div title="">{%$row->ul_function%} //// {%$row->ul_function|truncate:50:"...":true%}</div>
           
        </td>
        
        </tr>
      {%/foreach%}
     
      {%else%}
      <tr>
        <td colspan="9">请输入查询条件</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
 
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}