var i=0;
function changeColor(){  
var color="#ffffff|#eeeeee|#dddddd|#cccccc|#bbbbbb|#aaaaaa|#999999|#888888|#777777|#666666|#555555|#444444|#333333|#444444|#555555|#666666|#777777|#888888|#999999|#aaaaaa|#bbbbbb|#cccccc|#dddddd|#eeeeee|"; 
color=color.split("|"); 
document.getElementByTagName(span).style.color=color[i % color.length]; 
i=i+1;
return i;
} 
setInterval("changeColor()",100); 
