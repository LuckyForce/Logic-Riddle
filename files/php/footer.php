<?php
//Footer Daten
$name = "Adrian Schauer";
$address = "Wilhelmstraße 7b, 3032 Eichgraben";
$email = "info@adrian-schauer.at";
?>

<div class="bg-dark-grey purple mb-0">
    <div class="row m-0">
        <div class="col centralizer">
            <br>
            <br>
            <p>Impressum:</p>
            <p><?= $name ?></p>
            <p><?= $address ?></p>
            <p>
                <a href="mailto:<?= $email ?>" class="mail purple"><?= $email ?></a>
            </p>
            <br>
        </div>
        <div class="col centralizer">
            <p>&copy; 2021 3BHIF<br>Adrian, Fabian und Erik<br>POS LOGIC Project</p>
        </div>
    </div>
</div>

</body>

</html>