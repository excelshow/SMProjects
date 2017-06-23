{%include file="../admin/header.tpl"%} 
<script type="text/javascript">
   $(document).ready(function(){
	    
        $("#addadmin").click(function(){
			BootstrapDialog.show({
				title: 'Add Supervisor ',
				closeByBackdrop: false,
				message: $('<div></div>').load("{%site_url('admin/system/user_add/')%}") 
       		});
 
        });
 
        $("button[name='edit']").click(function(){
			 var uid= $(this).val();
			BootstrapDialog.show({
				title: 'Modify Supervisor ',
				closeByBackdrop: false,
				message: $('<div></div>').load("{%site_url('admin/system/user_edit/')%}/"+$(this).val()) 
       		});
          
        });

        
        // edit password end

        $("button[name='del']").click(function(){

             	var uid = $(this).val();
			BootstrapDialog.confirm('Delete this User, are you sure?', function(result){
            if(result) {

                    $.ajax({

                        type: "POST",

                        url: "{%site_url('admin/system/user_del')%}",

                        cache:false,

                        data: 'uid='+uid,

                        success: function(msg){
 							BootstrapDialog.show({
								type:BootstrapDialog.TYPE_SUCCESS,
								title: 'Delected Success! ',
								message: 'current page is being refreshed!!' 
							});     
                             
                            setInterval(function(){
                                window.location.reload();
                            },1000);

                        },

                        error:function(){

                           alert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");

                        }

                    });

                }

            });

        });

  
    });

    //]]>

</script>
 
<div class="">
  <button class="btn btn-sm btn-primary pull-right" type="button"  name="addadmin" id="addadmin"  >Add new Supervisor</button>
  <h5>Supervisor Management</h5>
</div>
 

    <div >

       <table id=" " class="table table-bordered table-hover Small Font">

        <thead>

          <tr>

            <th>用户名</th>
            <th>姓名</th>
            <th>手机</th>

            <th>用户邮箱</th>
            <th>类型</th>

            <th>操作</th>

          </tr>

        </thead>

        {%foreach from=$users  item=row %}

        <tr id="{%$row->uid%}">

          <td>{%$row->username%}</td>
          <td>{%$row->nickname%}</td>
          <td>{%$row->phone%}</td>

          <td>{%$row->email%}</td>
          <td>{%$row->group_name%}</td>

          <td><button  name="edit" type="button" class="btn btn-primary btn-xs" value="{%$row->uid%}"   title="Modify"  ><span class="fui-new"></span> M</button>
 
            <button   name="del" type="button" class="btn btn-default btn-xs" value="{%$row->uid%}"  title="Del"  ><span class="fui-cross"></span> D</button></td>

        </tr>

        {%/foreach%}

      </table>

    </div>
 

{%include file="../admin/foot.tpl"%} 