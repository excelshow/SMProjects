{%include file="../header.tpl"%}
<script type="text/javascript">

    $(document).ready(function(){
		  
			$('input[name="search"]').click(function(){
			key = $('#staffInfo').val();
			t = $('#type').val();
			if (key){
				  $.ajax({
					type: "POST",
					url: "{%site_url('mtools/stafflistBatch')%}/",
					cache:false,
					data: 't='+t+'&key='+key,
					success: function(msg){
						$("#resultArr").html(msg);
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
</script>
<div class="pad10">
  <div class="pageTitleTop">管理员工具 &raquo; 批量查询</div>
  <div class="h10"></div>
  <div class="staffadd pad5 " style="  ">
    <div class="staffformInfo ">
      <dt>
        <div  class="formLab">员工查询</div>
        <div class="formcontrol">
          <textarea id="staffInfo" class="inputText" rows="8" name="staffInfo" ></textarea>
          <input class="buttom" type="submit" value="提交查询" name="search">
        </div>
      </dt>
    </div>
    <!--result statar -->
    	<div id="resultArr"></div>
    <!--result end -->
  </div>
</div>
{%include file="../foot.tpl"%}