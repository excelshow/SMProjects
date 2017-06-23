{%include file="../header.tpl"%} 
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
	  $('[fs]').inputDefault();
	 $("#treeTable").treeTable();
		$("table#treeTable tbody tr:odd").addClass('even');
		$("table#treeTable tbody tr").mousedown(function() {
			
			//$("table#treeTable tbody tr td span").show();
		  $("tr.selected").removeClass("selected"); // Deselect currently selected rows
		  $(this).addClass("selected");
		});
         
        $('table#treeTable tbody tr').hover(
		
			function () {
				$(this).addClass("hover");
				 //$(this).children("td span").css("display","block");
				  $(this).children("td").children("div").css("display","block");
				//alert('sdfsdf');
			},
			function () {
				$(this).removeClass("hover");
				$(this).children("td").children("div").css("display","none");
			}
		);
 	 // 浏览器的高度和div的高度  
     var height = $(window).height();  
	// var divHeight = $("#localJson").height();  
    $("#localJson").height(height - 185); 
	$("#localJson").css("overflow","auto"); 
    //div高度大于屏幕高度把屏幕高度赋给div，并出现滚动条  
     
		
	$("button[name=smsadd]").click(function(){
		window.location = "{%site_url('sms/sms/sms_main_add')%}/"+$(this).val();
	});
	$("button[name=edit]").click(function(){
		window.location = "{%site_url('sms/sms/sms_main_edit')%}/"+$(this).val();
	});
	/*$("input[name=searchBut]").click(function(){
		var t = $("#t").val();
		var k = $("#k").val()
		window.location = "{%site_url('sms/sms/sms_main_list/')%}/"+t+"/"+k;
	});*/
	
	$("button[name=kucui]").click(function(){
		 $this = $(this).val();
		  $.ajax({
							  type: "POST",
							  url: "{%site_url('sms/sms/sms_main_kcChange')%}",
							  data: "sms_id="+$this,
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
	});
	$("button[name=scrap]").click(function(){
		    $this = $(this).val();
            hiConfirm('确认要报废此资产？',null,function(r){ 
			  if(r){
				 
                    $.ajax({
							  type: "POST",
							  url: "{%site_url('sms/sms/sms_main_scrap')%}",
							  data: "sms_id="+$this,
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
 });
    //]]>
   
</script>
{%if ($sysPermission["sms_kuwei"] == 1)%}
<script type="text/javascript">
 	 
        $(document).ready(function(){
			// 六楼代发
			 $("button[name=liulou]").click(function(){ // 给页面中有caname类的标签加上click函数
               
                        // 获取该类别名所对应的ID(序号)
                        //alert(objTD.parents('ul').children('input').val());
                        var sId = $(this).val();//$.trim(objTD.first().text());
                     
                         $.ajax({
                            type: "POST",
                            url: "{%site_url('sms/sms/sms_main_daifa')%}",
                            cache:false,
                            data: 'sId='+sId+'&t=1',
                            success: function(msg){
                                  	jSuccess("操作成功!正在刷新页面，请稍候...",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
									setInterval(function(){window.location.reload();},1000);	
                            },
							error:function(){
								jError("出错啦，刷新试试，如果一直出现，可以联系开发人员解决",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',});
								 
							}
                        }); 
             });
		 /////////////////////////////////
		 // 借用资产
			 $("button[name=jieyong]").click(function(){ // 给页面中有caname类的标签加上click函数
               
                        // 获取该类别名所对应的ID(序号)
                        //alert(objTD.parents('ul').children('input').val());
                        var sId = $(this).val();//$.trim(objTD.first().text());
                     
                         $.ajax({
                            type: "POST",
                            url: "{%site_url('sms/sms/sms_main_daifa')%}",
                            cache:false,
                            data: 'sId='+sId+'&t=3',
                            success: function(msg){
                                  	jSuccess("操作成功!正在刷新页面，请稍候...",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
									window.location.reload();	
                            },
							error:function(){
								jError("出错啦，刷新试试，如果一直出现，可以联系开发人员解决",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',});
								 
							}
                        }); 
             });
		 /////////////////////////////////
			// mode ip
			 $("button[name=cangku]").click(function(){ // 给页面中有caname类的标签加上click函数
               
                        // 获取该类别名所对应的ID(序号)
                        //alert(objTD.parents('ul').children('input').val());
                        var sId = $(this).val();//$.trim(objTD.first().text());
                     
                         $.ajax({
                            type: "POST",
                            url: "{%site_url('sms/sms/sms_main_cangku')%}",
                            cache:false,
                            data: 'sId='+sId,
                            success: function(msg){
                                  	jSuccess("操作成功!正在刷新页面，请稍候...",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
									setInterval(function(){window.location.reload();},1000);	
                            },
							error:function(){
								jError("出错啦，刷新试试，如果一直出现，可以联系开发人员解决",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',});
								 
							}
                        }); 
             });
		 });
	 
</script>
{%/if%}
<div id="showLayout" style="display:none;"></div>
 
<div class=""  style=" "> 
<div class="pad10">
 
   {%if ($sysPermission["sms_add"] == 1)%}
     <div class="fright " style="background:#F7F7F7; padding:3px 20px 4px 20px;">
    
     <button class="buttom" name="smsadd" type="button" value="">新增资产</button>
     <a href="{%site_url('sms/sms/sms_main_add_bitch')%}">批量加入资产</a>
      {%if ($smarty.session.DX_username == "lizhendong")%}
     	
      {%/if%}
     </div>
     
      {%/if%}
     
  <div  class="pageTitleTop">资产管理 &raquo; 仓库资产 &raquo; </div>
  	<div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
     <ul class="">
     	<li><a href="{%site_url('sms/sms/sms_main_list/0')%}" {%if $t==0%} class="curren" {%/if%}>全部库存</a></li>
        <li><a href="{%site_url('sms/sms/sms_main_list/1')%}" {%if $t==1%} class="curren" {%/if%}>六楼代发</a></li>
        <li><a href="{%site_url('sms/sms/sms_main_list/3')%}"  {%if $t==3%} class="curren" {%/if%}>借用资产</a></li>
        <li><form id="searchForm" method="post" ><input name="k" type="text" class="searchTopinput fleft"  id="k" size="40" fs="请输入资产、财务编号关键字" /> <input name="searchBut" type="submit" class="searchTopbuttom fleft" value=""  /></form></li>
     </ul>
     <!--/* <select name="t" id="t" class="searchTopinput fleft">
        <option value="1" {%if $t==1%} selected="selected" {%/if%}></option>
        <option value="2" {%if $t==2%} selected="selected" {%/if%}>六楼代发</option>        
      </select><span class="fleft">&nbsp;</span>*/-->
      
      <div class="clearb"></div>
    </div>
 
  <div id="showLayout" style="display:none;"></div>
  <div class="h10"></div>
  <div id="staffshow">
   <div class="pageNav">{%$links%}</div>
  	<table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th>管理编号</th>
          <th>财务编号</th>
           <th>资产名称</th>
           <th>资产品牌</th>
           <th>资产规格</th>
           <th>软件版权</th>
           <th>仓库</th>
          <!-- <th >使用人</th>
          <th>部门</th>-->
          <th>所在地</th>
          <th>资产归属</th>
          <th>入库日期</th>
          <th>操作人</th>
           
        </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->sms_id%}">
      
        <td>{%$row->sms_number%}</td> 
         <td>{%$row->sms_sapnumber%}</td> 
        <td>
          
          <div  style=" float:right;display:none;">
            <div style=" position:absolute;  margin-left:-80px;">
              {%if ($sysPermission["sms_edit"] == 1)%}
              <button class="button" name="edit" type="button" value="{%$row->sms_id%}">编辑</button>
              {%/if%} 
              {%if ($sysPermission["sms_kcchange"] == 1)%}
              <!-- button class="button" name="kucui" type="button" value="{%$row->sms_id%}">库存</button -->
              {%/if%} 
              {%if ($row->sms_status == 1 && $sysPermission["sms_scrap"]==1)%}
              <button class="button" name="scrap" id="scrap" type="button" value="{%$row->sms_id%}">报废</button>
              {%/if%} 
              
              </div>
            </div>
          {%$row->sc_name%}
          
          
        </td> 
        <td>{%$row->sms_brand%} </td>
        <td>
           {%$row->sms_size%} 
        </td>
        <td>
        <span title="{%$row->sms_cdkey%}">
        {%trim(substr($row->sms_cdkey, 0, 10))%}
        </span>
        </td>
        <td>
         
        
        {%if $row->sms_kuwei == 0%}
        <span class="kuwei  "> 
        仓库
        </span> 
          {%if ($sysPermission["sms_kuwei"] == 1)%}
          <div  style=" float:left;display:none;">
            <div style=" position:absolute;  margin-left:40px;">
            
            <button class="button" name="liulou" type="button" value="{%$row->sms_id%}">六楼(待发)</button>
            <button class="button" name="jieyong" type="button" value="{%$row->sms_id%}">借用资产</button>
            </div></div>
              {%/if%}
        {%/if%}
        {%if $row->sms_kuwei == 1%}
         
         <span class="kuwei  "> 
       六楼(待发)
        </span>
         {%if ($sysPermission["sms_kuwei"] == 1)%}
        
          <div  style=" float:left;display:none;">
            <div style=" position:absolute;  margin-left:40px;">
            <button class="button" name="cangku" type="button" value="{%$row->sms_id%}">仓库</button>
            </div></div>
            
		{%/if%}
        {%/if%}
        {%if $row->sms_kuwei == 2%}
        预发放
        {%/if%}
         {%if $row->sms_kuwei == 3%}
        借用
        {%if ($sysPermission["sms_kuwei"] == 1)%}
        
          <div  style=" float:left;display:none;">
            <div style=" position:absolute;  margin-left:40px;">
            <button class="button" name="cangku" type="button" value="{%$row->sms_id%}">仓库</button>
            </div></div>
            
		{%/if%}
        {%/if%}
     
         </td>
      <!--   
        <td>
          {%if ($row->staff)%}
          {%$row->staff->cname%} 
          {%/if%}
        </td>
        <td>
         {%if ($row->staff)%}
         {%$row->staff->itname%} 
         {%/if%}
        </td>
         <td>
         {%if ($row->staff)%}
         {%$row->staff->deptName%} 
         {%/if%}
        </td>-->
         <td>
         {%$row->sl_name%} 
        </td>
         <td>
         {%$row->sa_name%} 
        </td>
         <td>{%$row->sms_input_time%} </td>
         <td>{%$row->sms_input%} </td>
        
      </tr>
      {%/foreach%}
     
      {%else%}
      <tr>
        <td colspan="14">请输入查询条件</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
  <div class="pageNav">{%$links%}</div>
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}