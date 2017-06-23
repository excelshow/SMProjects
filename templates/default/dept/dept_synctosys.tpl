{%include file="../header.tpl"%}
<script type="text/javascript">
   
    //<![CDATA[
   
    $(document).ready(function(){
			 
         
		 $("input[name='syncdept']").click(function(){
			  $("#ouShow").html("同步中,请稍候....");
            $.ajax({
                type: "POST",
                url: '{%site_url("admanager/dept_synctosys")%}',
                cache:false,
                data: 'action=ok',
                success: function(msg){
                    $("#ouShow").html(msg);
                    // alert(val);
                            
                },
                error:function(){
                    hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                }
            });
						
        });
        
	  
       
    });
    //]]>
</script>

<div class="pad5">
     
    <div class=" " style=" margin-left:21%;">

        <div id="ouShow" class="syncshow" >
            同步将用AD域的组织结构覆盖现有系统中的组织结构,请确认操作!!!
              <br />
              <input name="syncdept" id="syncdept" value="同步AD域组织结构到本地(本系统)" type="button" />
        </div>


    </div>
    <div class="clearb"></div>
</div>
{%include file="../foot.tpl"%}