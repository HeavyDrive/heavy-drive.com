jQuery(function () {
    jQuery('#js-datepicker1').datetimepicker({ format:'DD-MM-YYYY HH:mm:ss' });
    jQuery('#js-datepicker2').datetimepicker({ format:'DD-MM-YYYY HH:mm:ss' });

});
alert("coucou");
function include(file)
{
    alert("coucou");
    var script  = document.createElement('script');
    script.src  = file;
    script.type = 'text/javascript';
    script.defer = true;

    document.getElementsByTagName('head').item(0).appendChild(script);

}
/* include*/
include('scripts/navbar.js');