{%include file="../header.tpl"%} 
<script src="{%base_url()%}assets/jstree/jquery.jstree.js" type="text/javascript"></script> 
  
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
	 // 浏览器的高度和div的高度  
     var height = $(window).height();  
	// var divHeight = $("#localJson").height();  
    $("#localJson").height(height - 185); 
	$("#localJson").css("overflow","auto"); 
    //div高度大于屏幕高度把屏幕高度赋给div，并出现滚动条  
     var key ="";
	 var val = "";        
	 postdn("{%$id%}");
	 loadsmslist("{%$id%}",key);
	 $.ajax({
            type: "POST",
            url: "{%site_url('public/deptlist/deptsys_tree_sms')%}",
            data: "id={%$id%}",
            dataType:'json',
            success: function(msg){
                //data = eval(msg); 
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
				  //window.location = "{%site_url('staff/index')%}/" + data.rslt.obj.attr("id");
				  key = "";
				  postdn(data.rslt.obj.attr("id"));
				  loadsmslist(data.rslt.obj.attr("id"),key);
				 });
												 
			}
        });
		
		
		function loadsmslist(val,key){
			 $.ajax({
                type: "POST",
                url: "{%site_url('sms/sms/reports_list')%}/"+val,
                cache:false,
				
                data: 'key='+key,
                success: function(msg){
                    $("#staffshow").html(msg);
					 
					 
                    // alert(val);          
                },
                error:function(){
					jError("出错啦，刷新试试，如果一直出现，可以联系开发人员解决",{
						VerticalPosition : 'center',
						HorizontalPosition : 'center',});
                     
                }
            });
        }		
        function postdn(val){
			 $.ajax({
                type: "POST",
                url: '{%site_url("public/deptlist/deptselect")%}',
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
            });
        }
		
        $('input[name="searchBut"]').click(function(){
			key = $('input[name="searchText"]').val();
			if (key){
				val = '';
				postdn(0);
				loadsmslist(val,key);	
				}
			//loadstaff(data.rslt.obj.attr("id"),key);
		});
		 
        
		
    });
    //]]>
   
</script>
<div id="showLayout" style="display:none;"></div>
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
 
   
    
  <div  class="pageTitleTop">资产管理 &raquo; 统计报表 &raquo; </div>
   
  	 <div id="ouShow" class="pageTitle"  style=" " >
    
        <div class="fright">请选择新用户所属组织 -></div>
      </div>
 <div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
      <select name="t" id="t" class="searchTopinput">
        <option value="1">用户帐号</option>
        <option value="2">资产编号</option>
      </select> <input name="k"  id="k" class="searchTopinput" type="text" /> <input name="searchBut" type="button" class="searchTopbuttom" value=""  />
    </div>
 <div class="h5"></div>
  <div id="staffshow" >
     Load staff info....
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}