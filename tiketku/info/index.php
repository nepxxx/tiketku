<?php
/* by @anandabaskara from Visual Studio Code with ❤️ */
    header('Content-Type: application/json');

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

    /* mengecek apakah token valid atau tidak */
    function IsValidToken($token) {
        try {
            $PRIVATEKEY = "CloudComputing2020";
            $rawToken = json_decode(base64_decode($token), 1);
            $realtoken = hashSHA256(@$rawToken['username'] . @$rawToken['waktulogin'] . $PRIVATEKEY);
            
            if ($realtoken == @$rawToken['token']) {
                return true;
    
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /* fetching token */
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        try {
            $token = $_POST["token"];

            if (!(IsValidToken($token))) {
                throw new \Exception("Error Processing Token", 1);
            }

            $dbConn = dbConnection();
            if ($dbConn == false) {
                throw new \Exception("Error Processing Request", 1); 
            }

            //start query info

            $response = array(
                'status' => true,
                'informasi' => "",
                'data' => array(),
            );

            //query bruh
            $SQL = "SELECT * FROM tb_tiket";
            $result = mysqli_query($dbConn, $SQL);

            if(mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $buffer = array(
                        "id_tiket" => $row['id_tiket'],
                        "nama_film" => $row['nama_film'],
                        "genre_film" => $row['genre_film'],
                        "harga_tiket" => $row['harga_tiket'],
                        "tanggal_tayang" => $row['tanggal_tayang'],
                        "row_place" => $row['row_place'],
                        "seat_place" => $row['seat_place'],
                        "studio" => $row['studio'],
                    );
                    $response['data'][] = $buffer;
                }
            
            } else {
                throw new \Exception("Error Processing Request,  No Data", 1);
            }

            //end-info

            echo json_encode($response);

            // if error, show this as a dialog window
        } catch (\Exception $e) {
            $response = array(
                'status' => false,
                'informasi' => $e->getMessage(),
            );
            echo json_encode($response);
        }
    }

?>