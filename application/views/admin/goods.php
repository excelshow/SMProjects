<?php include("header.php") ?>
<script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/uploadify/ajaxupload.js"></script>
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
	
	 // add and edit  goods start
         $("#addgoods").click(function(){
			//alert("");
             $("#functionGallery")[0].reset();
            $('#editbox').show();
        });
		
		 // save data start
        var validation1 = {
            rules: {
                category_id: {required: true},
				goodsName: {required: true},
				Pic: {required: true}
            },
            messages: {
                category_id: {required: "请输入图片所属类别！ Please select category!"},
				goodsName: {required: "请输入图片名称！ Please enter photo's name!"},
				Pic: {required:"请选择图片！ Please select photo!"}
            },
            submitHandler:function(){
                var post_data = $("#functionGallery").serializeArray();
                var post_url;
				//alert($("input[name=id]").val());
                if($("input[name=id]").val() == 0){
                    post_url = "<?php echo site_url("admin/goods/add") ?>";
                }else{
                    post_url = "<?php echo site_url("admin/goods/edit") ?>";
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

        $('#functionGallery').validate(validation1);
        //// save data end
		
		// close editBox
        $('#canceladd').click(function(){
            
            $("#functionGallery")[0].reset();
			$('#editbox').hide();
        });
		
		
		 // upload start
        //
        new AjaxUpload('button4', {
            action:  '<?php echo site_url('admin/goods/uploadPicLink') ?>',
            name: 'userfile',
            responseType:false,
            onSubmit : function(file , ext){
                //alert(ext);
                if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                    alert('未允许上传的文件格式!');
                    // cancel upload
                    return false;
                }
                $('#button4').text('' + file);
                this.disable();
            },
            onComplete: function(file, response){
                //  alert(response);
                //alert($(response.'#realname').html());
                $('#button4').html('选择文件：'+file +' ' + response); // 获取 上传文件名
                $('#Pic').val($('#realname').text()); // 给input 赋值
                
                $('#show_Pic').html("<img src='<?php echo base_url()."attachments/goods/";?>/"+$('#realname').text()+"' height='50' />");
            }
        });

        // delet Pic
        $("#del_Pic").click(function(){
            ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
            function handler(tp){
                if(tp=='ok'){
                    $('#show_Pic').html("");
                    $('#Pic').val("");
                    $('#del_Pic').text("");
                }
            }
        });
		
		  $("button[name='edit']").click(function(){

            $this = $('#node-'+$(this).val()).find('span');

            var url="<?php echo site_url("admin/goods/getByid/") ?>"+"/"+$(this).val();

            $.getJSON(//使用getJSON方法取得JSON数据
                url,
                function(data){ //处理数据 data指向的是返回来的JSON数据
                   // alert(data.menuName);
                    $("input[name='id']").val(data.goods_id);
                    $("select[name='category_id']").attr("value",data.class_id);
					//alert(data.goodsContents);
                    $("input[name='goodsName']").val(data.goodsName);
                    $("input[name='goodsSort']").val(data.goodsSort);
                    $("#goodsContents").text(data.goodsContents);
                    
                    $("input[name='Pic']").val(data.Pic);
                    
                    
                   // alert(data.menuPic);
                    if(data.Pic  != "" && data.Pic  != null ){
                        $('#show_Pic').html("<img src='<?php echo base_url()."attachments/goods/";?>/"+ data.Pic +"' height='100' />");
                         $('#button4').text('重新上传');
                         $('#del_Pic').text(' - 删除图片');
                    }
                  

                }
         )
    	$('#editbox').show();
        });
	

	// add and edit goods end

                       
                        $('button[name="del"]').click(function(){


                            if(!confirm('确定要放入回收站吗？'))
                                return false;
                            else{
                                $this = $(this).val();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo site_url('admin/goods/del') ?>",
                                    data: "goods_id="+$(this).val(),
                                    success: function(msg){
                                        // alert(msg);
                                        window.location = "<?php echo site_url('admin/goods/view') ?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>";

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
                                                                        $("form").attr('action','<?php echo site_url('admin/goods/physical_del') ?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>');
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
                                                            $("form").attr('action','<?php echo site_url('admin/goods/recover') ?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>');
                                                        }
                                                    });
    <?php endif; ?>

                                                    $("select[name='class_id']").change(function(){
                                                        window.location = "<?php echo site_url('admin/goods/view') ?>?q="+$(this).val()+"&v="+$("select[name='is_verified']").val()+"&mode=<?php echo $mode ?>";
                                                    });
                                                    $("select[name='is_verified']").change(function(){
                                                        window.location = "<?php echo site_url('admin/goods/view') ?>?q="+$("select[name='class_id']").val()+"&v="+$(this).val()+"&mode=<?php echo $mode ?>";
                                                    });


	});

                    </script>

 <div style="padding:10px;">
    <strong>礼品管理 / Goods Manager </strong></div>
     <div style="padding:10px"> <input  name="addgoods" type="button" class="buttom" id="addgoods" value="添加图片 / Add Photo" /></div>
 <form name="functionGallery" id="functionGallery" action="" method="post">
<div id="editbox"  class="funtion_show"   >
 <strong>添加礼品图片/ Add Photo </strong> 
  <div style="width:350px; float:left;  " >  
       <dd>图片所属类别/ Select Catego: <select name="category_id" id="category_id">
                                                <option value="" selected="selected">Select Category</option>
											<?php foreach ($category as $row): ?>
                                                    <option value="<?php echo $row->class_id; ?>">
												<?php for ($i = 0; $i < $row->deep; $i++): ?>
												<?php echo " &nbsp; " ?>
											<?php endfor; ?>
										<?php echo $row->class_name; ?>
                                  </option>
											<?php endforeach; ?>
                            </select></dd>
                            <dd>上传图片 / Photo:  <a  id="button4">选择图片</a>
                                <a id="del_Pic"></a>
                                
                                <input type="hidden" name="Pic" id="Pic" value="" /></dd>
                                <dd>图片名称 / Photo Name:   
                                <input type="text" name="goodsName" id="goodsName" value="" /></dd>
                  </div>
                <div style=" float:left; width:400px;">
                <dd>图片说明 / Contents :   
                  <textarea name="goodsContents" cols="20" rows="2" id="goodsContents"></textarea>
        </dd>
                <dd>图片排序 / Photo :   
                <input type="text" name="goodsSort" id="goodsSort" value="" />
                 <input type="hidden" name="id" id="id" value="0"/> 
               
                </dd>
               </div> 
               	<div style="float:left;" >
                    <div id="show_Pic" ></div>
                    <div id="show_Backpic" ></div>
                </div>
                <div style="clear:both;"></div>
                 <dd><button type="submit" name="button" id="button" >确定提交</button> <input type="button" name="canceladd" id="canceladd" value="取消" /></dd>
  
   
        </div>
   </form>


                                                        <form action="<?php echo site_url('admin/goods/multi_del') ?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>" method="post">
                                                            <div style="padding:10px;" >
                                                                类别选择：
                                                                <select name="class_id">
                                                                    <option value="" selected="selected">选择礼品分类</option>
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
                                                                    <thead><tr><th width="40"><input id="all_check" type="checkbox"/></th><th>图片名称</th><th>图片分类</th>
                                                                    <th>介绍</th><!--<th>是否审核</th>--><th>发表日期</th><th>操作</th></tr></thead>
                <?php foreach ($goodss as $row): ?>
                                                                        <tr id="<?php echo $row->goods_id; ?>">
                                                                                <td><input class="all_check" type="checkbox" name="goods_id_<?php echo $row->goods_id; ?>" value="<?php echo $row->goods_id; ?>"/></td>
                                                                                <td><a href="#"><?php echo $row->goodsName; ?></a></td>
                                                                                <td><?php echo $row->class_name ?></td>
                                                                                <td><?php echo $row->goodsContents ?></td>
                                                                                
                                                                                    <td><?php echo $row->post_time ?></td>
                                                                                    <td>
<?php if ($mode == "normal"): ?>
                                                                                            <button class="edit" name="edit" type="button"
                                                                                                    value="<?php echo $row->goods_id; ?>"></button>
                                                                                            <button class="delete" name="del" type="button"
                                                                                                    value="<?php echo $row->goods_id; ?>" ></button>
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
                                                                                                        <option value="" selected="selected">选择礼品分类</option>
<?php foreach ($category as $row): ?>
                                                                                                    <option value="<?php echo $row->class_id; ?>" <?php echo $q == $row->class_id ? "selected='selected'" : "" ?>>
<?php for ($i = 0; $i < $row->deep; $i++): ?>
<?php echo " &nbsp " ?>
<?php endfor; ?>
<?php echo $row->class_name; ?>
                                                                                                        </option>
<?php endforeach; ?>
                                                                                                </select>
                                                                                               
                                                                                        </td>
                                                                                        <td colspan="5"><div align="center"><?php echo $links; ?></div></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </form>

<?php include("foot.php") ?>
