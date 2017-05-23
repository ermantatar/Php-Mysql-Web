<?php
class access {

        // it is my main class to access to database.
        

        var $host = null;
        var $user = null;
        var $pass = null;
        var $name = null;
        var $conn = null;
        var $result = null;


        //constructing function 
        function __construct($dbhost, $dbuser, $dbpass, $dbname){
                $this->host = $dbhost;
                $this->user = $dbuser;
                $this->pass = $dbpass;
                $this->name = $dbname;

        }

        //establish connection function
        public function database_connect(){

                //establish connection to store it inside the conn
                $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);

                //if error
                if(mysqli_connect_errno()){
                        echo "Could not connect to database! </br>";
                }

                //support all languages
                $this->conn->set_charset("utf8");

        }


        public function disconnect(){

                if($this->conn != null){
                        $this->conn->close();
                }
        }


        private static function connect() {
                $pdo = new PDO('mysql:host=127.0.0.1;dbname=Uniso;charset=utf8', 'root', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
        }

        public static function create_query($query, $params = array()) {
                $statement = self::connect()->prepare($query);
                $statement->execute($params);

                if (explode(' ', $query)[0] == 'SELECT') {
                        $data = $statement->fetchAll();
                        return $data;
                }
        }

}
