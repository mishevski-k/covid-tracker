<?php

class CountriesController extends Controller {

    public function __construct() {
        $this->countriesModel = $this->model("CountryModel");
    }

    public function index() {
        $cases = $this->countriesModel->getCases();
        $countries = $this->countriesModel->getCountries();
        $country = $this->countriesModel->getCountry('Macedonia, Republic of');

        $country = [
            'name' => $country->name,
            'active' => $country->active,
            'recovered' => $country->recovered,
            'deaths' => $country->deaths,
            'confirmed' => $country->confirmed,
            'date' => $country->date,
            'filter' => "total",
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
                'filter' => 'total',
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
            'countriesCases' => $cases,
            'global' => $global,
            'country' => $country,
            'countries' => $countries,
        ];
        

        $this->view("/pages/countries", $data);
    }

    public function create($table) {
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $query = "";

            $data = [
                'message' => ''
            ];

            if($table === "countries") {
                $query = "
                            CREATE TABLE IF NOT EXISTS countries (
                                id int AUTO_INCREMENT,
                                slug varchar(255) NOT NULL UNIQUE,
                                name varchar(255) NOT NULL UNIQUE,
                                status boolean,
                
                                CONSTRAINT id PRIMARY KEY (id)
                            )";
                if($this->countriesModel->createTable($query)) {
                    $data['message'] = "Successfully created countries table";
                } else {
                    $data['message'] = "Failed! An error occured";
                }
  
            }elseif($table === "cases") {
                $query = "CREATE TABLE IF NOT EXISTS cases (

                    id int AUTO_INCREMENT,
                    country_id int NOT NULL,
                    name varchar(255) NOT NULL,
                    active bigint NOT NULL,
                    deaths bigint NOT NULL,
                    new_deaths bigint NOT NULL,
                    recovered bigint NOT NULL,
                    new_recovered bigint NOT NULL,
                    confirmed bigint NOT NULL,
                    new_confirmed bigint NOT NULL,
                    date varchar(255) NOT NULL,
                    
                    CONSTRAINT id PRIMARY KEY (id),
                    
                    CONSTRAINT country_id FOREIGN KEY (country_id) REFERENCES countries(id)
                    
                )";

                if($this->countriesModel->createTable($query)) {
                    $data['message'] = "Successfully created cases table";
                } else {
                    $data['message'] = "Failed! An error occured";
                }
                
            }elseif($table === "global") {
                $query = "CREATE TABLE IF NOT EXISTS global (

                    id int AUTO_INCREMENT,
                    name varchar(255) NOT NULL,
                    active bigint NOT NULL,
                    deaths bigint NOT NULL,
                    new_deaths bigint NOT NULL,
                    recovered bigint NOT NULL,
                    new_recovered bigint NOT NULL,
                    confirmed bigint NOT NULL,
                    new_confirmed bigint NOT NULL,
                    date DATETIME NOT NULL,
                    
                    CONSTRAINT id PRIMARY KEY (id)
                    
                )";

                if($this->countriesModel->createTable($query)) {
                    $data['message'] = "Successfully created global table";
                } else {
                    $data['message'] = "Failed! An error occured";
                }
                
            }

            header("location:" . URLROOT . "/admin");

        } elseif($_SERVER['REQUEST_METHOD'] == "GET") {
            header("location:" . URLROOT . "/admin");
        }

        
    }

    public function delete($table) {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            
            $data = [
                'message' => ''
            ];

            if($table == "countries") {
                
                $query = "DROP TABLE IF EXISTS countries ";

                if($this->countriesModel->deleteTable($query)){
                    $data['message'] = "successfully deleted countries table";
                } else {
                    $data['message'] = "FAILED! An error occured";
                }
            } elseif($table === "cases") {
                $query = "DROP TABLE IF EXISTS cases";

                if($this->countriesModel->deleteTable($query)){
                    $data['message'] = "successfully deleted cases table";
                } else {
                    $data['message'] = "FAILED! An error occured";
                }
            }elseif($table === "global") {
                $query = "DROP TABLE IF EXISTS global";

                if($this->countriesModel->deleteTable($query)){
                    $data['message'] = "successfully deleted global table";
                } else {
                    $data['message'] = "FAILED! An error occured";
                }
            }elseif($table === "new_global") {
                $query = "DROP TABLE IF EXISTS new_global";

                if($this->countriesModel->deleteTable($query)){
                    $data['message'] = "successfully deleted new_global table";
                } else {
                    $data['message'] = "FAILED! An error occured";
                }
            }
            
            header("location:" . URLROOT . "/admin");

        } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
            header("location:" . URLROOT . "/admin");
        }
    } 

    public function import($id) {
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            if($id === "countries") {
                $api = file_get_contents("https://api.covid19api.com/countries");
                $data = json_decode($api, true);

                foreach($data as $country) {

                    $try = 0;
                    $sleep = [1, 10, 32];

                    $countryDataApi = file_get_contents("https://api.covid19api.com/total/dayone/country/{$country['Slug']}");

                    while($countryDataApi == FALSE){
                        sleep($sleep[$try]);
                        $countryDataApi = file_get_contents("https://api.covid19api.com/total/dayone/country/{$country['Slug']}");

                        if($try++ >= count($sleep)) {
                            break;
                        } else {
                            $try++;
                        }
                    }

                    $countryData = json_decode($countryDataApi, true);

                    if(count($countryData) > 0) {
                        $status = 1;
                    } else {
                        $status = 0;
                    }

                    $data = [
                        'slug' => $country['Slug'],
                        'country' => $country['Country'],
                        'status' => $status
                    ];

                    $this->countriesModel->insertCountry($data);

                }
            } elseif($id == "data") {
                $countries = $this->countriesModel->getCountries();

                foreach($countries as $country) {
                    $countryapi = file_get_contents("https://api.covid19api.com/total/dayone/country/{$country->slug}");

                    $try = 0;
                    $sleep = [1, 10, 32];

                    while($countryapi == FALSE) {
                        sleep($sleep[$try]);

                        $countryapi = file_get_contents("https://api.covid19api.com/total/dayone/country/{$country->slug}");

                        if($try++ >= count($sleep)) {
                            break;
                        } else {
                            $try ++;
                        }

                    }

                    $countryData = json_decode($countryapi, true);


                    if($lastDate = $this->countriesModel->getLastEntry($country->id)){
                        $endPoint = strtotime(explode("T", $countryData[count($countryData) -1]['Date'])[0]);
                        $startPoint = strtotime(explode("T", $lastDate->date)[0]);
                        $diff = $endPoint - $startPoint;
                        $diff = round($diff / (60 * 60 * 24));

                        $lastEntry = count($countryData);
                        $startEntry = $lastEntry - $diff;
                    } else {
                        $lastEntry = count($countryData) - 60;
                        $diff = 100;
                        $startEntry = $lastEntry - $diff;

                        if($diff > $lastEntry){
                            $startEntry = 0;
                        }
                    }

                    if($diff > $lastEntry){
                        $previousData = [
                            'deaths' => 0,
                            'confirmed' => 0,
                            'recovered' => 0,
                        ];
                    } else {
                        $previousData = [
                            'deaths' => $countryData[$startEntry - 1]['Deaths'],
                            'confirmed' => $countryData[$startEntry - 1]['Confirmed'],
                            'recovered' => $countryData[$startEntry - 1]['Recovered'],
                        ];
                    }

                    

                    while($startEntry < $lastEntry) {
                        $data = [
                            'country_id' => $country->id,
                            'name' => $countryData[$startEntry]['Country'],
                            'active' => $countryData[$startEntry]['Active'],
                            'deaths' => $countryData[$startEntry]['Deaths'],
                            'recovered' => $countryData[$startEntry]['Recovered'],
                            'confirmed' => $countryData[$startEntry]['Confirmed'],
                            'date' => date("Y-m-d H:i:s", strtotime($countryData[$startEntry]['Date'])),
                            'newDeaths' => $countryData[$startEntry]['Deaths'] - $previousData['deaths'],
                            'newConfirmed' => $countryData[$startEntry]['Confirmed'] - $previousData['confirmed'],
                            'newRecovered' => $countryData[$startEntry]['Recovered'] - $previousData['recovered'],
                        ];

                        $previousData = [
                            'deaths' => $countryData[$startEntry ]['Deaths'],
                            'confirmed' => $countryData[$startEntry]['Confirmed'],
                            'recovered' => $countryData[$startEntry]['Recovered'],
                        ];

                        $this->countriesModel->insertCases($data);

                        $startEntry++ ;
                    }
                }

                

                if($this->countriesModel->getRowCount("global") > 0)  {
                    $startPoint = strtotime("+1 day", strtotime($this->countriesModel->getLastGlobalEntry()->date));
                } else {
                    $startPoint = strtotime($this->countriesModel->getFirstEntry(2)->date);
                }

                $endPoint = strtotime($this->countriesModel->getLastEntry(2)->date);

                if($startPoint != $endPoint) {
                    while($startPoint <= $endPoint) {
                        $cases = $this->countriesModel->getSumOfCases(date("Y-m-d H:i:s", $startPoint));
                        
                        $data = [
                            'name' => 'Global',
                            'active' => $cases->active,
                            'recovered' => $cases->recovered,
                            'newRecovered' => $cases->new_recovered,
                            'deaths' => $cases->deaths,
                            'newDeaths' => $cases->new_deaths,
                            'confirmed' => $cases->confirmed,
                            'newConfirmed' => $cases->new_confirmed,
                            'date' => $cases->date,
                        ];
    
                        $startPoint = strtotime("+1 day", $startPoint);
    
                        $this->countriesModel->insertGlobal($data);
                    }
                }

                
            }


            header("location:" . URLROOT . "/admin");
        }
    }

    public function global() {

        $data = [
            'global' => '',
        ];

        if($_SERVER['REQUEST_METHOD'] === "POST") {
            if($_POST['id'] === ""){
                $row = $this->countriesModel->getLastGlobalEntry();

                $global = [
                     'active' => $row->active,
                     'confirmed' => $row->confirmed,
                     'deaths' => $row->deaths,
                     'date' => $row->date,
                     'recovered' => $row->recovered,
                     'filter' => "total",
                ];
            }elseif($_POST['id'] === "global_daily") {
               $row = $this->countriesModel->getLastGlobalEntry();

               $global = [
                    'active' => $row->active,
                    'confirmed' => $row->new_confirmed,
                    'deaths' => $row->new_deaths,
                    'date' => $row->date,
                    'recovered' => $row->new_recovered,
                    'filter' => "daily",
               ];


               
            } elseif($_POST['id'] === "total"){
                $row = $this->countriesModel->getLastGlobalEntry();

                $global = [
                     'active' => $row->active,
                     'confirmed' => $row->confirmed,
                     'deaths' => $row->deaths,
                     'date' => $row->date,
                     'recovered' => $row->recovered,
                     'filter' => "total",
                ];
            } elseif($_POST['id'] === "month"){
                $row = $this->countriesModel->getGlobalSumByDays(30);

                $global = [
                    'active' => $row['active'],
                    'confirmed' => $row['confirmed'],
                    'deaths' => $row['deaths'],
                    'date' => $row['date'],
                    'recovered' => $row['recovered'],
                    'filter' => "month",
               ];
            }elseif($_POST['id'] === "quarter"){
                $row = $this->countriesModel->getGlobalSumByDays(90);

                $global = [
                    'active' => $row['active'],
                    'confirmed' => $row['confirmed'],
                    'deaths' => $row['deaths'],
                    'date' => $row['date'],
                    'recovered' => $row['recovered'],
                    'filter' => "quarter",
                ];
            }
        }

        $data['global'] = $global;
        $this->view("/pages/global-info", $data);
    }

    public function getCountry() {

        if($_SERVER['REQUEST_METHOD'] === "POST"){
            
            $county_select = $_POST['country'];
            $countries = $this->countriesModel->getCountries();

            $country = $this->countriesModel->getCountry($county_select);

            $country = [
                'name' => $country->name,
                'active' => $country->active,
                'recovered' => $country->recovered,
                'deaths' => $country->deaths,
                'confirmed' => $country->confirmed,
                'date' => $country->date,
                'filter' => "",
            ];

            $data = [
                'country' => $country,
                'countries' => $countries,
            ];

            $this->view("/pages/country-info", $data);
        }
    }

    public function country() {


        if($_SERVER['REQUEST_METHOD'] === "POST"){
            
            $country_select = trim($_POST['country']);

            if($_POST['id'] === "country_total") {
                $row = $this->countriesModel->getCountry($country_select);

                $country = [
                    'name' => $row->name,
                    'active' => $row->active,
                    'recovered' => $row->recovered,
                    'deaths' => $row->deaths,
                    'confirmed' => $row->confirmed,
                    'date' => $row->date,
                    'filter' => "total",
                ];

            }elseif($_POST['id'] === "") {
                $row = $this->countriesModel->getCountry($country_select);

                $country = [
                    'name' => $row->name,
                    'active' => $row->active,
                    'recovered' => $row->recovered,
                    'deaths' => $row->deaths,
                    'confirmed' => $row->confirmed,
                    'date' => $row->date,
                    'filter' => "total",
                ];
            }elseif($_POST['id'] === "country_daily") {
                $row = $this->countriesModel->getCountry($country_select);

                $country = [
                    'name' => $row->name,
                    'active' => $row->active,
                    'recovered' => $row->new_recovered,
                    'deaths' => $row->new_deaths,
                    'confirmed' => $row->new_confirmed,
                    'date' => $row->date,
                    'filter' => "daily",
                ];
                
            }elseif($_POST['id'] === "country_month") {
                $row = $this->countriesModel->getCountrySumByDays($country_select, 30);

                $country = [
                    'name' => $row['name'],
                    'active' => $row['active'],
                    'recovered' => $row['recovered'],
                    'deaths' => $row['deaths'],
                    'confirmed' => $row['confirmed'],
                    'date' => $row['date'],
                    'filter' => "month",
                ];
                
            }elseif($_POST['id'] === "country_quarter") {
                $row = $this->countriesModel->getCountrySumByDays($country_select, 90);

                $country = [
                    'name' => $row['name'],
                    'active' => $row['active'],
                    'recovered' => $row['recovered'],
                    'deaths' => $row['deaths'],
                    'confirmed' => $row['confirmed'],
                    'date' => $row['date'],
                    'filter' => "quarter",
                ];
                
            }

            $countries = $this->countriesModel->getCountries();

                $data = [
                    'country' => $country,
                    'countries' => $countries,
                ];

            $this->view("/pages/country-info", $data);
        }
    }


    public function statistic($table) {
        if($table === 'global') {

            $global = $this->countriesModel->getGlobal();

            $data = [
                'data' => $global,
            ];
        }else {
            $country = $this->countriesModel->getCountryAll($table, 0);

            $data = [
                'data' => $country,
            ];
        }

        $this->view("/pages/statistic", $data);
    }
}

?>