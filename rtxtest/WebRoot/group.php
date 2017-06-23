
<script language="JavaScript"
	  src="js/PhpTreeView.js"></script>
	<style>
	A.PhpTreeView
	{
	  font-size: 9pt;
	  padding-left: 3px;
	}
	</style>

<div id=treeviewarea style="background-color: "></div>

<script language="JavaScript">
	  var tree = new PhpTreeView("tree");
	  tree.icons["dept"]  = "dept_close.ico";
	  tree.iconsExpand["dept"] = "dept_open.ico"; // 
	
	  tree.setIconPath("images_qk/"); // 
	
	  //tree.nodes["0_1"] = "text:组织架构";
	
	<?php

	print_r("tree.nodes[\"0_1\"] = \"text:组织架构;icon:dept;data:id=1\";");
	print_r("\r\n");

	$doc = new DOMDocument();
	$doc->load('OrgstructFile\Orgstruct_0.xml',LIBXML_NOBLANKS);

    	$xmlNodes = $doc->documentElement->childNodes->item(0)->childNodes;

    	XmlNode2TreeNode($xmlNodes, 0);

	function XmlNode2TreeNode($xmlNodes, $iPid)
	{

		foreach ($xmlNodes as $XmlNode)
        {
		
	    	$temp= $XmlNode->getAttributeNode('name')->value;	
	    	$strDeptName = iconv("utf-8","gb2312", $temp);
	    
	    	$rtxid = $XmlNode->getAttributeNode('id')->value;	
	    	$id =$rtxid + 1; 

            if ($iPid == 0)
            {
                    $strIndex = "1_". $id;
		    		print_r("tree.nodes[\"$strIndex\"] = \"text:$strDeptName;icon:dept;data:id=$id\";");
            }
            else
            {
	    	    //$iPid = $iPid + 1 ;

                $strIndex = $iPid ."_". $id;
                print_r("tree.nodes[\"$strIndex\"] = \"text:$strDeptName;icon:dept;data:id=$id\";");
           }

           print_r("\r\n");

     	   if ($XmlNode->hasChildNodes())
     	   {
        		XmlNode2TreeNode($XmlNode->childNodes, $id);
     	   }

      	}

	} 
	
?>
	  document.write(tree.toString());    //浜﹀彲鐢?obj.innerHTML = tree.toString();
</script>

