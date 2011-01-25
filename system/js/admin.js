function selecttpl(){

name=document.getElementById("templatename").value;
if(name != 0){
$.ajax({
   type: "POST",
   url: '?p=tpl&t=ajax&m=widgets&type=select',
   data: 'tplname='+name,
   success: function(msg){
   $("#table").html(msg);
   $.jGrowl("Hai selezionato il template {lang.tplmanage}" + name,  {
					theme: 'green',
					header: "Selezione Template"
				});
   }
 });
 }
//new ajax ('?p=tpl&t=ajax&m=widgets&type=select', {postBody: 'tplname='+name, update: $('table'), onComplete: myFunction});
}

function savetpl(){
var dati = $('#form').serialize();
$.post("?p=tpl&t=ajax&m=save&type=save", dati, function(msg){
   $("#main").html(msg);
   $('#notes').markItUp(html);
   $.jGrowl("Hai modoificato il template " + name,  {
					theme: 'green',
					header: "Selezione Template"
				});
   });
}

function loadTplToModify(link,ext,fname,chmod){
if(ext == 'ext-tpl' || ext == 'ext-js' || ext == 'ext-css' || ext == 'ext-php' || ext == 'ext-html' || ext == 'ext-page'){
switch(ext){
    case 'ext-tpl':
        type = 'html';
    break;

    case 'ext-css':
        type = 'css';
    break;

    default:
        type = 'html';
}
if(chmod == 777 || chmod == 666){
$.ajax({
   type: "POST",
   url: '?p=tpl&t=ajax&m=modify&type=load',
   data: 'filelink='+link+'&fileext='+ext+'&fname='+fname,
   success: function(msg){
   $("#main").html(msg);
   $.jGrowl("Stai modificando il file " + fname,  {
					position: 'center',
                                        theme: 'green',
                                        
					header: "Modifica File"
				});
                                if(type == 'css')
                                    $('#notes').markItUp(css);
                                else
                                    $('#notes').markItUp(html);
//   $('#notes').sMarkUp(type, 300);
   }
 });}
 else{
 $.jGrowl("Non puoi modificare <b>" + fname + "</b> perch&egrave; I permessi devono essere impostati su 777",  {
					theme: 'red',
					header: "Permessi non 777"
				});
 }}
 else{
 $.jGrowl("Non puoi modificare <b>" + fname + "</b> perch&egrave; non &egrave; un file riconosciuto",  {
					theme: 'red',
					header: "Modifica File"
				});
 }
}

function addEditor(where, type){
$('#'+where).sMarkUp(type, 300);
}