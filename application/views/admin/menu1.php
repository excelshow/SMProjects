<?php
include("header.php")
?>
<script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.treeTable.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/uploadify/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/uploadify/ajaxupload.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/uploadify/swfobject.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/javascript/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function(){
        
        $("#tbalemenu").treeTable({
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

        $("button[name='new']").click(function(){
            hiBox('#editbox','新加网站栏目','300');
            $("input[name='edit_name']").val("未命名类别");
            $('#editbox').data('edit_name',"未命名类别");
            $("input[name='edit_typeId']").val("1");
            $('#editbox').data('edit_typeId',"");
            $("input[name='edit_sortBy']").val("0");
            $('#editbox').data('edit_sortBy',"0");
            $("input[name='optional']").val("");
            $('#editbox').data('optional',"");
            $("input[name='edit_parent']").val($(this).val()) ;
            $("button[name='edit_cmd']").click(function(){
                // alert(  $('#editbox').data('edit_typeId'));
                checkform('/create');
            }) ;
        });

        $("button[name='edit']").click(function(){ 
            $this = $('#node-'+$(this).val()).find('span');
            //alert( $(this).val());
            var url="<?php echo site_url("admin/menu/getByid/") ?>"+"/"+$(this).val();
              
            $.getJSON( //使用getJSON方法取得JSON数据
            url,
            function(data){ //处理数据 data指向的是返回来的JSON数据
                //alert(data.typeId);
                $("input[name='edit_name']").val(data.menuName);
                $("input[name='edit_sortBy']").val(data.sortBy);
                $("input[name='optional']").val(data.optional);
                $("select[name='edit_typeId']").attr("value",'2');
            }
        )
            hiBox('#editbox','编辑类别','300');

            $("button[name='edit_cmd']").click(function(){
                checkform('/edit');
            }) ;
        });

        $("button[name='del']").click(function(){
            $.post("<?php echo site_url("admin/menu/del") ?>",
            {
                class_id: $(this).val()
            },
            function(){
                window.location = "<?php echo site_url("admin/menu") ?>";
            });
        });
    });

    function checkform(type){
        if($("input[name='edit_name']").data('edit_name')==""){
            $("input[name='edit_name']").focus();
            return false;
        }
        if($("input[name='edit_sortBy']").data('edit_sortBy')==""){
            $("input[name='edit_sortBy']").focus();
            return false;
        }
        $.post("<?php echo site_url("admin/menu/") ?>"+type,
        {
            class_name: $('#editbox').data('edit_name'),
            class_parent: $("input[name='edit_parent']").val(),
            typeId:$('#editbox').data('edit_typeId'),
            sortBy:$('#editbox').data('edit_sortBy'),
            optional:$('#editbox').data('optional')
        },
        function(){
            window.location = "<?php echo site_url("admin/menu/") ?>";
        });
    }
    //]]>



</script>


<div style="padding:10px;">
    <button  name="new" type="button" value="0" class="buttom" >添加网站栏目</button><p><a id="open_dialog" href="#">Open dialog</a></p>
</div>
 <div id="dialog" style="display:none" >
                    <div id="editbox">
                        <input type="hidden" name="edit_parent" value=""/>
                        <div>栏目名称：<input type="text" name="edit_name" value="" onchange="$('#editbox').data('edit_name',this.value)"  /></div>

                        <div>栏目类别：<select name="edit_typeId" id="edit_typeId"  onchange="$('#editbox').data('edit_typeId',this.value)"   >
                <?php foreach ($menuType as $row1): ?>
                        <option value="<?php echo $row1->id; ?>"><?php echo $row1->typeName; ?></option>
                <?php endforeach; ?>
                    </select>
                </div>
                <div>栏目排序：<input type="text" name="edit_sortBy" value="" onchange="$('#editbox').data('edit_sortBy',this.value)" /></div>
                <div>栏目说明：<input type="text" name="optional" value="" onchange="$('#editbox').data('optional',this.value)" /></div>
                <div >栏目图片： </div>
                <a  id="button4">Click to Upload</a>
                <div>栏目背景：</div>
                <div><button type="button" name='edit_cmd' >确定提交</button></div>
            </div>
        </div>
<table id="tbalemenu">
    <thead><tr><th></th><th>显示顺序</th><th>栏目类别</th><th>附加属性</th><th>操作选项</th></tr></thead>
    <tr id="node-root">
        <td><span class="root">网站根目录</span></td>
        <td colspan="3"></td>
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
                        <span class="optional" id="optional_<?php echo $row->id ?>"><?php echo $row->optional ?></span>
                    </td>
                    <td>
                        <a href="<?php echo site_url("admin/menu/id/1") ?>" >添加栏目</a>
                        <button class="add" name="new" type="button" value="<?php echo $row->id; ?>"></button>
                        <button class="action edit" name="edit" type="button" value="<?php echo $row->id; ?>"></button>
            <?php if (!$row->children) : ?>
                    <button class="action delete" name="del" type="button" value="<?php echo $row->id; ?>"></button>
            <?php endif; ?>
                </td>
            </tr>
    <?php endforeach; ?>
                </table>
               




<?php
                        include("foot.php")
?>