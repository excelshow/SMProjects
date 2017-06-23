<?php $this->load->view("header"); ?>
	 <?php
	   	if ($menuInfo->menuUrl == "contact"){ 
	   ?> 
  <script type="text/javascript">
	$(document).ready(function(){
	   $("#sendemail").click(function(){
		  	if ($("#sendname").val() == ""){
				hiAlert("请输入您的姓名!");
				 $('#sendname').focus();
				return false;
				}
			if ($("#sendtel").val() != ""){
				txt = $("#sendtel").val();
              if (txt.search("^-?\\d+$") != 0) {
                 hiAlert("电话的格式不对，请确认!");
                  return false;
              }
				}
				 

				if ($("#sendemailad").val() == ""){	
				hiAlert("请输入您的E-mail地址!");
				 $('#sendemailad').focus();
				return false;
				}
				var search_str = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
				 var email_val = $("#sendemailad").val();
				 if(!search_str.test(email_val)){        
				 hiAlert("请输入正确的E-mail 地址!");
				 $('#sendemailad').focus();
				 return false;
				 }
				if ($("#sendmessage").val() == ""){
				hiAlert("请输入您的留言!");
				 $('#sendmessage').focus();
				return false;
				}
				
			var post_data = $("#messageLayout").serializeArray();
            var post_url;
            hiAlert('正在提交您的留言,请稍候...');
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('sendmail/sendMailContact');?>",
                cache:false,
                data: post_data,
                success: function(msg){
                   // hiAlert(msg);
                    //flag = (msg=="ok");
                    if(msg == "ok"){
                        // $("#editbox").html("");
                        hiAlert("留言提交成功，我们会尽快给您答复，谢谢您的留言！");
                        
                        //Alert(msg);
                    }else{
                        hiAlert(msg);
                    }
                },
                error:function(){
                    hiAlert("Error!");
                }/**/
            });
			 
			// $("#sendResult").html("Vins-selection a bien recu votre message, merci de votre visite.");
		});
    });
	</script>
     <?php
		}
	   ?>
<div id="layout_main" >
    <div class="layout_main">
        <div class="layout_left floatLeft" >
            <?php $this->load->view("productCategory_layout"); ?>
            <?php //$this->load->view("login_layout"); ?>
        </div>
    </div>

    <div class="right_home">

        <div class="content_link">
            <a href="/">首页</a> > <?php echo $menuInfo->menuName; ?>
        </div> 

        <div id="content_info" class="content_info_css" >
             <?php
         			   if ($menuInfo->menuUrl == "contact") {
   				 ?> 
                 
                 <div class="content_info_detail   floatRight  ">
                    <div class="contactEmail">
                        <form action="" id="messageLayout" name="messageLayout" >
                            <h2>在线留言</h2>
                        <dl>     
                          <label>姓 名<font class="fontRed">*</font></label>
                        
                                <input name="sendname" type="text" class="idealText" id="sendname" size="30" maxlength="30" />
                           </dl>
                          <dl>
                            <label>电话</label>
                              <input name="sendtel" type="text" class="idealText" id="sendtel" size="30" maxlength="15" />
                            </dl>
                          <dl>
                            <label>E-mail <font class="fontRed">*</font></label>
                              <input name="sendemailad" type="text" class="idealText" id="sendemailad" size="30" maxlength="50" />
                            </dl>
                            <dl>
                              <label>留言<font class="fontRed">*</font></label>
                                <textarea name="sendmessage" cols="29" rows="3" id="sendmessage"  ></textarea>
                            </dl>
                          <dl>
                            <label>&nbsp;</label> <input name="sendemail" type="button" class="inputButton" id="sendemail" value=" 提交留言 " />
                                &nbsp; &nbsp;<font class="fontRed">*</font>号必填。
                            </dl>


                        </form>
                    </div>
                </div>
    <?php
            }
    ?>
            <?php
            if ($Info) {
            ?>
                <h1>  <?php echo $Info->title; ?></h1>
                <div class="content_info_detail  <?php if ($menuInfo->menuUrl == "contact"){?> floatLeft <?php }?>">
                <?php echo $Info->content; ?>
                </div> 
                  
            <?php
            } else {
                echo "<BR>暂无信息！";
            }
            ?>
           
        </div>

        <div style="clear:both"></div>
    </div>
   
    <?php $this->load->view("foot.php"); ?>
