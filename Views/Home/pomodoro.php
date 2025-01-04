<body>

    <h1>Pomodoro</h1>

    <p id="pomodoro">25:00</p>

    <input type="number" name="minutos" id="inputMinutos" min="5" max="50" step="1" placeholder="25">
    <input type="number" name="segundos" id="inputSegundos" step="1" value="00" hidden>

    <button onclick="pomodoro()">Iniciar</button>
    <button id="pausar" onclick="pausar()">Pausar</button>
</body>

<script>
    function pomodoro(minutos = document.getElementById("inputMinutos").value, segundos = document.getElementById("inputSegundos").value) {
        document.getElementById("pomodoro").innerHTML = minutos + ":" + segundos;
        var milissegundos = (minutos * 60 * 1000) + (segundos*1000);

        contador = setInterval(function() {
            if ((milissegundos / 1000) % 60 == 0) {
                minutos--;
                segundos = 59;
            } else {
                segundos--;
            }

            milissegundos -= 1000;
            if (segundos < 10) {
                document.getElementById("minutos").innerHTML = minutos; + ":0" + segundos;
            } else {
                document.getElementById("pomodoro").innerHTML = minutos + ":" + segundos;
            }

            if (milissegundos == 0) {
                clearInterval(contador);
                document.getElementById("pomodoro").innerHTML = "00:00";
            }
        }, 1000);
    }

    function pausar(){
        clearInterval(contador);
        document.getElementById("pausar").innerHTML = "Continuar";
        document.getElementById("pausar").setAttribute("onclick", "continuar()");
    }
    
    function continuar() {
        texto = document.getElementById("pomodoro").innerHTML;
        tempo = texto.split(":");
        minutos = tempo[0];
        segundos = tempo[1];
        pomodoro(minutos, segundos);
        document.getElementById("pausar").innerHTML = "Pausar";
        document.getElementById("pausar").setAttribute("onclick", "pausar()");
    }
</script>