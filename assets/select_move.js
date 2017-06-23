
<!-- -->
 
    function addItem(objFrom,objTo){ 
	var flag = false;  
        for(var i = 0; i < objFrom.options.length;i++){   
            if(objFrom.options[i].selected == true){
		flag = true;   
                var selectItem = new Option(objFrom.options[i].text,objFrom.options[i].value);   
                objTo.options.add(selectItem);   
                objFrom.options.remove(i);   
            }   
        }
	if(!flag){alert("please select a Item");}   
        sortItem(objTo);   
    }   
    function allAddItem(objFrom,objTo){   
        for(var i = objFrom.options.length - 1;i>=0;i--){   
            var objItem = new Option(objFrom.options[i].text,objFrom.options[i].value);   
            objTo.options.add(objItem);   
            objFrom.options.remove(i);       
        }   
        sortItem(objTo);   
    } 
	  
    function sortItem(objTo){   
        var ln = objTo.options.length;   
        var arrText = new Array();   
        var arrValue = new Array();   
        for(var i=0;i<ln;i++){   
            arrText[i] = objTo.options[i].text;   
        }   
        arrText.sort();   
        for(var i=0;i<ln;i++){   
            for(var j = 0;j<objTo.options.length;j++){   
                if(arrText[i] == objTo.options[j].text){   
                   arrValue[i] = objTo.options[j].value;   
                   break;   
                }   
           }   
        }   
        while(ln--){   
            objTo.options[ln] = null;   
        }   
        for(i = 0;i<arrText.length;i++){   
            objTo.add(new Option(arrText[i],arrValue[i]));   
        }   
    } 
	function swapItem(option1,option2){
		var tempStr = option1.value;
		option1.value = option2.value;
		option2.value = tempStr;
		
		tempStr = option1.text;
		option1.text = option2.text;
		option2.text = tempStr;
		
		tempStr = option1.selected;
		option1.selected = option2.selected;
		option2.selected = tempStr;
	} 
	function moveUp(selectObj){
		var obj = selectObj.options;
		for(var i = 1;i<obj.length;i++){
			if(obj[i].selected && !obj[i-1].selected){
				swapItem(obj[i],obj[i-1]);
			}
		}
	} 
	function moveDown(selectObj){
		var obj = selectObj.options;
		for(var i = obj.length -2;i>-1;i--){
			if(obj[i].selected && !obj[i+1].selected){
				swapItem(obj[i],obj[i+1]);
			}
		}
	}
	function moveToTop(selectObj){
		var obj = selectObj.options;
		var oOption = null;
		for(var i = 0;i<obj.length;i++){
			if(obj[i].selected && oOption){
				selectObj.insertBefore(obj[i],oOption);
			}else if(!oOption && !obj[i].selected){
				oOption = obj[i];
			}
		}
	}
	function moveToBottom(selectObj){
		var obj = selectObj.options;
		var oOption = null;
		for(var i = obj.length-1;i> -1;i--){
			if(obj[i].selected){
				if(oOption){
					oOption = selectObj.insertBefore(obj[i],oOption);
				}else{
					oOption = selectObj.appendChild(obj[i]);
				}
			}
		}
	}
 