{%include file="../header.tpl"%} 
 <link rel="stylesheet" href="{%$base_url%}templates/{%$web_template%}/tongxun/style.css" type="text/css" />
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
	 loadstaff("{%$id%}",key);
	 $.ajax({
            type:'POST',
            url:'{%site_url("public/deptlist/deptsys_tree")%}',
            data:'id = {%$id%}',
            dataType:'json',
            success:function(msg){
                //data = eval(msg); 
                outree = {data: 'Semir', state : 'open', attr:{'id':'0'},children:  msg};
				$("#localJson").jstree({ 
					'json_data' : {
						'data' : [ outree ]
					},
					'themes' : {
					 	'theme' : 'classic',
						'dots' : true,
						'icons' : true
					},
					"plugins" : [ "themes", "json_data", "ui" ]
				}).bind("select_node.jstree", function (e, data) { 
				  //window.location = "{%site_url('staff/index')%}/" + data.rslt.obj.attr("id");
				  key = "";
				  postdn(data.rslt.obj.attr("id"));
				  loadstaff(data.rslt.obj.attr("id"),key);
				 });
												 
			}
        });
		
		
		function loadstaff(val,key){
			 $.ajax({
                type: "POST",
                url: "{%site_url('tongxun/tongxun/stafflist')%}/"+val,
                cache:false,
				
                data: 'key='+key,
                success: function(msg){
                    $("#staffshow").html(msg);        
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
        };
		
        $('input[name="searchBut"]').click(function(){
			key = $('input[name="searchText"]').val();
			if (key){
				val = '';
				postdn(0);
				loadstaff(val,key);	
				}
			//loadstaff(data.rslt.obj.attr("id"),key);
		});
		  
		
		/////////////////////////////////////////
		
		
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
 
   
    <div class="fright searchTop"><input name="adOudn" id="adOudn" type="hidden" /><input name="searchText"  id="searchText" class="searchTopinput fleft" type="text"/><input name="searchBut" type="button" class="searchTopbuttom fleft" value=""  /></div>
  <div  class="pageTitleTop">用户管 理 &raquo; 基本信息 &raquo; </div>
   
     <form id="deptform" method="post" action="" name="deptform">
  	 <div id="ouShow" class="pageTitle"  style=" " >
    
        <div class="fright">请选择新用户所属组织 -></div>
      </div>
 	</form>
  <div id="staffshow" >
     Load staff info....
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}