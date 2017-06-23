<?php include("header.php") ?>

<script type="text/javascript">
    //<![CDATA[
    var Alert=ymPrompt.alert;
    $(document).ready(function(){
        $("table:first tr:odd").addClass('even');
        $('"table:first tr').hover(
        function () {
            $(this).addClass("hover");
        },
        function () {
            $(this).removeClass("hover");
        }
    );
	
	 // add and edit  gallery start
         $("#add").click(function(){
			alert();
           // $("#functionGallery")[0].reset();
            $('#editbox').show();
        });
	// add and edit gallery end

                        $('button[name="edit"]').click(function(){
                            window.location = "<?php echo site_url('admin/gallery/edit_gallery') ?>/" + $(this).val();
                        });
                        $('button[name="del"]').click(function(){


                            if(!confirm('确定要放入回收站吗？'))
                                return false;
                            else{
                                $this = $(this).val();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo site_url('admin/gallery/del') ?>",
                                    data: "gallery_id="+$(this).val(),
                                    success: function(msg){
                                        // alert(msg);
                                        window.location = "<?php echo site_url('admin/gallery/view') ?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>";

                                    }
                                });

                                return false;
                            }



                        });
                        $('#all_check').click(function(){
                            $("tr input[type='checkbox']").attr('checked',$(this).attr('checked'));
                        });
                        $("input[name='submit']").click(function(){
                            if(!$(".all_check:checked").length){
                                return false;
                            }
    <?php if ($mode == "recycle"): ?>
                                                                    if(!confirm('确定要删除吗？此操作将彻底删除该图片！'))
                                                                        return false;
                                                                    else
                                                                        $("form").attr('action','<?php echo site_url('admin/gallery/physical_del') ?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>');
    <?php endif; ?>
                                                                });

    <?php if ($mode == "recycle"): ?>
                                                    $("#recover").click(function(){
                                                        if(!$(".all_check:checked").length){
                                                            return false;
                                                        }
                                                        if(!confirm('确定要恢复吗？'))
                                                            return false;
                                                        else{
                                                            $("form").attr('action','<?php echo site_url('admin/gallery/recover') ?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>');
                                                        }
                                                    });
    <?php endif; ?>

                                                    $("select[name='class_id']").change(function(){
                                                        window.location = "<?php echo site_url('admin/gallery/view') ?>?q="+$(this).val()+"&v="+$("select[name='is_verified']").val()+"&mode=<?php echo $mode ?>";
                                                    });
                                                    $("select[name='is_verified']").change(function(){
                                                        window.location = "<?php echo site_url('admin/gallery/view') ?>?q="+$("select[name='class_id']").val()+"&v="+$(this).val()+"&mode=<?php echo $mode ?>";
                                                    });


	});

                    </script>

 <div style="padding:10px;">
    <strong>图库管理 / Gallery Manager </strong></div>
     <div style="padding:10px"> <input  name="" type="button" class="buttom" id="addGallery" value="添加图片 / Add Photo" />
       <button class="edit" name="add" id="add" type="button"  value=""></button>

 </div>
<div id="editbox"  >class="funtion_show" 
                            <form name="functionGallery" id="functionGallery" action="<?php echo site_url('admin/gallery/add') ?>" method="post">
                                <table  class="treeTable">
                                    <thead><tr>
                                            <th colspan="2">添加图片/ Add Photo</th></tr></thead>
                                    <tr><td width="100">图片所属类别/ Select Category</td><td width="384"><select name="class_id" id="class_id">
                                                <option value="0" selected="selected">Select Category</option>
<?php foreach ($category as $row): ?>
                                                    <option value="<?php echo $row->class_id; ?>">
<?php for ($i = 0; $i < $row->deep; $i++): ?>
<?php echo "&nbsp" ?>
<?php endfor; ?>
<?php echo $row->class_name; ?>
                                                        </option>
<?php endforeach; ?>
                            </select></td></tr>

                    <tr><td>上传图片 / Photos</td><td height="100" style="overflow:scroll;" valign="top">

                            <div class="c1"><input type="hidden" name="upnum" id="up_num" value="0" />
                                <span id="flash_upload_select_picture">ssss</span>
                            </div>

                            <div class="c2">
                                <div class="rank" id="flash_upload_progress" style="border:solid 1px #CCC; background:#FFF;height:300px; width:400px; overflow: scroll;"></div>
                            </div>

                            <div class="c1">
                                &nbsp;
                            </div>
                            <div class="c2">

                                <input type="button" class="btn_b" value="开始上传" id="btnUpload" onClick='start_upload()' disabled="disabled" />
                            </div>


                        </td></tr>

                    <tr><td height="23" colspan="2"><input type="submit" name="submit" value="上传图片 / Upload Photos" class="buttom" /></td></tr>
                </table>
            </form>
        </div>



                                                        <form action="<?php echo site_url('admin/gallery/multi_del') ?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>" method="post">
                                                            <div style="padding:10px;" >
                                                                类别选择：
                                                                <select name="class_id">
                                                                    <option value="" selected="selected">选择设计图分类</option>
<?php foreach ($category as $row): ?>
                                                                                    <option value="<?php echo $row->class_id; ?>" <?php echo $q == $row->class_id ? "selected='selected'" : "" ?>>
<?php for ($i = 0; $i < $row->deep; $i++): ?>
<?php echo "&nbsp" ?>
<?php endfor; ?>
<?php echo $row->class_name; ?> </option>
            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <table  class="treeTable">
                                                                    <thead><tr><th width="40"><input id="all_check" type="checkbox"/></th><th>图片名称</th><th>图片分类</th><th>作者</th><!--<th>是否审核</th>--><th>发表日期</th><th>操作</th></tr></thead>
                <?php foreach ($gallerys as $row): ?>
                                                                        <tr id="<?php echo $row->gallery_id; ?>">
                                                                                <td><input class="all_check" type="checkbox" name="gallery_id_<?php echo $row->gallery_id; ?>" value="<?php echo $row->gallery_id; ?>"/></td>
                                                                                <td><a href="<?php echo site_url('admin/gallery/edit_gallery') ?>/<?php echo $row->gallery_id; ?>"><?php echo $row->title; ?></a></td>
                                                                                <td><?php echo $row->class_name ?></td>
                                                                                <td><?php echo $row->author ?></td>
                                                                                <!--<td><?php echo $row->is_verified == 1 ? "是" : "否" ?></td>-->
                                                                                    <td><?php echo $row->post_time ?></td>
                                                                                    <td>
<?php if ($mode == "normal"): ?>
                                                                                            <button class="edit" name="edit" type="button"
                                                                                                    value="<?php echo $row->gallery_id; ?>"></button>
                                                                                            <button class="delete" name="del" type="button"
                                                                                                    value="<?php echo $row->gallery_id; ?>" ></button>
<?php else: ?>
                                                                                		回收站中
<?php endif; ?>
                                                                                    </td>
                                                                                </tr>
<?php endforeach; ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <input type="submit" value="  " name="submit"  class="delete"/>
<?php if ($mode == "recycle"): ?>
                                                                                            <input type="submit" value="  " name="recover" id="recover" class="edit"/>
        <?php endif; ?>
                                                                                                </td>

                                                                                                <td><select name="class_id">
                                                                                                        <option value="" selected="selected">选择设计图分类</option>
<?php foreach ($category as $row): ?>
                                                                                                    <option value="<?php echo $row->class_id; ?>" <?php echo $q == $row->class_id ? "selected='selected'" : "" ?>>
<?php for ($i = 0; $i < $row->deep; $i++): ?>
<?php echo "&nbsp" ?>
<?php endfor; ?>
<?php echo $row->class_name; ?>
                                                                                                        </option>
<?php endforeach; ?>
                                                                                                </select>
                                                                                               <!-- <select name="is_verified">
                                                                                                <option value="-1" <?php echo $v == "-1" ? 'selected="selected"' : "" ?>>全部</option>
                                                                                            <option value="1" <?php echo $v == 1 ? 'selected="selected"' : "" ?>>已审核</option>
                                                                                            <option value="0" <?php echo $v == 0 ? 'selected="selected"' : "" ?>>未审核</option>
                                                                                            </select>-->
                                                                                        </td>
                                                                                        <td colspan="5"><div align="center"><?php echo $links; ?></div></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </form>

<?php include("foot.php") ?>
