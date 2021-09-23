<?php 

class AdminController extends Controller {

    public function __construct() {
        $this->countriesModel = $this->model("CountryModel");
    }

    public function index() {

        if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] != true){
            header("location: " . URLROOT ."/admin/login");
        }

        $tables = $this->countriesModel->getTables();
        $countries = $this->countriesModel->getCountries();
        
        $country = $this->countriesModel->getCountry('Macedonia, Republic of');

        $country = [
            'name' => $country->name,
            'active' => $country->active,
            'recovered' => $country->recovered,
            'deaths' => $country->deaths,
            'confirmed' => $country->confirmed,
            'date' => $country->date,
            'filter' => "",
        ];   

        if($row = $this->countriesModel->getLastGlobalEntry()){
            $global = [
                'active' => $row->active,
                'date' => $row->date,
                'recovered' => $row->recovered,
                'new_recovered' => $row->new_recovered,
                'confirmed' => $row->confirmed,
                'new_confirmed' => $row->new_confirmed,
                'deaths' => $row->deaths,
                'new_deaths' => $row->new_deaths,
                'filter' => '',
            ];
        } else {
            $global = [
                'active' => "0",
                'date' => '',
                'recovered' => '0',
                'new_recovered' => '0',
                'confirmed' => '0',
                'new_confirmed' => '0',
                'deaths' => '0',
                'new_deaths' => '0',
                'filter' => '',
            ];
        }
        
        $data = [
            'tables' => [],
            'message' => '',
            'global' => $global,
            'country' => $country,
            'countries' => $countries
        ];  

        
        if(!empty($tables)) {
        foreach($tables as $table) {
            $rowCount = $this->countriesModel->getRowCount($table->Tables_in_covidtracker);
            array_push($data['tables'], ['name' => $table->Tables_in_covidtracker, 'rowCount' => $rowCount ]);
        }
        }
        $this->view("/admin/dashboard", $data);
    }

    public function login() {

        $data = [
            'adminError' => ""
        ];

        if($_SESSION['admin_logged_in'] != true || !isset($_SESSION['admin_logged_in'])){
            $this->view("/admin/login", $data);
        } else {
            header("location:". URLROOT ."/admin");
        }

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            if($_POST['name'] === 'admin' && $_POST['password'] === '88760922'){
                $_SESSION['admin_logged_in'] = true;

                header("location:". URLROOT ."/admin");
            } else {
                $data = [
                    'adminError' => "Incorrect input"
                ];

                $this->view("/admin/login", $data);
            }

        }

        

        
    }

}

?>