function doRedirect(link, sec) {
if (link == "this") {
	link = window.location.href;
}
window.setTimeout("location.href='"+link+"'", sec);
}

function makelogin(base){
usr = document.getElementById("username").value
pass=document.getElementById("password").value
var poststr = "s=s&username=" + encodeURI(usr) + "&password=" + encodeURI(pass)
$.ajax({
   type: "POST",
   url: base + 'login.php',
   data: poststr,
   success: function(msg){
   $("#notify").html(msg);
   }
 });
//new ajax (, {postBody: poststr, update: $('notify')});

}
function updateWidgets(base){
$("#notify").html('<img src="'+base+'system/images/loading.gif" />');
ApriOscura();
jso = $("input[name=widgetsContent]").attr('value');
var poststr = "json=" + encodeURI(jso)
$.ajax({
   type: "POST",
   url: base + 'index.php?ajax=savewidgetstatus',
   data: poststr,
   success: function(msg){
   $("#notify").html(msg);
   doRedirect(base,3000);
   }
 });
//new ajax (, {postBody: poststr, update: $('notify')});

}

function makelogout(base){
var poststr = "l=l";
$.ajax({
   type: "POST",
   url: base + 'login.php',
   data: poststr,
   success: function(msg){
   $("#notify").html(msg);
   }
 });

//new ajax (base + 'login.php', {postBody: 'l=l', update: $('notify')});
}

function getScrollXY() {
  var scrOfX = 0, scrOfY = 0;
  if( typeof( window.pageYOffset ) == 'number' ) {
    //Netscape compliant
    scrOfY = window.pageYOffset;
    scrOfX = window.pageXOffset;
  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
    //DOM compliant
    scrOfY = document.body.scrollTop;
    scrOfX = document.body.scrollLeft;
  } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
    //IE6 standards compliant mode
    scrOfY = document.documentElement.scrollTop;
    scrOfX = document.documentElement.scrollLeft;
  }
  document.getElementById("oscura").style.width = scrOfX;
  document.getElementById("oscura").style.height = scrOfY;
  return [ scrOfX, scrOfY ];
}
function ApriOscura(lol) {
	if (!lol > 0)
		lol = 0;
	lol += 10;

//    if (navigator.appVersion.indexOf("MSIE")!=-1){
//         document.getElementById("oscura").style.width = screen.width;
//         document.getElementById("oscura").style.height = screen.height;
//    }
    a = lol/100;
	document.getElementById("oscura").style.display = "block";

	document.getElementById("notify").style.display = "block";
	document.getElementById("oscura").style.filter = "alpha(opacity="+lol+")";
    document.getElementById("oscura").style.opacity = a;
    if( lol < 70)
	setTimeout('ApriOscura('+lol+')', 50);
 $('#oscura').height($(document).height());
}

function ChiudiOscura(lol) {
		if((lol<=70) && (lol>0))
			lol -= 10;
		else
			lol = 70;
		a = lol/100;
	document.getElementById("oscura").style.filter = "alpha(opacity="+lol+")";
    document.getElementById("oscura").style.opacity = a;
    if( lol > 0)
	setTimeout('ChiudiOscura('+lol+')', 50);
	else{
	document.getElementById("oscura").style.display = "none";
	document.getElementById("notify").style.display = "none";
	}
}
