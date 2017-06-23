 
  <div class="staffadd  " style=" width:800px;  ">
 
    <!--begin form -->
    <div class="staffformInfo fleft">
         <dt>
          <div  class="formLab">用户信息</div>
          <div class="formcontrol">
               <div  class="formLabt">姓名：</div>
                <div  class="formLabi">{%$staff->cname%} 
                </div>
                <div  class="formLabt">帐号：</div>
                <div  class="formLabi">
                {%$staff->itname%}
                </div>
          </div>
          <div class="formLine clearb" ></div>
          <div  class="formLab">业务系统</div>
          <div class="formcontrol">
            <div   >
            {%foreach from=$systemf item=rowf%}
             <div  class="formLabi">
              {%if (in_array($rowf->keynumber,explode(',', $staff->system_id)))%}
              <input name="system_id[]" type="hidden" value="{%$rowf->keynumber%}"  />
              {%/if%}
             <input name="show" type="checkbox" value="{%$rowf->keynumber%}"  disabled="disabled"
             {%if (in_array($rowf->keynumber,explode(',', $staff->system_id)))%}
              checked="checked" 
              {%/if%}
              />{%$rowf->sysName%} </div>
             {%/foreach%}
           </div>
          </div>
          <div class="formLine clearb" ></div>
          <div  class="formLab"><strong>应用系统</strong></div>
           <div class="  clearb " ></div>
            <div  class="formLab">加密系统</div>
          <div class="formcontrol">
                  <div  class="formLab">密级岗位</div>
                  <div class="formcontrol">
                     <div  class="formLabi"><select name="" class="inputText" >
                    {%foreach from=$quarters item=row1%}
                    	<option value="{%$row1->quarters_id%}" 
                         {%if ($staff->quarters_id == $row1->quarters_id)%}
                           selected="selected" 
                          {%/if%}
                        >{%$row1->quarters_name%} </option>
                     
                     {%/foreach%}
                     </select>
                     </div>
                    <div  class="formLabi">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;文件密级</div>
                  <div class="formLabi">
                    <select name="" class="inputText" >
                    {%foreach from=$doctype item=row1%}
                    	<option value="{%$row1->doctype_id%}"
                         {%if ($staff->doctype_id == $row1->doctype_id)%}
                           selected="selected" 
                          {%/if%}
                        >{%$row1->doctype_name%} </option>
                     
                     {%/foreach%}
                     </select>
                   
                  </div>
                  </div>
                   
                 
            <div class="formLine clearb " ></div>
                 
            <div class=" h10 clearb " ></div>
          </div>
            <div  class="formLab">VPN权限</div>
          <div class="formcontrol">
                  <div  class="formLab">VPN权限</div>
                  <div class="formcontrol">
                    <div   >
                    {%foreach from=$system3 item=row3%}
                     <div  class="formLabi">
                     <input name="system_id[]" type="checkbox" value="{%$row3->keynumber%}" 
                     {%if (in_array($row3->keynumber,explode(',', $staff->system_id)))%}
                      checked="checked" 
                      {%/if%}
                      />{%$row3->sysName%} </div>
                     {%/foreach%}
                   </div>
                  </div>
                 
          </div>
          <div class=" h10 clearb " ></div>
            <div  class="formLab">邮件</div>
          <div class="formcontrol">
                  <div  class="formLab">&nbsp;</div>
                  <div class="formcontrol">
                    <div   >
                    {%foreach from=$system4 item=row4%}
                     <div  class="formLabi">
                     <input name="system_id[]" type="checkbox" value="{%$row4->keynumber%}" 
                     {%if (in_array($row4->keynumber,explode(',', $staff->system_id)))%}
                      checked="checked" 
                      {%/if%}
                      />{%$row4->sysName%} </div>
                     {%/foreach%}
                   </div>
                  </div>
                 
          </div>
          <!--- ----------->
          <div class=" h10 clearb " ></div>
            <div  class="formLab">上网</div>
          <div class="formcontrol">
                  <div  class="formLab">&nbsp;</div>
                  <div class="formcontrol">
                    <div   >
                    {%foreach from=$system5 item=row5%}
                     <div  class="formLabi">
                     <input name="system_id[]" type="checkbox" value="{%$row5->keynumber%}" 
                     {%if (in_array($row5->keynumber,explode(',', $staff->system_id)))%}
                      checked="checked" 
                      {%/if%}
                      />{%$row5->sysName%} </div>
                     {%/foreach%}
                   </div>
                  </div>
                 
          </div>
            <!--- ----------->
          <div class=" h10 clearb " ></div>
            <div  class="formLab">正版软件</div>
          <div class="formcontrol">
                  <div  class="formLab">&nbsp;</div>
                  <div class="formcontrol">
                    <div   >
                    {%foreach from=$system7 item=row7%}
                     <div  class="formLabi">
                     <input name="system_id[]" type="checkbox" value="{%$row7->keynumber%}" 
                     {%if (in_array($row7->keynumber,explode(',', $staff->system_id)))%}
                      checked="checked" 
                      {%/if%}
                      />{%$row7->sysName%} </div>
                     {%/foreach%}
                   </div>
                  </div>
                 
          </div>
          <!--- ----------->
           <!--- ----------->
          <div class=" h10 clearb " ></div>
            <div  class="formLab">笔记本</div>
          <div class="formcontrol">
                  <div  class="formLab">&nbsp;</div>
                  <div class="formcontrol">
                    <div   >
                    {%foreach from=$system6 item=row6%}
                     <div  class="formLabi">
                     <input name="system_id[]" type="checkbox" value="{%$row6->keynumber%}" 
                     {%if (in_array($row6->keynumber,explode(',', $staff->system_id)))%}
                      checked="checked" 
                      {%/if%}
                      />{%$row6->sysName%} </div>
                     {%/foreach%}
                   </div>
                  </div>
                 
          </div>
            <!--- ----------->
            <div class=" h10 clearb " ></div>
            <div  class="formLab">商务网</div>
          <div class="formcontrol">
                  <div  class="formLab">&nbsp;</div>
                  <div class="formcontrol">
                    <div   >
                    {%foreach from=$system8 item=row8%}
                     <div  class="formLabi">
                     <input name="system_id[]" type="checkbox" value="{%$row8->keynumber%}" 
                     {%if (in_array($row8->keynumber,explode(',', $staff->system_id)))%}
                      checked="checked" 
                      {%/if%}
                      />{%$row8->sysName%} </div>
                     {%/foreach%}
                   </div>
                  </div>
                 
          </div>
            <!--- ----------->
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;</div>
          <div class="formcontrol">
            <input name="id" id="id" type="hidden" value="{%$staff->id%}" />
            <input name="action" type="hidden" value="modify" />
            &nbsp;&nbsp;
            <input type="button"  class="a_close buttom"   value="关闭" />
          </div>
     </div>
    <!--end form --> 
    <!--begin dept --> 
    
    <!--end dept -->
    <div class="clearb"></div>
  </div>
 