{%include file="../header.tpl"%} 
<script src="{%base_url()%}assets/jstree/jquery.jstree.js" type="text/javascript"></script> 
<script type="text/javascript">
   
    //<![CDATA[
     
    $(document).ready(function(){
			 // 浏览器的高度和div的高度  
     var height = $(window).height();  
	// var divHeight = $("#localJson").height();  
    $("#localJson").height(height - 185); 
	$("#localJson").css("overflow","auto"); 
    //div高度大于屏幕高度把屏幕高度赋给div，并出现
	
        $.ajax({
            type: "GET",
            url: "{%site_url('public/deptlist/deptsys_tree')%}",
            data: "",
            dataType:'json',
            success: function(msg){
                //data = eval(msg);
                postdn(0);
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
		var val ="";
        function postdn(val){
            $.ajax({
                type: "POST",
                url: '{%site_url("bqq/bqq/dept_list")%}', // link url
                cache:false,
                data: 'id='+val,
                success: function(msg){
                    $("#ouShow").html(msg);
                    // alert(val);
                            
                },
                error:function(){
                    hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                }
            });
        }
	  
       
    });
    //]]>
</script>
<div class="sidebarLeft"> 
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
  <div class="pad5">
    <div id="ouShow" style="" > Loading..... </div>
  </div>
  <div class="clearb"></div>
</div>
{%include file="../foot.tpl"%}