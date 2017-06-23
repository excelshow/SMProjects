{%include file="../header.tpl"%} 
<script src="{%base_url()%}assets/jstree/jquery.jstree.js" type="text/javascript"></script> 
<script type="text/javascript">

    $(document).ready(function(){
		  // 浏览器的高度和div的高度  
			var height = $(window).height();  
			// var divHeight = $("#localJson").height();  
			$("#localJson").height(height - 185); 
			$("#localJson").css("overflow","auto"); 
			 //div高度大于屏幕高度把屏幕高度赋给div，并出现滚动条  
	 		
			$('input[name="batchSearch"]').click(function(){
			key = $('#staffInfo').val();
			t = $('#type').val();
			if (key){
				  $.ajax({
					type: "POST",
					url: "{%site_url('staff/staff/stafflistBatch')%}/",
					cache:false,
					data: 't='+t+'&key='+key,
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
			//loadstaff(data.rslt.obj.attr("id"),key);
		});
    });
	
	  val = "{%$rootid%}";
		 postdn(val);
        function postdn(val){
			 $.ajax({
                type: "POST",
                url: '{%site_url("dept/admanager/deptselect")%}',
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
 
<div class=" "  style=" ">
<div class="pad10">
  <div class="pageTitleTop">用户批量调岗</div>
   <div class="h10 clearb"> </div>
  <div class="staffadd pad5 " style="  ">
    
    
    <!--begin form --> 
      <form id="adduserform" action="{%site_url("staff/staff/staffmoveBatchcomplete")%}" method="post">
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
            
           <input name="appstore[]" type="checkbox" style="display:none;" value="ad" checked="checked" />
            AD 域
           
             </div>
          </div>
          <div class="formLine  clearb" ></div>
          <div  class="formLab">调岗人员</div>
     <!--     <div  class="formLabt">
          	<select name="type" id="type" class="inputText">
          	  <option value="1">登录帐号</option>
          	  <option value="2">中文名</option>
          	</select>
            &nbsp;
            </div>
            -->
           <div  class="formLabt">
            <textarea name="staffInfo" cols="60" rows="4" class="inputText" id="staffInfo"></textarea>
          </div>
          <div  class="formLabi" style="padding-top:4px;">&nbsp;&nbsp;<input type="button" class="buttom" name="batchSearch" value="查询" /></div>
          
          
           
        </div>
       
        <div class="formLine clearb " ></div>
        <div  class="formLab">&nbsp;</div>
        <div class="formcontrol">
          
          <input name="action" type="hidden" value="modifyBatch" />
          <input name="addcomplete" class="buttom" type="submit" value="提交完成" />
          &nbsp;&nbsp;
          <input type="button" class="buttom" onclick="javascript:history.go(-1);" value="放弃" />
        </div>
        
        
          <div class="formLine clearb " ></div>
          <div id="staffshow" >
          </div>
      </form>
   
    <!--end form -->
     
    <div class="clearb"></div>
  </div>
  <div class="clearb"></div>
</div>
</div>
{%include file="../foot.tpl"%}