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
                    post_url = "<?php echo site_url("admin/homepage/add") ?>";
                }else{
                    post_url = "<?php echo site_url("admin/homepage/edit") ?>";
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
            action:  '<?php echo site_url('admin/homepage/uploadPicLink') ?>',
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
                
                $('#show_Pic').html("<img src='<?php echo base_url()."attachments/gallery" ?>/"+$('#realname').text()+"' height='100' />");
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

            var url="<?php echo site_url("admin/homepage/getByid/") ?>"+"/"+$(this).val();

            $.getJSON(//使用getJSON方法取得JSON数据
                url,
                function(data){ //处理数据 data指向的是返回来的JSON数据
                   // alert(data.menuName);
                    $("input[name='id']").val(data.hId);
                    $("input[name='hType']").val(data.hType);
					//alert(data.galleryContents);
                    $("input[name='galleryName']").val(data.hTitle);
                    $("input[name='gallerySort']").val(data.hSort);
                    $("#galleryContents").text(data.hContents);
                     $("input[name='Pic']").val(data.hPic);
                    $("input[name='hUrl']").val(data.hUrl);
                    
                    
                   // alert(data.menuPic);
                    if(data.hPic  != "" && data.hPic  != null ){
                        $('#show_Pic').html("<img src='<?php echo base_url()."attachments/gallery" ?>/"+ data.hPic +"' width='320' height='160' />");
                         $('#button4').text('重新上传');
                         $('#del_Pic').text(' - 删除图片');
                    }
                  

                }
         )
    	$('#editbox').show();
        });
	

	// add and edit gallery end
					 $('#all_check').click(function(){
                            $("tr input[type='checkbox']").attr('checked',$(this).attr('checked'));
                        });
                        $("input[name='submit']").click(function(){
                            if(!$(".all_check:checked").length){
                                return false;
                            }
  
                                       if(!confirm('确定要删除吗？此操作将彻底删除该图片！'))
                                                return false;
                                               else
                                          $("form").attr('action','<?php echo site_url('admin/homepage/physical_del') ?>');
   
                                                                });

   

                                                    $("select[name='class_id']").change(function(){
                                                        window.location = "<?php echo site_url('admin/homepage/view') ?>";
                                                    });
                                                    $("select[name='is_verified']").change(function(){
                                                        window.location = "<?php echo site_url('admin/homepage/view') ?>";
                                                    });


	});

                    </script>

 <div style="padding:10px 0 5px 10px; border-bottom:1px solid #666;">
    <strong>首页 AD 图片管理 </strong></div>
     <div style="padding:10px"> <input  name="addgallery" type="button" class="buttom" id="addgallery" value="添加  AD 图片" />
       
 </div>
 
 <form name="functionGallery" id="functionGallery" action="" method="post">
<div id="editbox"  class="funtion_show" >
       <div style=""> <strong>添加图片/ Add Photo </strong></div>
                
              <div style=" float:left; width:600px; " >  
                     <dd>上传图片 / Photo: <input type="hidden" name="hType" id="hType" value="1" /> <a  id="button4">选择图片</a>
                       <a id="del_Pic"></a>
                        
                       <input type="hidden" name="Pic" id="Pic" value="" />
                       (广告图片尺寸：696×308px；新品图片：696×185px)
                     </dd>
                        <dd>图片名称 / Photo Title:   
         <input type="text" name="galleryName" id="galleryName" value="" /></dd>
                          <dd>链接地址 / LinkUrl:   
 <input name="hUrl" type="text" id="hUrl" value="" size="60" /></dd>
                       
                        <dd>图片说明 / Contents :   
                          <textarea name="galleryContents" cols="20" rows="1" id="galleryContents"></textarea>
                </dd>
                        <dd>图片排序 / Photo :   
                        <input type="text" name="gallerySort" id="gallerySort" value="" /></dd>
                         <input type="hidden" name="id" id="id" value="0"/>
                          <input type="hidden" name="hType" id="hType" value="1" />
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
                                                                 <table  class="treeTable">
                                                                    <thead><tr><th width="40"><input id="all_check" type="checkbox"/></th>
                                                                      <th>图片</th>
                                                                      <th>排序</th>
                                                                      <th>图片名称</th>
                                                                    <th>链接Url</th> <th>发表日期</th><th>操作</th></tr></thead>
                <?php foreach ($adPics as $row): ?>
                                                                        <tr id="<?php echo $row->hId; ?>">
                                                                                <td><input class="all_check" type="checkbox" name="hId_<?php echo $row->hId; ?>" value="<?php echo $row->hId; ?>"/></td>
                                                                                <td valign="middle"><img src="<?php echo base_url()?>attachments/gallery/<?php echo $row->hPic; ?>" width="160" height="80" /></td>
                                                                                <td valign="top"><?php echo $row->hSort ?></td>
                                                                                <td valign="top"><?php echo $row->hTitle ?></td>
                                                                                <td valign="top"><?php echo $row->hUrl ?></td>
                                                                                
<td valign="top"><?php echo $row->post_time ?></td>
                                                                                    <td valign="middle">

                                                                                      <button class="edit" name="edit" type="button"
                                                                                                    value="<?php echo $row->hId; ?>"></button>
                                                                                           <!-- <button class="delete" name="del" type="button"
                                                                                                    value="<?php echo $row->hId; ?>" ></button>-->

</td>
                                                                                </tr>
<?php endforeach; ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <input type="submit" value="  " name="submit"  class="delete"/>
                                                                                                </td>
                                                                                    <td>&nbsp;</td>
                                                                                        <td colspan="6"><div align="center"></div></td>
                                                                                        </tr>
                                                              </table>
                                                                                </form>
<!-- newProducts start 
 <div style="padding:40px 0 5px 10px; border-bottom:1px solid #666;">
    
     <strong>新产品首页显示 </strong>
    </div>
     <div style="padding:0px">&nbsp;
 </div>
 
 


                                                        <form action="<?php echo site_url('admin/gallery/multi_del') ?>" method="post">
                                                                 <table  class="treeTable">
                                                                    <thead><tr><th width="40"><input id="all_check" type="checkbox"/></th>
                                                                      <th>图片</th><th>图片名称</th>
                                                                    <th>链接Url</th> <th>发表日期</th><th>操作</th></tr></thead>
                <?php foreach ($newproducts as $row): ?>
                                                                        <tr id="<?php echo $row->hId; ?>">
                                                                                <td><input class="all_check" type="checkbox" name="hId_<?php echo $row->hId; ?>" value="<?php echo $row->hId; ?>"/></td>
                                                                                <td valign="middle"><img src="<?php echo base_url()?>attachments/gallery/<?php echo $row->hPic; ?>" width="160" height="80" /></td>
                                                                                <td valign="top"><?php echo $row->hTitle ?></td>
                                                                                <td valign="top"><?php echo $row->hUrl ?></td>
                                                                                
<td valign="top"><?php echo $row->post_time ?></td>
                                                                                    <td valign="middle">

                                                                                      <button class="edit" name="edit" type="button"
                                                                                                    value="<?php echo $row->hId; ?>"></button>
                                                                                           <!-- <button class="delete" name="del" type="button"
                                                                                                    value="<?php echo $row->hId; ?>" ></button> 

</td>
                                                                   </tr>
<?php endforeach; ?>
                                                                                <tr>
                                                                                    <td>
                                                                                       <!-- <input type="submit" value="  " name="submit"  class="delete"/> 
                                                                                  </td>
                                                                                    <td>&nbsp;</td>
                                                                                        <td colspan="5"><div align="center"></div></td>
                                                                   </tr>
                                                              </table>
      </form>
newProducts end -->
<?php include("foot.php") ?>
