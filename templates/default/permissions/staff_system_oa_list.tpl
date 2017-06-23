 
    <table  class="treeTable" id="treeTable" style="width:400px;">
      <thead>
        <tr>
         <!-- <th width="40"><input id="all_check" type="checkbox"/></th>-->
          <th>OA流程编号</th>
          <th colspan="5">提交时间</th>
        </tr>
      </thead>
      <tbody>
      
      
      {%foreach from=$data item=row%}
      <tr id="{%$row->id%}">
    
        <td>{%$row->oa_number%} </td>
        <td colspan="5">{%$row->f_time%}  </td>
      </tr>
      {%/foreach%}
      
      
        </tbody>
      
    </table>
 