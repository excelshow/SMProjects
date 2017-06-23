<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/sms/css/stlye.css" />
<script type="text/javascript">
 	 
        $(document).ready(function(){
			// mode ip
			 $(".ipFun").click(function(){ // 给页面中有caname类的标签加上click函数
                var objTD = $(this);
                var oldText = $.trim(objTD.text()); //  
				//alert(oldText);
                var input = $("<input name='sms_ip' type='text' class='searchTopinput' style=' width:80px;' value='"+oldText+"' />"); // 文本框的HTML代码
                
                objTD.html(input); // 当前td的内容变为文本框效
                 input.click(function() {
                      return false;
                 });
                // 设置文本框的样式
                input.trigger("select");//.trigger("select"); // 全选
                // 文本框失去焦点时重新变为文本
                input.blur(function() {
                    var newText = $(this).val(); // 修改后的名称
                    var input_blur = $(this);
                    // 当老的类别名称与修改后的名称不同的时候才进行数据的提交操作
                    if (oldText != newText) {
                        // 获取该类别名所对应的ID(序号)
                        //alert(objTD.parents('ul').children('input').val());
                        var sId = objTD.parents('li').children('input[name=sm_id]').val();//$.trim(objTD.first().text());
                        var sIp = encodeURI(encodeURI(newText));
                         $.ajax({
                            type: "POST",
                            url: "{%site_url('sms/sms/ip_sms_do')%}",
                            cache:false,
                            data: 'sId='+sId+"&sIp="+sIp,
                            success: function(msg){
                                 objTD.html(newText);
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
		 });
	 
</script>

<div  class="pad5">
  <div class="showDn"></div>
  <div class="h10 clearb"> </div>
  <ul class="ipShow">
    {%foreach from=$ipResult item=row%}
    {%if ($row['smsInfo'] && $row['ipAddress'])%}
    	<li class="useGray">
     {%else%}
         {%if ($row['ipAddress'])%}
            <li class="useGreen">
         {%else%} 
           <li class="useRed">
        {%/if%}
    {%/if%}
     
       {%if ($sysPermission["sms_ip_dept"] == 1  && $row['smsInfo'])%} 
         <div class="ipFun ipAddress">
         {%else%}
          <div class="ipAddress">
         {%/if%} 
    	 {%$row['ipAddress']%}
         </div>
        {%if ($row['smsInfo'])%}
        <input type="hidden" name="sm_id" value="{%$row['smsInfo']->sm_id%}" />
        <div>
        	{%$row['smsInfo']->sms_number%}
            {%$row['smsInfo']->sc_name%}
            </div>
            <div>
            {%$row['smsInfo']->cname%} {%$row['smsInfo']->itname%}
            </div>
            <div ><!--title="{%$row['smsInfo']->deptOu%}"-->
            {%$row['smsInfo']->deptName|truncate:14:"..."%}
            </div>
        {%else%}
        {%/if%}
    {%foreachelse%}
    	无搜索结果，重新输入查询关键字试试。。。
    {%/foreach%}
    </li>
  <ul>
</div>
