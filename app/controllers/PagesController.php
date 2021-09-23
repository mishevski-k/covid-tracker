<?php
    Class PagesController extends Controller {
        
        public function __construct() {
            $this->pageModel = $this->model('PageModel');
            $this->countriesModel = $this->model("CountryModel");
        }

        public function index() {  
            $topConfirmed = $this->countriesModel->getTopConfirmed();
            $topRecovered = $this->countriesModel->getTopRecovered();
            $topDeaths = $this->countriesModel->getTopDeaths();
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
                'topConfirmed' => $topConfirmed,
                'topDeaths' => $topDeaths,
                'topRecovered' => $topRecovered,
                'global' => $global,
                'countries' => $countries,
                'country' => $country,
            ];
    
            $this->view("/pages/home", $data);
        }
    }
?>