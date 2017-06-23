<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function(){
	 
		$("button[name='page']").bind("click",function(){
					var url = $(this).val();
					var key = $('input[name="searchText"]').val();
					if(url!='undefined'){
						$.post(url,{ key: key},function(data){
							$('#staffshow').html(data)
						});
					}
				});
			 
    });
    //]]>
</script>
 <div class="pageNav">{%$links%}</div>
      <div class="h10"></div> 
      {%if ($data)%}
      {%$rootDeptname = ''%}
      <div class="showStaffList">
      <div class="showTitle">
      <div class="showTop" >
          <ul class="showUltop">
            <li class="showTab1"><strong>姓名</strong></li>
            <li class="showTab2"><strong>电话</strong></li>
            <li class="showTab3"><strong>手机</strong></li>
          </ul>       
      </div>
      <div class="showTop" >
          <ul class="showUltop">
            <li class="showTab1"><strong>姓名</strong></li>
            <li class="showTab2"><strong>电话</strong></li>
            <li class="showTab3"><strong>手机</strong></li>
          </ul>     
      </div>
       <div class="showTop" >
          <ul class="showUltop">
            <li class="showTab1"><strong>姓名</strong></li>
            <li class="showTab2"><strong>电话</strong></li>
            <li class="showTab3"><strong>手机</strong></li>
          </ul>     
      </div>
       <div class="clearb"></div>
      </div>
        <div class="clearb"></div>
      {%foreach from=$data item=row key%}
    	
        {%if $rootDeptname != $row->deptname%}
            <div class="clearb"></div>
           <div class="showDeptName">{%$row->deptname%}</div>
            <div class="clearb"></div>
        {%/if%}
           <div class="showTop" >
              <ul class="showUltop">
                <li class="showTab1">{%if $row->cname%}{%$row->cname%} {%else%}{%$row->itname%}{%/if%}</li>
                {%if $row->address %}
              
                    <li class="showTab2"> {%$row->address->sa_tel%} - {%$row->address->sa_tel_short%} </li>
                    <li class="showTab3">{%$row->address->sa_mobile%}</li>
                   {%else%}
                    <li class="showTab2">--</li>
                    <li class="showTab3">--</li>
                {%/if%}  
               
              </ul>     
          </div>
         
      	{%$rootDeptname = $row->deptname%}
       
      {%/foreach%}
      <div class="clearb"></div>
       </div>
      {%else%}
      暂无记录！ 
      {%/if%}
 
  <div class="pageNav">{%$links%}</div>
   