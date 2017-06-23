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
	
	 // add and edit  gallery start
         $("#addgallery").click(function(){
			//alert("");
			 $('#show_Pic').html(" ");
                         $('#button4').text('选择图片');
                         $('#del_Pic').text('');
             $("#functionGallery")[0].reset();
            $('#editbox').show();
        });
		
		 // save data start
        var validation1 = {
            rules: {
                category_id: {required: true},
				galleryName: {required: true},
				Pic: {required: true}
            },
            messages: {
                category_id: {required: "请输入图片所属类别！ Please select category!"},
				galleryName: {required: "请输入图片名称！ Please enter photo's name!"},
				Pic: {required:"请选择图片！ Please select photo!"}
            },
            submitHandler:function(){
                var post_data = $("#functionGallery").serializeArray();
                var post_url;
				//alert($("input[name=id]").val());
                if($("input[name=id]").val() == 0){
                    post_url = "<?php echo site_url("admin/gallery/add") ?>";
                }else{
                    post_url = "<?php echo site_url("admin/gallery/edit") ?>";
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
            action:  '<?php echo site_url('admin/gallery/uploadPicLink') ?>',
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
                
                $('#show_Pic').html("<img src='<?php echo base_url()."attachments/gallery/" ?>/"+$('#realname').text()+"' height='100' />");
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

            var url="<?php echo site_url("admin/gallery/getByid/") ?>"+"/"+$(this).val();

            $.getJSON(//使用getJSON方法取得JSON数据
                url,
                function(data){ //处理数据 data指向的是返回来的JSON数据
                   // alert(data.menuName);
                    $("input[name='id']").val(data.gallery_id);
                    $("select[name='category_id']").attr("value",data.class_id);
					//alert(data.galleryContents);
                    $("input[name='galleryName']").val(data.galleryName);
                    $("input[name='gallerySort']").val(data.gallerySort);
                    $("#galleryContents").text(data.galleryContents);
                    
                    $("input[name='Pic']").val(data.Pic);
                    
                    
                   // alert(data.menuPic);
                    if(data.Pic  != "" && data.Pic  != null ){
                        $('#show_Pic').html("<img src='<?php echo base_url()."attachments/gallery" ?>/"+ data.Pic +"' height='100' />");
                         $('#button4').text('重新上传');
                         $('#del_Pic').text(' - 删除图片');
                    }
                  

                }
         )
    	$('#editbox').show();
        });
	

	// add and edit gallery end

                       
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
                                        window.location = "<?php echo site_url('admin/gallery/view') ?>/<?php //echo $classId; ?>/<?php echo $this->uri->segment(5); ?>";

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
 
                                                                });



                                                    $("select[name='class_id']").change(function(){
                                                        window.location = "<?php echo site_url('admin/gallery/view') ?>/"+$(this).val()+"/"+$("select[name='is_verified']").val();
                                                    });
                                                    $("select[name='is_verified']").change(function(){
                                                        window.location = "<?php echo site_url('admin/gallery/view') ?>/"+$("select[name='class_id']").val()+"/"+$(this).val();
                                                    });


	});

                    </script>

 <div style="padding:10px;">
    <strong>图库管理 / Gallery Manager </strong></div>
     <div style="padding:10px"> <input  name="addgallery" type="button" class="buttom" id="addgallery" value="添加图片 / Add Photo" />
       
 </div><form name="functionGallery" id="functionGallery" action="" method="post">
<div id="editbox"  class="funtion_show" >
        <strong>添加图片/ Add Photo </strong>
                
              <div style=" float:left; width:400px; " >  
                     <dd>图片所属类别/ Select Catego
                                        : <select name="category_id" id="category_id">
                                                        <option value="" selected="selected">Select Category</option>
       												 <?php foreach ($category as $row): ?>
                                                            <option value="<?php echo $row->class_id; ?>">
      														  <?php for ($i = 0; $i < $row->deep; $i++): ?>
        											<?php echo " &nbsp; " ?>
      											  <?php endfor; ?>
      														  <?php echo $row->class_name; ?>
                                          </option>
      													  <?php endforeach; ?>
                                    </select> </dd>
                                    <dd>上传图片 / Photo:  <a  id="button4">选择图片</a>
                        <a id="del_Pic"></a>
                        
                        <input type="hidden" name="Pic" id="Pic" value="" /></dd>
                        <dd>图片名称 / Photo Name:   
                        <input type="text" name="galleryName" id="galleryName" value="" /></dd>
                         
                       </div>   
                      
                      
<div style=" float:left; width:400px; ">
                        <dd>图片说明 / Contents :   
                          <textarea name="galleryContents" cols="20" rows="2" id="galleryContents"></textarea>
                </dd>
                        <dd>图片排序 / Photo :   
                        <input type="text" name="gallerySort" id="gallerySort" value="" /></dd>
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


                                                        <form action="<?php echo site_url('admin/gallery/multi_del') ?>" method="post">
                                                            <div style="padding:10px;" >
                                                                类别选择：
                                                                <select name="class_id">
                                                                    <option value="0" selected="selected">选择图片分类</option>
<?php foreach ($category as $row): ?>
   <option value="<?php echo $row->class_id; ?>" <?php //echo $classId == $row->class_id ? "selected='selected'" : "" ?>>
<?php for ($i = 0; $i < $row->deep; $i++): ?>
<?php echo "&nbsp" ?>
<?php endfor; ?>
<?php echo $row->class_name; ?> </option>
            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <table  class="treeTable">
                                                                    <thead><tr><th width="40"><input id="all_check" type="checkbox"/></th>
                                                                      <th>图片名称</th><th>图片分类</th>
                                                                    <th>介绍</th><!--<th>是否审核</th>--><th>发表日期</th><th>操作</th></tr></thead>
                <?php foreach ($gallerys as $row): ?>
                                                                        <tr id="<?php echo $row->gallery_id; ?>">
                                                                                <td><input class="all_check" type="checkbox" name="gallery_id_<?php echo $row->gallery_id; ?>" value="<?php echo $row->gallery_id; ?>"/></td>
                                                                                <td valign="middle"><?php echo $row->galleryName; ?></td>
                                                                                <td valign="middle"><?php echo $row->class_name ?></td>
                                                                                <td valign="middle"><?php echo $row->galleryContents ?></td>
                                                                                <!--<td><?php echo $row->is_verified == 1 ? "是" : "否" ?></td>-->
                                                                                    <td valign="middle"><?php echo $row->post_time ?></td>
                                                                                    <td valign="middle">
 
                                                                                            <button class="edit" name="edit" type="button"
                                                                                                    value="<?php echo $row->gallery_id; ?>"></button>
                                                                                            <button class="delete" name="del" type="button"
                                                                                                    value="<?php echo $row->gallery_id; ?>" ></button>
 
                                                                                    </td>
                                                                                </tr>
<?php endforeach; ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <input type="submit" value="  " name="submit"  class="delete"/>
 
                                                                                                </td>
                                                                                    <td><select name="class_id">
                                                                                            <option value="" selected="selected">选择图片分类</option>
<?php foreach ($category as $row): ?>
                                <option value="<?php echo $row->class_id; ?>" <?php  // echo $classId == $row->class_id ? "selected='selected'" : "" ?>>
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
