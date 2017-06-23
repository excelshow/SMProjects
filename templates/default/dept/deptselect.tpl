 <div >
   <div style="line-height:22px;">
   
   		<input type="hidden" name="rootid" id="rootid" value="{%$rootid%}" />
   <span class="ouzhuzhi">组织：{%implode(" &raquo; ", $ouTemp)%} </span>
        <input type="hidden" name="container" id="container" value="{%implode(",", $ouTemp)%}" /><br>
        
    	<!--<span class="ouDn">AD DN：{%implode(",", $ouDnPost)%}</span>-->
        <input type="hidden" name="adOuShow" id="adOuShow" value="{%implode(",", $ouDnPost)%}" />
       
    </div>
  <div id="ouShow" style=" " >
    
  </div>
  
</div>
