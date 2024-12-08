<?php
if (isset($_POST['upload']) && isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];
    $con = mysqli_connect('localhost', 'root', '', 'biblioteka');

    if (!$con) {
        die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
    }

    if ($file) {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // Pobranie linii z pliku
        foreach ($lines as $index => $line) {
            if ($index % 3 == 0) {
                $imie = trim($line);
                $nazwisko = trim($lines[$index + 1] ?? ''); // Sprawdzenie, czy linia istnieje
                $symbol = trim($lines[$index + 2] ?? '');

                // Hashowanie nazwiska
                $hashed_nazwisko = password_hash($nazwisko, PASSWORD_DEFAULT);

                $q = "INSERT INTO czytelnicy(imie, nazwisko, kod) VALUES ('$imie', '$hashed_nazwisko', '$symbol');";
                mysqli_query($con, $q);
            }
        }
        echo "Dane z pliku zostały przetworzone i zapisane w bazie.";
    } else {
        echo "Nie udało się przesłać pliku.";
    }
    mysqli_close($con);
}
?>