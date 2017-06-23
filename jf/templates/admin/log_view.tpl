{%include file="./header.tpl"%}
<div class="container-full "   >
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <h5>评估列表</h5>
    </div>
    
  </div>
</div>
<div class="row" role="complementary"> 
  <!-- /header -->
  <div class="col-xs-12 " role="main" >
    <div  class='pagination pagination-info pagination-sm' >{%$links%}</div>
    <form action="" method="">
      <table  id="tbalemenu" class="table table-striped table-bordered table-hover Small Font">
        <thead>
          <tr>
            <th>访问人</th>
            <th>IP</th>
            <th>访问时间</th>
          </tr>
        </thead>
        {%if $data['list']%}
        {%foreach from=$data['list'] item=row%}
        <tr  >
          <td>{%$row->itname%}</td>
          <td>{%$row->ipaddress%}</td>
          <td>{%$row->logtime%}</td>
        </tr>
        {%/foreach%}
        {%/if%}
      </table>
    </form>
    <div  class='pagination pagination-info pagination-sm' >{%$links%}</div>
  </div>
</div>
{%include file="./foot.tpl"%}