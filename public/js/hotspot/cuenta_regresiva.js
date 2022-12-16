window.onload = updateClock;

var boton_gratis = document.getElementById("boton_gratis");
//boton_gratis.disabled = true;

 
/*    */
var totalTime = 10;
function updateClock() {
    document.getElementById("countdown").innerHTML = totalTime;
    if (totalTime == 0) {
        //$("#boton_gratis").removeClass("disabled");
       // boton_gratis.disabled = false;
        boton_gratis.classList.replace("bg-amarillo-600", "bg-yellow-500");
        boton_gratis.classList.remove('not-active');
        document.getElementById("countdown").innerHTML = "Conectate aquí";
        //$('#myModal').modal('hide')
    } else {
        totalTime -= 1;
        setTimeout("updateClock()", 1500);
    }
}
