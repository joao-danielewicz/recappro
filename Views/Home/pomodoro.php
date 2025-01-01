<body>

    <h1>Pomodoro</h1>

    <p id="pomodoro"></p>

    <button onclick="pomodoro()">teste</button>
</body>

<script>
    function pomodoro() {
        var minutos = 1;
        var milissegundos = (minutos * 60 * 1000);

        var contador = setInterval(function() {
            if ((milissegundos / 1000) % 60 == 0) {
                minutos--;
                segundos = 59;
            } else {
                segundos--;
            }

            milissegundos -= 1000;
            document.getElementById("pomodoro").innerHTML = minutos + ":" + segundos;

            if (milissegundos == 0) {
                clearInterval(contador);
                document.getElementById("pomodoro").innerHTML = "00:00";
            }
        }, 1000);
    }
</script>