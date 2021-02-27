<?php
/* by @anandabaskara from Visual Studio Code with ❤️ */
    header('Content-Type: application/json');

    $PRIVATEKEY = "CloudComputing2020";

    /* connect to database, checking login credential, database type, etc */
    function dbConnection() {
        $host = '127.0.0.1';
        $username = 'root';
        $password = '';
        $dbname = 'tiketku';

        $conn = mysqli_connect($host, $username, $password, $dbname);
        if (!$conn) {
            echo "Connection failed, please check your login configuration";
            return false;
        } else {
            if(mysqli_set_charset($conn, "utf8")) {
                return $conn;
            } else {
                echo "Utf8 not compatible, please change your login configuration and database type";
                return false;
            }
        }
    }

    /* hashing pass */
    function hashSHA256($text) {
        return hash('sha256', $text);
    }

    /* sanitasi variabel untuk mengecek dan memfilter karakter ilegal */
    function sanitasiVariabel($conn, $value) {
        return htmlspecialchars(mysqli_real_escape_string($conn, $value));
    }


    function login($username, $password) {
        $dbconn = dbConnection();

        $username = sanitasiVariabel($dbconn, $username);
        $password = hashSHA256($password);

        /* fungsi select dari database untuk mengecek ketersediaan login credential pada tabel username */
        $SQL = "SELECT * FROM tb_login WHERE username = '" . $username . "' AND password='" . $password . "'";
        $result = mysqli_query($dbconn, $SQL);

        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }

        mysqli_close($dbconn);

    }

    /* jika ada, kembalikan ke valie cstring */
    function generateToken($username, $waktu, $pkey) {
        //formula : username.tanggallogin.privatekey
        //ex : admin.12122020.CloudComputing2020

        $cstring = $username . $waktu . $pkey;
        return hashSHA256($cstring);
    }

    // token stuff
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (login($username, $password)) {
            //GENERATE TOKEN

            $waktulogin = date("YmdHis"); //20201212102445
            $token = generateToken($username, $waktulogin, $PRIVATEKEY);

            $informasi = array(
                'username' => $username,
                'waktulogin' => $waktulogin,
                'token' => $token,
            );

            $informasi64 = base64_encode(json_encode($informasi));

            $response = array(
                'status' => true,
                'token' => $informasi64,
            );

            echo json_encode($response);
        } else {
            //FAILED
            $response = array(
                'status' => false,
                'token' => '',
            );

            echo json_encode($response);
        }
    }


    /* $username = "admin";
    $password = "12345";

    if (login($username, $password) == true) {
        echo generateToken($username, "12122020", $PRIVATEKEY);
    } else {
        echo "Failed";
    } */

?>