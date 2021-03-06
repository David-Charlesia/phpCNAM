<?php



class Model
{
    private $db;
    private $bd_ville;
    private $bd_account;

    /**
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;

    private function __construct() {
        try {
            include('credentials.php');
            $this->bd_ville = new PDO($dsn, $login, $mdp);
            $this->bd_ville->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->bd_account = new PDO($dnsAccount, $login, $mdp);
            $this->bd_account->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Echec connexion, erreur n°' . $e->getCode() . ':' . $e->getMessage());
        }

        $this->db = sparql_connect( "https://data.bnf.fr/sparql" );
        if( !$this->db ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
    }


    public function verify_city($city) {
        $req = $this->bd_ville->prepare('SELECT ville_nom_simple from villes_france_free where ville_nom_simple= :ville');
        $req->bindValue(':ville', strtolower($city));
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        if(isset($result[0])){
            return true;
        }
        return false;
    }

        /**
     * Méthode permettant de récupérer un modèle car le constructeur est privé (Implémentation du Design Pattern Singleton)
     */
    public static function getModel()
    {

        if (is_null(self::$instance)) {
            self::$instance = new Model();
        }
        return self::$instance;
    }

    public function doRequest($city = "paris") {
        sparql_ns("geo", "http://www.w3.org/2003/01/geo/wgs84_pos#");
        sparql_ns("rdfs", "http://www.w3.org/2000/01/rdf-schema#");
        sparql_ns("rdagroup1elements", "http://rdvocab.info/Elements/");
        sparql_ns("foaf", "http://xmlns.com/foaf/0.1/");
        sparql_ns("dcterms", "http://purl.org/dc/terms/");
        sparql_ns("rdf", "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
        sparql_ns("dcmitype", "http://purl.org/dc/dcmitype/");

        $request = "SELECT ?Spectacle ?Titre ?Date ?focus ?Nom_Lieu ?Latitude ?Longitude
            WHERE {
            ?Spectacle rdf:type dcmitype:Event .
            ?Spectacle dcterms:title ?Titre .
            ?Spectacle dcterms:date ?Date .
            ?Spectacle rdagroup1elements:placeOfProduction ?Lieu .
            ?Lieu foaf:focus ?focus .
            ?focus rdfs:label ?Nom_Lieu .
            ?focus geo:lat ?Latitude .
            ?focus geo:long ?Longitude .
            filter (regex( ?Nom_Lieu,'".$city."'))
            }";
        
        $result = sparql_query( $request );
        if( !$result ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }

        return $result;
    }

    public function doRequestDefault() {
        sparql_ns("geo", "http://www.w3.org/2003/01/geo/wgs84_pos#");
        sparql_ns("rdfs", "http://www.w3.org/2000/01/rdf-schema#");
        sparql_ns("rdagroup1elements", "http://rdvocab.info/Elements/");
        sparql_ns("foaf", "http://xmlns.com/foaf/0.1/");
        sparql_ns("dcterms", "http://purl.org/dc/terms/");
        sparql_ns("rdf", "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
        sparql_ns("dcmitype", "http://purl.org/dc/dcmitype/");

        $request = "SELECT ?Spectacle ?Titre ?Date ?focus ?Nom_Lieu ?Latitude ?Longitude
            WHERE {
            ?Spectacle rdf:type dcmitype:Event .
            ?Spectacle dcterms:title ?Titre .
            ?Spectacle dcterms:date ?Date .
            ?Spectacle rdagroup1elements:placeOfProduction ?Lieu .
            ?Lieu foaf:focus ?focus .
            ?focus rdfs:label ?Nom_Lieu .
            ?focus geo:lat ?Latitude .
            ?focus geo:long ?Longitude
            } LIMIT 500";
        
        $result = sparql_query( $request );
        if( !$result ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }

        return $result;
    }

    public function my_in_array($object, $array) {
        foreach ($array as $item) {
            if($item[0] == $object[0] && $item[1] == $object[1]) {
                return true;
            }
        }
        return false;
    }

    public function connect($pseudo, $pwd){
        if($pwd!=='admin'){
            $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        }

        $req = $this->bd_account->prepare('SELECT * FROM accountPHPCNAM WHERE pseudo = :pseudo AND pwd = :pwd');
        $req->bindValue(':pseudo',$pseudo);
        $req->bindValue(':pwd',$pwd);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        if(isset($result['pseudo'])){
            $_SESSION['id'] = $result['id'];
            $_SESSION['pseudo'] = $result['pseudo'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['privilege'] = $result['privilege'];
            return true;
        }
        return false;
    }
}

?>