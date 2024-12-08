<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styl.css">
    <title>Biblioteka publiczna</title>
</head>

<body>
    <header>
        <h1>Biblioteka w Książkowicach Wielkich</h1>
    </header>
    <main>
        <section class="left">
            <h3>Polecamy dzieła autorów:</h3>
            <ol>
                <?php
                // Połączenie z bazą danych
                $con = mysqli_connect('localhost', 'root', '', 'biblioteka');
                if (!$con) {
                    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
                }

                // Skrypt wypisujący autorów
                $q = 'SELECT imie, nazwisko FROM autorzy ORDER BY nazwisko;';
                $result = mysqli_query($con, $q);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<li>$row[0] $row[1]</li>";
                }
                ?>
            </ol>
        </section>
        <section class="mid">
            <h3>ul. Czytelnicza 25, Książkowice&nbsp;Wielkie</h3>
            <p><a href="mailto:sekretariat@biblioteka.pl">Napisz do nas</a></p>
            <img src="biblioteka.png" alt="książki">
        </section>
        <section class="right">
            <!-- Formularz dodawania czytelnika -->
            <section class="right_top">
                <h3>Dodaj czytelnika</h3>
                <form action="index.php" method="post">
                    <label>imie:
                        <input type="text" name="imie" required><br />
                    </label>
                    <label>nazwisko:
                        <input type="text" name="nazwisko" required><br />
                    </label>
                    <label>symbol:
                        <input type="number" name="symbol" required><br />
                    </label>
                    <button name="submit">DODAJ</button>
                </form>
            </section>
            <section class="right_bottom">
                <?php
                // Skrypt dodawania czytelnika
                if (isset($_POST["submit"])) {
                    $imie = mysqli_real_escape_string($con, $_POST['imie']);
                    $nazwisko = mysqli_real_escape_string($con, $_POST['nazwisko']);
                    $symbol = mysqli_real_escape_string($con, $_POST['symbol']);

                    // Hashowanie nazwiska
                    $hashed_nazwisko = password_hash($nazwisko, PASSWORD_DEFAULT);

                    $q = "INSERT INTO czytelnicy(imie, nazwisko, kod) VALUES ('$imie', '$hashed_nazwisko', '$symbol');";
                    if (mysqli_query($con, $q)) {
                        echo "Czytelnik: $imie został(a) dodany do bazy danych.";
                    } else {
                        echo "Błąd: " . mysqli_error($con);
                    }
                }
                ?>
            </section>

            <!-- Formularz masowej rejestracji -->
            <section class="upload">
                <h3>Masowa rejestracja użytkowników</h3>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <label for="file">Wybierz plik tekstowy:</label>
                    <input type="file" name="file" id="file" accept=".txt" required><br>
                    <button type="submit" name="upload">Wyślij plik</button>
                </form>
            </section>
        </section>
    </main>
    <footer>
        <p>Projekt strony: numer zdającego</p>
    </footer>
</body>
</html>