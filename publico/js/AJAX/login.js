$("#frmAcceso").on('submit',function(e)
{
	e.preventDefault();
    logina=$("#logina").val();
    clavea=$("#clavea").val();

    $.post("../../app/controladores/usuario.php?op=verifica",
        {"logina":logina,"clavea":clavea},
        function(data)
    {
        if (data != "null")
        {
            $(location).attr("href","escritorio.php");            
        }
        else
        {
            window.alert("Usuario y/o Password incorrectos");
        }
    });
})
