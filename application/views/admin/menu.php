<?php
include("header.php")
?>
<script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.treeTable.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/uploadify/ajaxupload.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/uploadify/swfobject.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/javascript/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript">
    //<![CDATA[
    //laod ymPromt stlye
    var Alert=ymPrompt.alert;
    $(document).ready(function(){
        $("#tbalemenu").treeTable({expandable:false});
        $("tr:odd").addClass('even');
        $("tr").hover(
        function () {
            $(this).addClass("hover");
        },
        function () {
            $(this).removeClass("hover");
        }
    );

        // Configure draggable nodes
        $("#menu .file, #menu .folder").draggable({
            helper: "clone",
            opacity: .75,
            refreshPositions: true, // Performance?
            revert: "invalid",
            revertDuration: 300,
            scroll: true
        });

        $("#menu .folder,#menu .file,#menu .root").each(function() {
            $(this).parents("tr").droppable({
                accept: ".file, .folder",
                drop: function(e, ui) {
                    var canMove = true;
                    target = $($(ui.draggable).parents("tr"));
                    if(target[0]==$(this)[0]||(target.attr('class').match('child-of-'+$(this).attr('id')))!=null){
                        canMove = false;
                    }else{
                        var flag = $(this);
                        while(flag.attr('id')!='node-root'){
                            flag = $('#' + flag.attr('class').match(/child-of-node-.*/)[0].split(" ")[0].replace(/child-of-/g,''));
                            if(target[0]==flag[0]){
                                canMove = false;
                                break;
                            }
                        }
                    }
                    if(canMove){
                        target.appendBranchTo(this);
                        uri = target.attr('id')+'/'+$(this).attr('id');
                        uri = uri.replace(/node-/g,"");
                        uri = uri.replace(/root/g,"0");
                        $.get('<?php echo site_url('admin/menu/move'); ?>' + "/"+uri,function(){
                            window.location = "<?php echo site_url("admin/menu/") ?>";
                        });
                    }
                },
                hoverClass: "accept",
                over: function(e, ui) {
                    if(this.id != $(ui.draggable.parents("tr")[0]).id && !$(this).is(".expanded")) {
                        $(this).expand();
                    }
                }
            });
        });

        $("table#menu tbody tr").mousedown(function() {
            $("tr.selected").removeClass("selected");
            $(this).addClass("selected");
        });

        $("table#menu tbody tr span").mousedown(function() {
            $($(this).parents("tr")[0]).trigger("mousedown");
        });


        // add and edit  menu start
        $("button[name='new']").click(function(){
            $("#functionMenu")[0].reset();
			  $('#show_menuPic').html("");
              $('#button4').text('选择图片');
              $('#del_menuPic').text('');
			   $('#show_menuBackpic').html("");
                    $('#button5').text('选择图片');
                    $('#del_menuBackpic').text('');
            $("input[name='parent_id']").val($(this).val());
            $('#editbox').show();
        });

        // save data start
        var validation1 = {
            rules: {
                menuName: {required: true,minlength: 2},
                menuSort:{required:true,number:true},
				typeId:{required:true}
            },
            messages: {
                menuName: {required: "请输入栏目名称",minlength: "用户名至少2个字符"},
                menuSort: {required:"请选择一个用户编辑后提交",number:"必须是数字"},
				typeId: {required:"请选择栏目类别"}
            },
            submitHandler:function(){
                var post_data = $("#functionMenu").serializeArray();
                var post_url;
                if($("input[name=id]").val() == 0){
                    post_url = "<?php echo site_url("admin/menu/create") ?>";
                }else{
                    post_url = "<?php echo site_url("admin/menu/edit") ?>";
                }
                $.ajax({
                    type: "POST",
                    url: post_url,
                    cache:false,
                    data: post_data,
                    success: function(msg){

                        flag = (msg=="ok");
                        if(flag){
                            // $("#editbox").html("");
                            ymPrompt.succeedInfo({message:'操作成功！请稍候, 正在刷新页面....'})
                            setInterval(function(){
                                window.location.reload();
                            },1000);
                            //  Alert(msg);
                        }else{
                            Alert(msg);
                        }
                    },
                    error:function(){
                        ymPrompt.errorInfo({message:"出错啦，刷新试试，如果一直出现，可以联系开发人员解决"});
                    }
                });


                return false;
            }
        };

        $('#functionMenu').validate(validation1);
        //// save data end
        //add and edit menu end
        $("button[name='edit']").click(function(){

            $this = $('#node-'+$(this).val()).find('span');

            var url="<?php echo site_url("admin/menu/getByid/") ?>"+"/"+$(this).val();

            $.getJSON(//使用getJSON方法取得JSON数据
            url,
            function(data){ //处理数据 data指向的是返回来的JSON数据
                // alert(data.menuName);
                $("input[name='id']").val(data.id);
                $("input[name='menuName']").val(data.menuName);
                $("input[name='menuSort']").val(data.menuSort);
				$("input[name='menuUrl']").val(data.menuUrl);
                $("input[name='optional']").val(data.optional);
                $("input[name='seoKeyword']").val(data.seoKeyword);
                $("input[name='menuPic']").val(data.menuPic);
                $("input[name='menuBackpic']").val(data.menuBackpic);
				$("input[name='menuLeftpic']").val(data.menuLeftpic);
                $("select[name='typeId']").attr("value",data.typeId);
               // alert(data.menuPic);
                if(data.menuPic  != null && data.menuPic  != "" ){
                    $('#show_menuPic').html("<img src='<?php echo base_url()."attachments/menu/" ?>/"+ data.menuPic +"' height='80' />");
                    $('#button4').text('重新上传');
                    $('#del_menuPic').text(' - 删除图片');
                }
                if(data.menuBackpic!= null && data.menuBackpic  != ""){
                    $('#show_menuBackpic').html("<img src='<?php echo base_url()."attachments/menu/" ?>/"+ data.menuBackpic +"' width='80' />");
                    $('#button5').text('重新上传');
                    $('#del_menuBackpic').text(' - 删除图片');
                }
		if(data.menuLeftpic!= null && data.menuLeftpic  != ""){
                    $('#show_menuLeftpic').html("<img src='<?php echo base_url()."attachments/menu/" ?>/"+ data.menuLeftpic +"' width='80' />");
                    $('#button6').text('重新上传');
                    $('#del_menuLeftpic').text(' - 删除图片');
                }
            }
        )
            $('#editbox').show();
        });
        $('#canceladd').click(function(){
            $('#editbox').hide();
            $("#functionMenu")[0].reset();
        });
        $("button[name='del']").click(function(){
            var delId = $(this).val();
            ymPrompt.confirmInfo('您确认删除此条信息？',null,null,null,handler);
            function handler(tp){
                if(tp=='ok'){

                    $.post("<?php echo site_url("admin/menu/del") ?>",
                    {
                        class_id: delId
                    },
                    function(){

                        ymPrompt.succeedInfo({message:'操作成功！请稍候, 正在刷新页面....'});
                        setInterval(function(){window.location.reload();},1000);

                    });
                }
            };
        });


        // upload start
        //
        new AjaxUpload('button4', {
            action:  '<?php echo site_url('admin/menu/uploadMenuLink') ?>',
            name: 'userfile',

            //选择后自动开始上传
            //autoSubmit:true,
            //返回Text格式数据
            responseType:false,
            onSubmit : function(file , ext){
                //alert(ext);
                if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                    alert('未允许上传的文件格式!');
                    // cancel upload
                    return false;
                }
                $('#button4').text('shan ' + file);
                this.disable();
            },
            onComplete: function(file, response){
                //  alert(response);
                //alert($(response.'#realname').html());
                $('#button4').html('选择文件：'+file +' ' + response); // 获取 上传文件名
                $('#menuPic').val($('#realname').text()); // 给input 赋值
                $('#show_menuPic').html("<img src='<?php echo base_url()."attachments/menu/";?>/"+$('#realname').text()+"' height='80' />");
            }
        });

        // delet menuPic
        $("#del_menuPic").click(function(){
            ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
            function handler(tp){
                if(tp=='ok'){
                    $('#show_menuPic').html("");
                    $('#menuPic').val("");
                    $('#del_menuPic').text("");
                }
            }
        });

        new AjaxUpload('button5', {
            action:  '<?php echo site_url('admin/menu/uploadMenuLink') ?>',
            name: 'userfile',
            onSubmit : function(file , ext){
                // alert(ext);
                if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                    alert('未允许上传的文件格式!');
                    return false;
                }
                $('#button5').text('上传中... ');
                this.disable();
            },
            onComplete: function(file, response){
               // alert(response);
                $('#button5').html('选择文件：'+file+' '+response);
                $('#show_menuBackpic').html(response);
                $('#menuBackpic').val($('#show_menuBackpic').text());
                $('#show_menuBackpic').html("<img src='<?php echo base_url()."attachments/menu/";?>/"+$('#show_menuBackpic').text()+"' width='80' />");
            }
        });

 new AjaxUpload('button6', {
            action:  '<?php echo site_url('admin/menu/uploadMenuLink') ?>',
            name: 'userfile',
            onSubmit : function(file , ext){
                // alert(ext);
                if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                    alert('未允许上传的文件格式!');
                    return false;
                }
                $('#button6').text('上传中... ');
                this.disable();
            },
            onComplete: function(file, response){
               // alert(response);
                $('#button6').html('选择文件：'+file+' '+response);
                $('#show_menuLeftpic').html(response);
                $('#menuLeftpic').val($('#show_menuLeftpic').text());
                $('#show_menuLeftpic').html("<img src='<?php echo base_url()."attachments/menu/";?>/"+$('#show_menuLeftpic').text()+"' width='80' />");
            }
        });

        // delet menuPic
        $("#del_menuBackpic").click(function(){
            ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
            function handler(tp){
                if(tp=='ok'){
                    $('#show_menuBackpic').html("");
                    $('#menuBackpic').val("");
                    $('#del_menuBackpic').text("");
                }
            }
        });
		 // delet menuPic
        $("#del_menuLeftpic").click(function(){
            ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
            function handler(tp){
                if(tp=='ok'){
                    $('#show_menuLeftpic').html("");
                    $('#menuLeftpic').val("");
                    $('#del_menuLeftpic').text("");
                }
            }
        });
        // upload end

    });


    //]]>



</script>


<div style="padding:10px;">
    网站栏目管理
</div>
<div id="editbox" class="funtion_show"  >
    <form id="functionMenu"  method="post" action="">
         <strong>网站栏目操作界面</strong> 
        <div style="float:right; width:300px;">
            <div id="show_menuPic" style=" float:left" ></div>
            <div id="show_menuBackpic" style=" float:left" ></div>
            <div id="show_menuLeftpic" style=" float:left" ></div>
            <div class="clear" style="clear:both"></div>
        </div>
        <div style="width:350px; float:left; position:relative;" >
            <dd>
                <input type="hidden" name="parent_id" value="0"/> <input type="hidden" name="id" value="0"/>
                栏33目名称：
                <input type="text" name="menuName" value=""  />
            </dd>
            <dd>  栏目类别：<select name="typeId" id="typeId"  />
            <option value="" >Please select Menu type</option>
                <?php foreach ($menuType as $row1): ?>
                <option value="<?php echo $row1->id; ?>" ><?php echo $row1->typeName; ?> </option>
            <?php endforeach; ?>
                    </select>
                    </dd>
                    <dd>栏目URL：
                      <input name="menuUrl" type="text"  value="" size="6" />
                      </dd>
                    <dd>
                      栏目排序：
                        <input name="menuSort" type="text"  value="1" size="2" />

                    </dd>
                    <dd>栏目说明：<input type="text" name="optional" value="" />
                    </dd>
                </div>
                <div style="margin-left:370px; height:100px; position:relative;">
                    <dd>关键字(SEO)：<input type="text" name="seoKeyword"> 少于50个字符
                    </dd>
                    <dd>
                        栏目图片：
                        <a  id="button4">选择图片</a>
                        <a id="del_menuPic"></a>
                        <input type="hidden" name="menuPic" id="menuPic" value="" />
                    </dd>
                    <dd>
                        栏目背景：
                        <a  id="button5">选择图片</a>
                        <a id="del_menuBackpic"></a>
                        <input type="hidden" name="menuBackpic" id="menuBackpic" value="" />
                    </dd>
                     <dd>
                        栏目Left：
                        <a  id="button6">选择图片</a>
                        <a id="del_menuLeftpic"></a>
                        <input type="hidden" name="menuLeftpic" id="menuLeftpic" value="" />
                    </dd>
                </div>
                <dd>
                    <input type="submit" name="button" id="button" value="确认提交" />
                    <input type="button" name="canceladd" id="canceladd" value="取消" />
                </dd>
            </form>
        </div>

        <table id="tbalemenu" >
            <thead><tr><th></th><th>显示顺序</th><th>栏目类别</th><th>URL</th><th>栏目说明</th><th>关键字（SEO）</th><th>操作选项</th></tr></thead>
            <tr id="node-root">
                <td><span class="root">网站根目录</span></td>
                <td colspan="5"></td>
                <td>
                    <button class="add" name="new" type="button" value="0"></button>
                </td>
            </tr>
    <?php foreach ($menu as $row): ?>
                        <tr id="node-<?php echo $row->id ?>"	<?php if ($row->parent_id): ?>	class="child-of-node-<?php echo $row->parent_id ?>"    <?php else : ?>    class="child-of-node-root"	<?php endif; ?>	>
                                    <td>
                                        <span class="<?php echo $row->children ? "folder" : "file"; ?>"><?php echo $row->menuName; ?></span>
                                    </td>
                                    <td>
                                        <span class="sequence" id="optional_<?php echo $row->id ?>"><?php echo $row->menuSort ?></span>
                                    </td>
                                    <td>
                                        <span class="typeId" id="optional_<?php echo $row->id ?>"><?php echo $row->typeName ?></span>
                                    </td>
                                    <td>
                                        <span class="typeId" id="optional_<?php echo $row->id ?>"><?php echo $row->menuUrl ?></span>
                                    </td>
                                    <td>
                                        <span class="optional" id="optional_<?php echo $row->id ?>"><?php echo $row->optional ?></span>
                                    </td>
                                    <td>
                                        <span class="optional" id="optional_<?php echo $row->id ?>"><?php echo $row->seoKeyword ?></span>
                                    </td>
                                    <td>

                                        <button class="add" name="new" type="button" value="<?php echo $row->id; ?>" title="添加栏目"></button>
                                        <button class="action edit" name="edit" type="button" value="<?php echo $row->id; ?>" title="修改栏目"></button>
            <?php if (!$row->children) : ?>
                                    <button class="action delete" name="del" type="button" value="<?php echo $row->id; ?>" title="删除栏目" ></button>
            <?php endif; ?>
                                </td>
                            </tr>
    <?php endforeach; ?>
                                </table>






<?php
                                    include("foot.php")
?>