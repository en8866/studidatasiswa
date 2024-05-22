<!DOCTYPE html>
<html>
<head>
    <title>Form Biodata</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        table {
            border-collapse: collapse;
            margin-top: 50px;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
        td, th {
            padding: 8px;
            text-align: left;
        }
        h2, h3 {
            color: #333;
            text-align: center;
        }
        input[type="text"], input[type="submit"], input[type="button"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"], input[type="button"] {
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #4cae4c;
        }
        input[type="radio"] {
            margin-right: 5px;
        }
        label {
            margin-right: 20px;
        }
        .history {
            background-color: #e9ecef;
            padding: 10px;
            margin-top: 20px;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
        .result-table, .history-table {
            border: 1px solid #ccc;
            width: 100%;
            margin-top: 20px;
        }
        .result-table td, .result-table th, .history-table td, .history-table th {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <form method="POST" name="frmpost" action="">
        <table align="center" border="1" cellpadding="0" cellspacing="0">
            <tr align="center">
                <td><h2><b>Masukkan Biodata Anda</b></h2></td>
            </tr>
            <tr>
                <td>
                    <table width="450" border="0" cellpadding="0" cellspacing="10" align="center">
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><input name="nama[]" type="text" size="40" /></td>
                        </tr>
                        <tr>
                            <td>Tempat Tgl Lahir</td>
                            <td>:</td>
                            <td><input name="tgl[]" type="text" size="40" /></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td>
                                <input type="radio" name="jk" value="Laki - Laki" id="laki" />
                                <label for="laki">Laki - Laki</label>
                                <input type="radio" name="jk" value="Perempuan" id="perempuan" />
                                <label for="perempuan">Perempuan</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Hobi</td>
                            <td>:</td>
                            <td><input name="hobi[]" type="text" size="40" /></td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center"><input type="submit" name="btnOk" value="Simpan" /></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>

    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process form data and display the results
        $nama = $_POST["nama"][0];
        $tgl_lahir = $_POST["tgl"][0];
        $jenis_kelamin = $_POST["jk"];
        $hobi = $_POST["hobi"][0];

        $biodata = "<tr><td>Nama</td><td>$nama</td></tr><tr><td>Tempat Tanggal Lahir</td><td>$tgl_lahir</td></tr><tr><td>Jenis Kelamin</td><td>$jenis_kelamin</td></tr><tr><td>Hobi</td><td>$hobi</td></tr>";

        // Save to session for history
        if (!isset($_SESSION['history'])) {
            $_SESSION['history'] = [];
        }
        array_unshift($_SESSION['history'], $biodata); // Add to the beginning of history array

        echo "<h3>Hasil Biodata:</h3>";
        echo "<table class='result-table'>$biodata</table>";
    }

    // Display history with delete option
    if (!empty($_SESSION['history'])) {
        echo "<div class='history'><h3>History Biodata:</h3><table class='history-table'>";
        foreach ($_SESSION['history'] as $index => $entry) {
            echo "<tr><td><table><tr>$entry</tr></table></td><td><form method='POST'><input type='hidden' name='delete' value='$index'><input type='submit' value='Hapus'></form></td></tr>";
        }
        echo "</table></div>";
    }

    // Handle delete request
    if (isset($_POST['delete'])) {
        $index = $_POST['delete'];
        array_splice($_SESSION['history'], $index, 1);
        header("Location: " . $_SERVER['PHP_SELF']); // Refresh page to update history display
        exit;
    }
    ?>
</body>
</html>