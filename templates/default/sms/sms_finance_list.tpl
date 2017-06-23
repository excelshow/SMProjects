
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
	//	var t = $("#t").val();
		var k = $("#k").val()
		if( k == '输入资产编号或登录名'){
			
		}else{
		window.location = "{%site_url('sms/sms/finance/1')%}/"+k;
		}
	});
	
 
	
	$("button[name=verify]").click(function(){
		    $this = $(this).val();
            hiConfirm('你确定审核通过？',null,function(r){ 
			  if(r){
                    $.ajax({
							  type: "POST",
							  url: "{%site_url('sms/sms/finance_verify')%}",
							  data: "sm_id="+$this,
							  success: function(msg){
								  //alert(msg);
								  if(msg==1){
								   
									jSuccess("操作成功!正在刷新页面，请稍候...",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
									setInterval(function(){window.location.reload();},1000);	
								  }else{
									  alert(msg);
								  }
							  },
							   
						  });
                    return false;		
                }
			}); 
	});

	 
	 $("button[name='page']").bind("click",function(){
					var url = $(this).val();
					if(url!='undefined'){
						window.location=url;
						 
					}
				});
	////////////////////////////////////////
	 $(".sapnumber").click(function(){ // 给页面中有caname类的标签加上click函数
                var objTD = $(this);
                var oldText = $.trim(objTD.text()); //  
				//alert(oldText);
                var input = $("<input name='sap_sapnumber' type='text' class='searchTopinput' style=' width:90px;' value='"+oldText+"' />"); // 文本框的HTML代码
                
                objTD.html(input); // 当前td的内容变为文本框效
                 input.click(function() {
                      return false;
                 });
                // 设置文本框的样式
                input.trigger("focus");//.trigger("select"); // 全选
                // 文本框失去焦点时重新变为文本
                input.blur(function() {
                    var newText = $(this).val(); // 修改后的名称
                    var input_blur = $(this);
                    // 当老的类别名称与修改后的名称不同的时候才进行数据的提交操作
                    if (oldText != newText) {
                        // 获取该类别名所对应的ID(序号)
                        //alert(objTD.parents('ul').children('input').val());
                        var dNum = objTD.parents('td').children('input[name=snumber]').val();//$.trim(objTD.first().text());
                        var sNum = encodeURI(newText);
                         $.ajax({
                            type: "POST",
                            url: "{%site_url('sms/sms/sms_main_edit_sap')%}",
                            cache:false,
                            data: 'snum='+dNum+'&spnum='+sNum,
							contentType: "application/x-www-form-urlencoded; charset=utf-8", 
                            success: function(msg){
                                 objTD.html(newText);
								 jSuccess("操作成功...",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 500,
									  });
                            },
                            error:function(){
                                  input_blur.trigger("focus").trigger("select"); // 文本框全选
                            }
                        });
                         
                    } else {
                        // 前后文本一致,把文本框变成标签
                        objTD.html(newText);
                    }
                });
             });
		 
	/////////////////////////////////////////

 });
    //]]>
   
</script>
 

<div class=""  style=" ">
<div class="pad10">
 
  <div  class="pageTitleTop">资产管理 &raquo; 财务审核 &raquo; 资产异动审核</div>
  	<div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
     
      <div class="fright">
 
      <input name="k" type="text" class="searchTopinput"  id="k" value="输入资产编号或登录名" size="50" />
      <input name="searchBut" type="button" class="searchTopbuttom" value=""  />
    
     <script>
$("#k").focus(function (){
        if (jQuery(this).val() == '输入资产编号或登录名'){
			//alert("sdfsdf");
            jQuery(this).val('');
        }
});

 var kk=$("#k").attr("value");



$(document).ready(function(){
//$('#sub').click(function(e){      如果要按钮的时候才显示文字把这行注释去掉，并注释掉下面的行
$('#k').blur(function(e){
    var kk=$("#k").attr("value");
    if (kk=='') {
        $("#k").attr("value","输入资产编号或登录名");
    }
});
});    
</script>

     
      </div>
        <ul>
    	 <li class="curren">异动审核</li>
     	 <li><a href="{%site_url('sms/sms/finance_input')%}" >入库审核</a></li>
      </ul>
    </div>
 
  <div id="showLayout" style="display:none;"></div>
  <div class="h10"></div>
  <div id="staffshow">
   <div class="pageNav">{%$links%}</div>
  	<table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th rowspan="2">管理编号</th><th rowspan="2">财务编号 </th>
          <th rowspan="2">发票号</th>
           <th   rowspan="2">资产名称</th>
           <th rowspan="2">资产品牌</th>
           <th colspan="2">原使用人</th>
           <th rowspan="2">状态</th>
          <th colspan="2" ><div stlye="" >新使用人</div></th>
         <th rowspan="2">新领用日期</th>
          <th rowspan="2">财务审核</th>
        </tr><tr><th>使用人</th> <th>部门</th><th>使用人</th><th>部门</th></tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->sm_id%}">
        <td>{%$row->sms_number%} </td>
        <td>
        <input type="hidden" name="snumber" value="{%$row->sms_number%}" />
         {%if ($sysPermission["sms_finance"] == 1)%}
        <div class="sapnumber" style="min-width:110px; min-height:20px;">
        {%else%}
         <div>
        {%/if%}
        {%$row->sms_sapnumber%}
        </div>
        </td> 
        <td>
         
        {%$row->check_number%}
        
        </td> 
         <td>
         
         {%$row->sc_name%}</td> 
          <td>
          {%$row->sms_brand%}  </td>
        {%if ($row->staff_old)%}
        <td>{%$row->staff_old->cname%} </td> 
       
        <td title="{%$row->staff_old->deptOu%}">
        {%$row->staff_old->deptName|truncate:10:"..."%}
        </td> 
        {%else%}
         <td colspan="2" >库存</td> 
        
        {%/if%}
        <td>{%if $row->sm_type == 1%}
            	领用
            {%/if%}
            {%if $row->sm_type == 2%}
            	借用
            {%/if%}
			{%if $row->sm_type == 3%}
            	长期借用
            {%/if%}
{%if $row->sm_type == 4%}
            	转移
            {%/if%}
          </td>
        <td>{%$row->cname%} </td> 
        <td title="{%$row->deptOu%}">
        {%$row->deptName|truncate:10:"..."%}
           </td>
        
        <td>
         
        	{%$row->use_time%} 
         </td>
          <td width=80>
             <div  style=" float:right;   ">
        	 <div style=" position:absolute;  margin-left:-40px;">
             {%if ($sysPermission["sms_finance"] == 1)%}
          		 <button class="button" name="verify" type="button" value="{%$row->sm_id%}">审核</button> 
                  {%/if%}
         	</div>
         </div>
          {%if $row->sm_sap_status == 1 %}
            已审核
           {%else%}
          	<span class=fontRed>未审核</span>
          {%/if%}
         </td>
      </tr>
      {%/foreach%}
     
      {%else%}
      <tr>
        <td colspan="12">请输入查询条件</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
  <div class="pageNav">{%$links%}</div>
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}