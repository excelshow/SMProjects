{%include file="../header.tpl"%} 
<script src="{%base_url()%}assets/jstree/jquery.jstree.js" type="text/javascript"></script> 
<script type="text/javascript">
  
   
    //<![CDATA[
	jQuery.validator.addMethod("checkname",  //addMethod第1个参数:方法名称
        function(value, element, params) {     //addMethod第2个参数:验证方法，参数（被验证元素的值，被验证元素，参数）
			   id = $("#id").val(); //$("#logon_name").val();
			  // alert(id);
			  $.ajax({
                    type: "POST",
                    url: "{%site_url('staff/staff/check_logon_name')%}",
					async:false,
                    data: "logonname="+value+"&id="+id,
                    success: function(msg){
  							// alert(msg);
							//Alert(msg);
						if (value.toUpperCase() == msg.toUpperCase()){   // toUpperCase  大小写转换
							temp_type=false;  
							}else{
							temp_type=true; 
							$('#email').val(value);	 
						}
                    }
                });
				return temp_type; 
			   
			                   //测试是否匹配
        },
        "组织名不能重复！");    //addMethod第3个参数:默认错误信息
		
		
    $(document).ready(function(){
		  // 浏览器的高度和div的高度  
     var height = $(window).height();  
	// var divHeight = $("#localJson").height();  
    $("#localJson").height(height - 185); 
	$("#localJson").css("overflow","auto"); 
	 //div高度大于屏幕高度把屏幕高度赋给div，并出现滚动条  
		 $.ajax({
            type: "GET",
            url: "{%site_url('public/deptlist/deptsys_tree')%}",
            data: "",
            dataType:'json',
            success: function(msg){
                //data = eval(msg);
				val = "{%$staff->rootid%}";
               // postdn(val);
                
				  outree = {"data": "Semir", state : "open", "attr":{"id":"0"},children:  msg};
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
				 
				 postdn(data.rslt.obj.attr("id"));
				 });
									 
            }
        });
		
		  // function adduser start
			 var adduserjs = {
            rules: {
				surname:{required: true,maxlength: 4},
				firstname:{required: true,maxlength: 4},
                logon_name: {required: true,minlength: 2,checkname:''},
				email:{required: true,minlength: 2,checkname:''},
				password:{required: true,minlength: 8},
            },
            messages: {
                surname:{required: "用户姓必填",minlength: "最多4个字符"},
				firstname:{required: "用户名必填",minlength: "最多4个字符"},
				logon_name: {required: " 请输入IT登录名",minlength: "至少2个字符",checkname:'此登录已经存在'},
				email:{required: " 请输入Email地址",minlength: "至少2个字符",checkname:'此email已经存在'},
				password:{required: " 请输入密码",minlength: "至少8个字符"},
            } 
        };

			$('#adduserform').validate(adduserjs);
			// function adduser end
    });
	
	
		 
		  val = "{%$staff->rootid%}";
		 postdn(val);
        function postdn(val){
			 $.ajax({
                type: "POST",
                url: '{%site_url("public/deptlist/deptselect")%}',
                cache:false,
                data: 'id='+val,
                success: function(msg){
                    $("#ouShow").html(msg);
					//$("#ouShowOld").html(msg);
                    // alert(val);
                            
                },
                error:function(){
                    hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                }
            });
        }
    //]]>
</script>
<div class="sidebarLeft ">
 <!--begin dept -->
  <div class="pad10">
    <div class="ouTreeTitle" >组织结构</div>
    <div class="ouTree pad5">
      <div id="localJson"><img src="{%$base_url%}templates/{%$web_template%}/images/loading.gif" width="16" height="16" />Loading...</div>
    </div>
  </div>
  
  <!--end dept --> 
</div>
<div class="sidebarMainTo"  style=" ">
<div class="pad10">
  <div class="title">更改用户所属组织</div>
  <div class="staffadd pad5 " style="  ">
    
    
    <!--begin form --> 
      <form id="adduserform" action="{%site_url("staff/staff/staffmovecomplete")%}" method="post">
        <div  class="formLab">所属组织</div>
        <div class="formcontrol">
       <!-- <div id="ouShowOld" style=" " >
            <div class="fright">请选择新用户所属组织 -></div>
          </div>
          <div class="clearb"></div>-->
          <div id="ouShow" style=" " >
            <div class="fright">请选择新用户所属组织 -></div>
          </div>
          <input name="adOudn" id="adOudn" type="hidden" />
        </div>
        <div class="fleft">
          <div class="formLine clearb" ></div>
          <div  class="formLab">应用系统</div>
          <div class="formcontrol">
            <div   > 
            {%if in_array("ad", explode(',',$staff->appstore)) %}
           <input name="appstore[]" type="checkbox" style="display:none;" value="ad" checked="checked" />
            AD 域
            {%/if%}
            &nbsp;&nbsp;&nbsp;
            {%if in_array("rtx",  explode(',',$staff->appstore)) %}
             <input name="appstore[]" style="display:none;" type="checkbox" value="rtx" checked="checked" />
           RTX
            {%/if%}
             </div>
          </div>
          <div class="formLine  clearb" ></div>
          <div  class="formLab">基本信息</div>
          <div  class="formLabt">姓名：</div>
          <div  class="formLabi"> {%$staff->surname%} {%$staff->firstname%} </div>
          <div class="h10 clearb"> </div>
          <div  class="formLab">&nbsp;</div>
          <div  class="formLabt">IT帐号：</div>
          <div  class="formLabi"> {%$staff->itname%}
            <input name="username" id="username" type="hidden" value="{%$staff->username%}" size="20" maxlength="20"  />
          </div>
          <div class="h10 clearb"> </div>
          <div  class="formLab">&nbsp;</div>
          <div  class="formLabt">邮箱：</div>
          <div  class="formLabi"> {%$staff->email%}@{%$staff->domain%} </div>
        </div>
       
        <div class="formLine clearb " ></div>
        <div  class="formLab">&nbsp;</div>
        <div class="formcontrol">
          <input name="id" id="id" type="hidden" value="{%$staff->id%}" />
          <input name="action" type="hidden" value="modify" />
          <input name="addcomplete" type="submit" value="提交完成" />
          &nbsp;&nbsp;
          <input type="button" onclick="javascript:history.go(-1);" value="放弃" />
        </div>
      </form>
   
    <!--end form -->
     
    <div class="clearb"></div>
  </div>
  <div class="clearb"></div>
</div>
</div>
{%include file="../foot.tpl"%}