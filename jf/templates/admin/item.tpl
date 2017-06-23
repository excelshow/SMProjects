{%include file="./header.tpl"%}
<div class="container-full "   >
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <h5>评估列表</h5>
    </div>
    <form name="subForm" id="subForm"  class=" "  method="get"   action="" role="form">
      <div class="col-md-6 col-sm-12">
        <div class=" " style="padding-top:5px; display:none;">
          <div class="input-group ">
            <input name="keyword" type="text" class="form-control" id="keyword" placeholder="请输入查询关键字" value="{%$key%}" >
            <span class="input-group-btn">
            
            <button class="btn btn-default" type="submit">查询!</button>
            </span> </div>
        </div>
      </div>
    </form>
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
            <th>测试</th>
            <th>年度</th>
            <th>职等</th>
            <th>阿米巴/专家</th>
            <th>入职日期</th>
            <th>工作地</th>
            <th>房产</th>
            <th>绩效C/D</th>
            <th>季度S</th>
            <th>半年S</th>
            <th>年度S</th>
            <th>评分</th>
            <th>提交时间</th>
          </tr>
        </thead>
        {%if $data['list']%}
        {%foreach from=$data['list'] item=row%}
        <tr  >
          <td>{%$row->itname%}{%$row->ipaddress%}</td>
          <td>{%$row->ndDate%}</td>
          <td>{%$row->zd%} </td>
          <td>
          {%if ($row->amb==1)%}
          是
          {%else%}
          否
          {%/if%}
          </td>
          <td>{%$row->rzrq%}</td>
          <td>{%$row->gzd%}</td>
          <td> {%$row->fcs%} </td>
          <td>
           {%if ($row->cd==0)%}
          是
          {%else%}
          否
          {%/if%}
          </td>
          <td>{%$row->jds%}</td>
          <td>{%$row->bns%}</td>
          <td>{%$row->nds%}</td>
          <td>{%$row->total%}</td>
          <td>{%$row->subtime%}</td>
        </tr>
        {%/foreach%}
        {%/if%}
      </table>
    </form>
    <div  class='pagination pagination-info pagination-sm' >{%$links%}</div>
  </div>
</div>
{%include file="./foot.tpl"%}