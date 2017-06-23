{%include file="../header.tpl"%} 
<script src="{簊e_url()%}assets/jstree/jquery.jstree.js" type="text/javascript"></script> 
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
			},
			function () {
				$(this).removeClass("hover");
			}
		);
 	 // 浏览器的高度和div的高度  
     var height = $(window).height();  
	// var divHeight = $("#localJson").height();  
    $("#localJson").height(height - 185); 
	$("#localJson").css("overflow","auto"); 
    //div高度大于屏幕高度把屏幕高度赋给div，并出现滚动条  
     var key ="";
	 var val = "";        
	 postdn('{%$sc_id%}');
	 //loadstaff("",key);
	 $.ajax({
            type: "POST",
            url: "{%site_url('sms/sms_category_tree')%}",
            data: "id={%$sc_id%}",
            dataType:'json',
            success: function(msg){
                //data = eval(msg); 
                outree =  msg ;
                //alert(msg);
				$("#localJson").jstree({ 
					"json_data" : {
						"data" : [ outree ]
					},
					"themes" : {
					 	"theme" : "classic",
						"dots" : true,
						"icons" : true
					},
					"plugins" : [ "themes", "json_data", "ui" ]
				}).bind("select_node.jstree", function (e, data) { 
				   window.location = "{%site_url('sms/sms_main_list')%}/" + data.rslt.obj.attr("id");
				  key = "";
				 // postdn(data.rslt.obj.attr("id"));
				 // loadstaff(data.rslt.obj.attr("id"),key);
				 });
								 
			}
        });
		
		 function postdn(val){
			 
			 /*$.ajax({
                type: "POST",
                url: '{%site_url("admanager/deptselect")%}',
                cache:false,
                data: 'id='+val,
                success: function(msg){
                    $("#ouShow").html(msg);
                    // alert(val);          
                },
                error:function(){
					jError("出错啦，刷新试试，如果一直出现，可以联系开发人员解决",{
						VerticalPosition : 'center',
						HorizontalPosition : 'center',});
                     
                }
            });*/
        }
		
	$("button[name=smsadd]").click(function(){
		window.location = "{%site_url('sms/staff_sms_add')%}/"+$(this).val();
	});
	$("input[name=searchBut]").click(function(){
		var t = $("#t").val();
		var k = $("#k").val()
		window.location = "{%site_url('sms/index/')%}/"+t+"/"+k;
	});
	
	$("#return").click(function(){
		    $this = $(this).val();
            hiConfirm('确认要回收此资产？',null,function(r){ 
			  if(r){
				 
                    $.ajax({
							  type: "POST",
							  url: "{%site_url('sms/staff_sms_return')%}",
							  data: "sm_id="+$this,
							  success: function(msg){
								  //alert(msg);
								  if(msg==1){
								   
									jSuccess("操作成功!",{
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

	$("button[name=move]").click(function(){
		//window.location = "{%site_url('sms/staff_sms_move')%}/"+$(this).val();
		 $.ajax({
				  type: "POST",
				  url: "{%site_url('sms/staff_sms_move')%}/",
				  data:'id='+$(this).val(),
				  success:function(msg){
					  //alert(msg);
					  if(msg=="0"){
						  // $("tr#"+n).remove();
						  jError("操作失败! ...",{
							  VerticalPosition : 'center',
							  HorizontalPosition : 'center',
							  TimeShown : 1000,
						  });
						
					  }else{
						   $("#showLayout").html(msg);
						   $("#showLayout").show();
							//hiBox('#showLayout','资产转移...',650,'','','.a_close');	
							 $('#smsmoveform').bind("invalid-form.validate").validate(addjs); 
							 $("#close").bind("click",function(){
									 $("#showLayout").html("");
								});
					  }
				  }	   
               });
			   
	});
	 
	var addjs = {
	        rules: {
				itname:{required: true,remote:{
								url: "{%site_url('sms/staff_main_check')%}/"+$("#itname").val(),
								type: "post",
								async:false,
								dataType:"json", 
							//alert($("#useremail").html());
								data: {
									   itname: function () {
                                 	   return $("#itname").val();  
                               		 }
								} 
							}
				}
			},
			messages: {
                itname:{required: "用户登录帐号必填",remote:"无此登录帐号，请确认用户登录帐号"}
			},
			submitHandler : function(){
				 //表单的处理
				  
					 var post_data = $("#smsmoveform").serializeArray();
					 url = "{%site_url('sms/staff_sms_move_com')%}";
					 $.ajax({
						   type: "POST",
							  url: url,
							  async:false,
							  data:post_data,
							  success: function(msg){
								  
								  if (msg == 1 ){
									   jSuccess("Success, current page is being refreshed",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
									 
									 setInterval(function(){window.location.reload();},1000);	
								  }else{
									  jError("操作失败! ",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
								 }
							  }
						  });
				return false;//阻止表单提交
			}
	};
	

 });
    //]]>
   
</script>
<div id="showLayout" style="display:none;"></div>
<div class="sidebarLeft " style="display:none">
  
    <!--begin dept -->
  <div class="pad10">
    <div class="ouTreeTitleZc" >资产类别</div>
    <div class="ouTreeZC pad5">
      <div id="localJson"><img src="{%$base_url%}templates/{%$web_template%}/images/loading.gif" width="16" height="16" />Loading...</div>
    </div>
  </div>
  
  <!--end dept --> 
</div>
<div class=""  style=" ">sidebarMainTo
<div class="pad10">
 
  
     
  <div  class="pageTitleTop">资产管理 &raquo; 资产信息 &raquo; </div>
  	<div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
      <select name="t" id="t" class="searchTopinput">
        <option value="1">用户帐号</option>
        <option value="2">资产编号</option>
      </select> <input name="k"  id="k" class="searchTopinput" type="text" /> <input name="searchBut" type="button" class="searchTopbuttom" value=""  />
    </div>
 <div class="h10"></div>
 <button class="buttom" name="smsadd" type="button" value="">新增用户资产</button>
 <div class="h10"></div>
  <div id="showLayout" style="display:none;"></div>
  <div id="staffshow">
  	<table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th>管理编号</th>
          <th>财务编号</th>
           <th>资产名称</th>
           <th>备注名称</th>
           <th>资产品牌</th>
           <th>资产规格</th>
           <th>详细配置</th>
           <th>使用状态</th>
          <th>使用人</th>
          
          <th>所在地</th>
          <th>入库日期</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->sms_id%}">
        <td>{%$row->sms_number%} </td> 
         <td>{%$row->sms_sapnumber%}</td> 
        <td>
        {%$row->sms_name%}
       
        </td> 
        <td>
          {%$row->sms_bname%}
          </td>
        <td>{%$row->sms_brand%} </td>
        <td>
           {%$row->sms_size%} 
        </td>
        <td> {%$row->sms_detail%} </td>
        
        <td>
         {%$row->sms_status%} 
        </td>
         <td>
         {%$row->sms_status%} 
        </td>
         <td>
         {%$row->sms_local%} 
        </td>
         <td>
         {%$row->sms_time%} 
        </td>
        <td>
         <button class="button" name="move" type="button" value="{%$row->sms_id%}">编辑</button> 
         <button class="button" name="return" id="return" type="button" value="{%$row->sms_id%}">报废</button>
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