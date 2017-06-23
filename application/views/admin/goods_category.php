<?php
include("header.php")
?>
<script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.treeTable.min.js"></script>
 
<script type="text/javascript">
    //<![CDATA[
    var Alert=ymPrompt.alert;
    $(document).ready(function(){
        $("#category").treeTable({
            expandable:false
        });
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
        $("#category .file, #category .folder").draggable({
            helper: "clone",
            opacity: .75,
            refreshPositions: true, // Performance?
            revert: "invalid",
            revertDuration: 300,
            scroll: true
        });

        $("#category .folder,#category .file,#category .root").each(function() {
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
                        $.get('<?php echo site_url('admin/category/move'); ?>' + "/"+uri,function(){
                            window.location = "<?php echo site_url("admin/category/") ?>";
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

        $("table#category tbody tr").mousedown(function() {
            $("tr.selected").removeClass("selected");
            $(this).addClass("selected");
        });

        $("table#category tbody tr span").mousedown(function() {
            $($(this).parents("tr")[0]).trigger("mousedown");
        });


                        
        $("button[name='new']").click(function(){
            $("#functionCategory")[0].reset();
            $("input[name='parent_id']").val($(this).val());
            $('#editbox').show();

        });
        // save data start
        var validation1 = {
            rules: {
                class_name: {required: true,minlength: 2},
                class_sequence:{required:true,number:true}
            },
            messages: {
                class_name: {required: "请输入礼品品牌名称",minlength: "礼品品牌名至少2个字符"},
                class_sequence: {required:"请选择礼品品牌排序",number:"必须是数字"} 
            },
            submitHandler:function(){
                var post_data = $("#functionCategory").serializeArray();
                var post_url;
                if($("input[name=id]").val() == 0){
                    post_url = "<?php echo site_url("admin/goods_category/create") ?>";
                }else{
                    post_url = "<?php echo site_url("admin/goods_category/edit") ?>";
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

        $('#functionCategory').validate(validation1);
        //// save data end
			
           //add and edit menu end
    $("button[name='edit']").click(function(){

            $this = $('#node-'+$(this).val()).find('span');

            var url="<?php echo site_url("admin/goods_category/getByid/") ?>"+"/"+$(this).val();

            $.getJSON(//使用getJSON方法取得JSON数据
                url,
                function(data){ //处理数据 data指向的是返回来的JSON数据
                   // alert(data.menuName);
                    $("input[name='id']").val(data.class_id);
                    $("input[name='parent_id']").val(data.parent_id);
                    $("input[name='class_name']").val(data.class_name);
                    $("input[name='class_sequence']").val(data.class_sequence);
                    $("input[name='class_optional']").val(data.class_optional);
                    $("input[name='seoKeyword']").val(data.seoKeyword);
                    $("input[name='Pic']").val(data.Pic);
                    $("input[name='Backpic']").val(data.Backpic);
                    
                   // alert(data.menuPic);
                    if(data.Pic  != "" && data.Pic  != null ){
                        $('#show_Pic').html("<img src='<?php echo site_url("attachments/goods_category/") ?>/"+ data.Pic +"' height='50' />");
                         $('#button4').text('重新上传');
                         $('#del_Pic').text(' - 删除图片');
                    }
                    if(data.menuBackpic!= "" && data.menuBackpic!= null ){
                        $('#show_Backpic').html("<img src='<?php echo site_url("attachments/goods_category/") ?>/"+ data.Backpic +"' width='80' />");
                        $('#button5').text('重新上传');
                        $('#del_Backpic').text(' - 删除图片');
                    }

                }
         )
    	$('#editbox').show();
        });
	
        $("button[name='del']").click(function(){
            var delId = $(this).val();
            ymPrompt.confirmInfo('您确认删除此条信息？',null,null,null,handler);
            function handler(tp){
                if(tp=='ok'){

                    $.post("<?php echo site_url("admin/goods_category/del") ?>",
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

        // close editBox
        $('#canceladd').click(function(){
            $('#editbox').hide();
            $("#functionCategory")[0].reset();
        });

        // upload start
        
        // upload end

    });


    //]]>
</script>
<div style="padding: 10px">
    <b>礼品品牌管理</b>
</div>
<div id="editbox" class="funtion_show"  >
    <form id="functionCategory"  method="post" action="">
        <div style="float:right;">
            <div id="show_Pic" ></div>
            <div id="show_Backpic" ></div>
        </div>
        <div style="width:350px;  " >
            <input type="hidden" name="parent_id" value=""/> <input type="hidden" name="id" value="0"/>
            <dd>品牌名称：<input type="text" name="class_name" value="" onchange="$('#editbox').data('edit_name',this.value)"  /></dd>
            <dd>品牌序号：<input type="text" name="class_sequence" value="" onchange="$('#editbox').data('edit_sequence',this.value)" /></dd>
            <dd>品牌属性：<input type="text" name="class_optional" value="" onchange="$('#editbox').data('edit_optional',this.value)" /></dd>
        </div>
        
        <dd><button type="submit" name="button" id="button" >确定提交</button> <input type="button" name="canceladd" id="canceladd" value="取消" /></dd>
    </form>
</div>
<table id="category">
    <thead><tr><th></th><th>显示顺序</th><th>附加属性</th><th>操作选项</th></tr></thead>
    <tr id="node-root">
        <td><span class="root">类别根目录</span></td>
        <td colspan="2"></td>
        <td>
            <button class="add" name="new" type="button" value="0"></button>
        </td>
    </tr>
    <?php foreach ($category as $row): ?>
        <tr id="node-<?php echo $row->class_id ?>"	<?php if ($row->parent_id): ?>	class="child-of-node-<?php echo $row->parent_id ?>"    <?php else : ?>    class="child-of-node-root"	<?php endif; ?>	>
                    <td>
                        <span class="<?php echo $row->children ? "folder" : "file"; ?>"><?php echo $row->class_name; ?></span>
                    </td>
                    <td>
                        <span class="sequence" id="optional_<?php echo $row->class_id ?>"><?php echo $row->class_sequence ?></span>
                    </td>
                    <td>
                        <span class="optional" id="optional_<?php echo $row->class_id ?>"><?php echo $row->class_optional ?></span>
                    </td>
                    <td>
                        <button class="add" name="new" type="button" value="<?php echo $row->class_id; ?>"></button>
                        <button class="action edit" name="edit" type="button" value="<?php echo $row->class_id; ?>"></button>
            <?php if (!$row->children) : ?>
                    <button class="action delete" name="del" type="button" value="<?php echo $row->class_id; ?>"></button>
            <?php endif; ?>
                </td>
            </tr>
    <?php endforeach; ?>
                </table>

<?php
                    include("foot.php")
?>