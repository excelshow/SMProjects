{%include file="../header.tpl"%}
<style>
.dgShow{
	width:49%;
	border:2px solid #CCC;
	font-size:1.0em;
	color:#666;
}
.dgShow .title{ 
	font-size:1.5em;
	color:#666;
	background:#F3F3F3;
	padding:10px;
}
.dgShow span{
	display:inline-block;
	width:40px;
}
.dgShow ul{
	padding:10px;
	list-style:none;
	margin:0;
}
.dgShow ul li{
	line-height:24px;
	padding-left:10px;
}
.dgShow ul li:hover{
	background:#F3F3F3;
	color:#000;
}
</style>
<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function(){
	 $('input[name="dgSync"]').click(function(){
		 hiConfirm('请确认是否要同步加密岗位、密级信息?',null,function(r){
			if(r){
			  $.ajax({
                        type: "POST",
                        url: "{%site_url('permissions/permissions/staff_permission_dg_sync_true')%}",
                        data: "",
						beforeSend:function (){
						},
                        success: function(msg){ 
							 	jSuccess("操作成功! 正在刷新页面...",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									TimeShown : 500
								});
                                 setInterval(function(){window.location.reload();},1000);	
							  
                        },
                    error:function(){
                        hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                    }	   

                    });
			}
			 });
		});
	 
    });
    //]]>
</script>
<div id="showLayout" style="display:none;"> </div>
<div class="h10"></div>
<div class=" "  style=" ">
  <div class="fright searchTop">
    <input name="dgSync" type="submit" class="buttom" value="立即同步"  />
  </div>
  <div  class="pageTitleTop">用户管 理 &raquo; 加密岗位、密级同步 &raquo; </div>
  <div class="h10"></div>
  <div id="staffshow">
    <div class="">
    <div class="dgShow fleft">
    	<div class="title">加密岗位</div>
    	 {%if ($data['dg_quarters'])%}
              <ul>
                {%foreach from=$data['dg_quarters'] item=row%}
                <li><span>{%$row->quarters_id%} </span>
                  
                  {%$row->quarters_name%} </li>
                {%/foreach%}
              </ul>
              {%else%}
              暂无记录 
              {%/if%}
    </div>
     <div class="dgShow fright">
     <div class="title">加密密级</div>
    	{%if ($data['dg_doctype'])%}
              <ul>
                {%foreach from=$data['dg_doctype'] item=row%}
                <li>  
                  <span>{%$row->doctype_id%} </span>
                  
                {%$row->doctype_name%} </li>
                {%/foreach%}
              </ul>
              {%else%}
              暂无记录 
              {%/if%}
    </div>
    <div class="clearb"></div>
    </div>
    <div class=""> </div>
  </div>
</div>
{%include file="../foot.tpl"%}