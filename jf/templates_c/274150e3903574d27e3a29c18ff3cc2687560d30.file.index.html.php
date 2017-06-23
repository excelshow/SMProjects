<?php /* Smarty version Smarty-3.1.11, created on 2015-05-29 08:29:43
         compiled from "templates\ie8\index.html" */ ?>
<?php /*%%SmartyHeaderCode:515855558bc33f8b67-59997792%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '274150e3903574d27e3a29c18ff3cc2687560d30' => 
    array (
      0 => 'templates\\ie8\\index.html',
      1 => 1432880974,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '515855558bc33f8b67-59997792',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_55558bc36b5751_66515946',
  'variables' => 
  array (
    'template' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55558bc36b5751_66515946')) {function content_55558bc36b5751_66515946($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("./header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
  
<script type="text/javascript" src="<?php echo base_url();?>
templates/<?php echo $_smarty_tpl->tpl_vars['template']->value;?>
/js/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>
templates/<?php echo $_smarty_tpl->tpl_vars['template']->value;?>
/js/jquery.validate.pack.js"></script>
<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url();?>
templates/<?php echo $_smarty_tpl->tpl_vars['template']->value;?>
/js/jquery-ui.css" />
<script type="text/javascript">
$(document).ready(function(){
	
  function DateDiff(d1,d2){
    var day = 24 * 60 * 60 *1000*365;
	try{    
			var dateArr = d1.split("-");
	   var checkDate = new Date();
			checkDate.setFullYear(dateArr[0], dateArr[1]-1, dateArr[2]);
	   var checkTime = checkDate.getTime();
	  
	   var dateArr2 = d2.split("-");
	   var checkDate2 = new Date();
			checkDate2.setFullYear(dateArr2[0], dateArr2[1]-1, dateArr2[2]);
	   var checkTime2 = checkDate2.getTime();
		
	   var cha = (checkTime - checkTime2)/day;  
			return cha;
		}catch(e){
	   return false;
	}
 };
		 // 入职时间段判断
jQuery.validator.addMethod("ruzhi", function(value, element) {
    
    var ndDate = $("#ndDate").val();
	//	alert(ndDate);
		 var dayNum = DateDiff(ndDate+"-01-01",value);
			if (dayNum >= 3) { 
				return true;
			}else{
				return false;
			}
}, "入职期限为三年以上才可以申请！");   
	var js = {
		  
            rules: {
				ndDate:{required: true},
				zd:{required: true,range:[5,11]},
                amb: {required: true},
				rzrq:{required: true,dateISO:true,ruzhi:true},
				gzd:{required: true},
				fcs:{required: true,range:[0,1]},
				cd:{required: true,range:[1,1]},
				//jds:{required: true},
				//bns:{required: true},
				//nds:{required: true},
            },
            messages: {
                ndDate:{required: "申请年度必填"},
				zd:{required: "职等必填",range: "职等必须在5级(包含5级)以上才能申请！"},
				amb:{required: "是否阿米巴长/专家必填"},
				rzrq:{required: "日期必填，格式:YYYY-mm-dd",dateISO:"填写正确的时间格式，格式:YYYY-mm-dd"},
				gzd:{required: "工作地必填"},
				fcs:{required: "家庭房产数量必填",range:"家庭成员工作地房产数量必须在1套以内(包含1套)！"},
				cd:{required: "绩效是否有C/D必填",range: "绩效有C的目前不予申请！"},
				//jds:{required: "季度考核S次数必填"},
				//bns:{required: "半年度考核S次数必填"},
				//nds:{required: "年度考核S次数必填"},
            },
            submitHandler:function(){
               var post_data = $("#subForm").serializeArray();
			  // return false;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('index/getResult');?>
",
                    cache:false,
                    data: post_data,
                    success: function(msg){
						//alert(msg);
 					 	$(".text-success").html(msg);
					 	$( "#dialog" ).dialog({ 
							modal: true,
							height: 220,
							width:400,
							buttons: {
							"关闭窗口": function() {
							  $( this ).dialog( "close" );
							}
						  }
						 });
                    },
                    error:function(){
                        hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                    }
                });
				//deptname = $("#ou_name").val();
				//checkDeptname(deptname);  // check dept name
				//alert(checkdeptname);
				return false;
                
            }
        };
 	$('#subForm').validate(js);
			// function adduser end
    });
     
</script>
<div id="dialog" title="计算结果" style="display:none;">
  <div class='shjg'>您的积分评估值为: <span class='text-success'></span> 分</div>
</div>
<div class="" style=""> 
    <!-- contents 1 --->
    <div class="row">
            <!-- form -->
            <form name="subForm" id="subForm"  class="form-horizontal"  method="post"     action=""  >
                <div class="my-form form-horizontal">
                    <!-- modal body start -->
                    <div class="col-xs-12">
                        <div  class="col-xs-3">
                           
                        </div>
                        <div  class="col-xs-9">
                            <div class="form-group">
                                <label class="col-xs-3 control-label" for="ndDate">申请年度</label>
                                <div class="col-xs-4">
                                 <select data-toggle="select" id="ndDate" name="ndDate" class="form-control select select-info select-sm">
                                        <option value="2015">2015年度</option>
                                        <option value="2016">2016年度</option>
                                        <option value="2017">2017年度</option>
                                        <option value="2018">2018年度</option>
                                        <option value="2019">2019年度</option> 
                                        <option value="2019">2020年度</option>                                 
                                    </select> 
                                </div>  
                            </div>
                        </div>

                    </div>

                    <!-- 个人基本信息 -->
                    <div class="col-xs-12">
                       <h2 style=" position:absolute;"> 个人基本信息</h2 
                        ><div  class="col-xs-9">



                            <div class="form-group">
                                <label class="col-xs-3 control-label" for="zd">职等</label>
                                <div class="col-xs-4"> 
                                    <select data-toggle="select" id="zd" name="zd" class="form-control select select-default select-sm" > 
                                        <option value="">&nbsp;</option>
                                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=11) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>  
                                        <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']+1;?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']+1;?>
 </option>
                                        <?php endfor; endif; ?>  

                                    </select><label class="error" >*</label>
                                    <span   class=" popover-show" 
       data-container="body" 
      data-toggle="popover" 
      data-content="抱歉通知您：您未达到申请人基本要求，职等必须在5级(包含5级)以上才能申请！">
       
   </span>
                                </div>  
                            </div>


                            <div class="form-group">
                                <label class="col-xs-3 control-label" for="amb">是否阿米巴长/专家</label>
                                <div class="col-xs-4"> 
                                    <select data-toggle="select" id="amb" name="amb" class="form-control select select-default select-sm"> 
                                        <option value=""></option>
                                        <option value="0">否</option>
                                        <option value="1">是</option>                                  
                                    </select><label class="error" >*</label>
                                </div>  
                            </div>

                            <div class="form-group ">
                                <label class="col-xs-3 control-label" for="rzrq">入职日期</label>
                                <div class="col-xs-4"> 
                                <input type="text" class="form-control input-sm " name="rzrq"  id="rzrq" placeholder="格式:YYYY-mm-dd"/><label class="error" >*</label>
                                <label class="" for="rzrq">格式:2015-01-01</label>
                                 <span class="rzrq-show" style="float:right;" data-placement="right"
                                   		 data-container="body" 
                                         data-toggle="popover" data-content="抱歉通知您：您未达到申请人基本要求，入职期限为三年以上！">
                                 </span>
                                </div>    
                            </div>

                            <div class="form-group ">
                                <label class="col-xs-3 control-label" for="gzd">工作地</label>
                                <div class="col-xs-4">
                                    <select data-toggle="select" id="gzd" name="gzd" class="form-control select select-default select-sm"> 
                                        <option value=""></option>
                                        <option value="上海">上海</option>
                                        <option value="温州">温州</option>   
                                        <option value="北京">北京</option>
                                        <option value="天津">天津</option>
                                        <option value="广州">广州</option>
                                        <option value="中山">中山</option>   
                                        <option value="武汉">武汉</option>
                                        <option value="长春">长春</option>
                                        <option value="沈阳">沈阳</option>
                                        <option value="深圳">深圳</option>                              
                                    </select><label class="error" >*</label>
                                </div>  
                            </div> 
                            <div class="form-group  ">
                                <label class="col-xs-3 control-label" for="fcs">家庭成员工作地房产数量</label>
                                <div class="col-xs-4">
                                    
                                     <select data-toggle="select" id="fcs" name="fcs" class="form-control select select-default select-sm" > 
                                        <option value="">&nbsp;</option>
                                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=3) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>  
                                        <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
 </option>
                                        <?php endfor; endif; ?>  
										<option value="3">2套以上</option>
                                    </select><label class="error" >*</label>
                                    <span   class=" fcs-show" 
       data-container="body" 
      data-toggle="popover" 
      data-content="抱歉通知您：您未达到申请人基本要求，家庭成员工作地房产数量必须在1套以内(包含1套)！">
       
   </span>
                                </div>  
                            </div>

                        </div>
                    </div>
                    <!-- 个人基本信息 -->
                    <!-- 前两年绩效信息 -->
                    <div class="col-xs-12">
                       <h2 style=" position:absolute;"> 前两年绩效信息 </h2>
                        <div  class="col-xs-9">

                            <div class="form-group">
                                <label class="col-xs-3 control-label" for="cd">是否有C/D</label>
                                <div class="col-xs-4"> 
                                    <select data-toggle="select" id="cd" name="cd" class="form-control select select-default select-sm"> 
                                        <option value=""></option>
                                        <option value="0">是</option>
                                        <option value="1">否</option>                                  
                                    </select><label class="error" >*</label>
                                    <span   class=" cd-show" 
                                       data-container="body" 
                                      data-toggle="popover" 
                                      data-content="抱歉通知您：您未达到申请人基本要求，绩效有C的目前不予申请！">
                                       
                                   </span>
                                </div>  
                            </div>


                            <div class="form-group">
                                <label class="col-xs-3 control-label" for="jds">季度考核S次数</label>
                                <div class="col-xs-4"> 
                                    <select data-toggle="select" id="jds" name="jds" class="form-control select select-default select-sm"> 
                                        <option value=""></option>
                                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=9) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>  
                                        <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
 </option>
                                        <?php endfor; endif; ?>                                
                                    </select>
                                      
                                </div>  
                            </div>

                            <div class="form-group ">
                                <label class="col-xs-3 control-label" for="bns">半年度考核S次数</label>
                                <div class="col-xs-4"> 
                                    <select data-toggle="select" id="bns" name="bns" class="form-control select select-default select-sm"> 
                                        <option value=""></option>
                                         <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=5) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>  
                                        <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
 </option>
                                        <?php endfor; endif; ?>                                 
                                    </select>
                                </div>  
                            </div>

                            <div class="form-group ">
                                <label class="col-xs-3 control-label" for="nds">年度考核S次数</label>
                                <div class="col-xs-4">
                                    <select data-toggle="select" id="nds" name="nds" class="form-control select select-default select-sm"> 
                                        <option value=""></option>
                                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=3) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>  
                                        <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
 </option>
                                        <?php endfor; endif; ?>                                  
                                    </select>
                                </div>  
                            </div> 

                        </div>
                    </div>
                    <!-- 前两年绩效信息 -->

                </div>
                <div  style="text-align:center;">
                    <p class="small" style=" font-size:12px;"><span class="text-danger" style="color:#090;">释义：</span> 家庭成员：已婚人士家庭成员含夫妻双方和子女，未婚人士家庭成员含自己和父母。</p>
                </div>
                <div class="col-xs-12" style="text-align:center;">
                     
                        
                        <div class="col-xs-6"> 
                            &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;  <button type="submit" class="btn btn-primary btn-lg" name="signup" value="Sign up">提交计算</button> &nbsp;&nbsp; 
                            
                        </div>
                    
                </div>
            </form>
            <!--FORM END  -->
         
    </div>
    <!-- contents 1 ---> 
</div>
 
<?php echo $_smarty_tpl->getSubTemplate ("./foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>