<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
    <script type="text/javascript" src="http://10.90.18.23/assets/javascript/jquery-1.8.js"></script> 
<script type="text/ecmascript" language="javascript">
  $(document).ready(function(){
	  $('input[name="test"]').click(function(){
			$.ajax({
            type: "POST",
            url: "http://10.90.18.75:8016/Pages/webservice/WSuserrights.asmx/userupdate",
            data: "strname=0&strtext=1&strmemo=1",
          //  dataType:'xml',
            success: function(msg){
      				alert(msg);								 
			},
           error:function(){
					 alert('post error');
                }
        });  
			//loadstaff(data.rslt.obj.attr("id"),key);
		});
         
                
        });
  </script>
</head>
<body>

<div id="container">
	<h1>IMS:  XML-RPC 说明</h1>

	<div id="body">
		<p> 关于详细的规范,浏览 <a href="http://www.xmlrpc.com/">XML-RPC</a> 网站. </p>
      <p> 用户查询接口: <a href="/index.php/xmlrpc_api/ims_client/userseach" target="_blank">userseach()</a>; 
		 </p> 
      <code><p> /index.php/xmlrpc_api/ims_client/userseach
	    </p>
	 
        </code>

	  <p>Return：</p>
	  
     
      
	  <code>
     李振东/森马集团,浙江森马服饰股份有限公司,信息中心,信息部,信息部（上海）,IT服务管理科/邮件外发
     </code><br>
  <p> 用户变更同步接口: <a href="/index.php/xmlrpc_api/ims_client/loaduser" target="_blank">loaduser()</a>; 
		 </p> 
      <code><p> /index.php/xmlrpc_api/ims_client/loaduser
	    </p>
	 
        </code>

	  <p>Return：</p>
	  
     
      
	  <code>
     sdf$s10,s20/lizhendong$S102,S2323
     </code>
  </div>

	
</div>
<form target="_blank" action='' method="POST">                      
                        
                          <table cellspacing="0" cellpadding="4" frame="box" bordercolor="#dcdcdc" rules="none" style="border-collapse: collapse;">
                          <tr>
	<td class="frmHeader" background="#dcdcdc" style="border-right: 2px solid white;">参数</td>
	<td class="frmHeader" background="#dcdcdc">值</td>
</tr>

                        
                          <tr>
                            <td class="frmText" style="color: #000000; font-weight: normal;">strname:</td>
                            <td><input class="frmInput" type="text" size="50" name="strname"></td>
                          </tr>
                        
                          <tr>
                            <td class="frmText" style="color: #000000; font-weight: normal;">strtext:</td>
                            <td><input class="frmInput" type="text" size="50" name="strtext"></td>
                          </tr>
                        
                          <tr>
                            <td class="frmText" style="color: #000000; font-weight: normal;">strmemo:</td>
                            <td><input class="frmInput" type="text" size="50" name="strmemo"></td>
                          </tr>
                        
                        <tr>
                          <td></td>
                          <td align="right"> <input name="test" type="button" class="button" value="调用"></td>
                        </tr>
                        </table>
                      

                    </form>
</body>
</html>