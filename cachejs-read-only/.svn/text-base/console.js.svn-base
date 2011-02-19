if(!console) {
    // provide some rough kind of console behaviour for IE
    var console = function(){
        var my = {
            log: function(stuff) {
                document.getElementByID("console").value = document.getElementByID("console").value+(stuff+"\n");
                //alert(stuff);
            }
        };
        return my;
    }();
}