function checkTextBlankById(obj_id, obj_label)
{
	
	if($("#" + obj_id).val().length ==0)
	{
		
	alert(obj_label + " must be specified");
	return false;
	}
	return true;
	
}//function checkTextBlankById(obj_id, obj_label)

function checkTextIllegalCharactersById(obj_id, obj_label)
{
	if(!checkTextBlankById(obj_id, obj_label))
		return false;
 	var illegal_characters = "@#$%^&*!";
 	var str = $("#" + obj_id).val() ;
 	
	for(var i=0; i<illegal_characters.length ; i++)
	{
		if(str.indexOf(illegal_characters.charAt(i)) != -1) //indexOf returns 0 if the lookup string is not found
		{
			alert(obj_label + " contails illegal characters");
			return false;
		}
	}//end for
	return true;
}//end function checkTextIllegalCharactersById(obj_id, obj_label)

function checkDropDownListById(obj_id, value_to_check_against, message)
{
	
	var obj_selected_value= $("#" + obj_id +" option:selected").val();
	
	if(obj_selected_value == value_to_check_against )
	{
		alert(message);
		return false;
	}
	return true;
}//end function checkDropDownListById(obj_id, value_to_check_against, message)


function checkRadioSetClickedByName(radio_names, message)
{
	
	var radios = $("input[name="  + radio_names + "]:radio");
	var ischecked_radio = false;
 	for ( var i = 0; i < radios.length; i++) {
     	if(radios[i].checked) {
         	return true;
         }//end if
 	}//end for
 	if(!ischecked_radio)   { // we completed the loop and none of the genders was checked 
     	alert("Please choose a " + message);
     	return false;
 	}
 	
}//end function checkRadioSetClicked(radio_names, message)
