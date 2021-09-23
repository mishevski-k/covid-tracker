<?php 

class CountryModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getCountries() {
        if($this->tableExists('countries')){
            $this->db->query(" SELECT * FROM countries WHERE status = 1");

            if($row = $this->db->resultSet()) {
                return $row;
            } else {
                return false;
            }
        }
        
    }

    public function getCases() {
        if($this->tableExists('cases')){
            $this->db->query("SELECT countries.name , country_id, confirmed, new_confirmed, recovered, new_recovered, deaths, new_deaths, active, date FROM ( SELECT *, (ROW_NUMBER() OVER (PARTITION BY country_id ORDER BY date DESC)) as row_num FROM cases ) partitioned_table INNER JOIN countries ON countries.id = partitioned_table.country_id WHERE partitioned_table.row_num = 1 ORDER BY confirmed DESC;");

            if($rows = $this->db->resultSet()) {
                return $rows;
            } else {
                return false;
            }
        }
        
    }

    public function getGlobal($limit = 0,$orderBy = 'date', $order = 'DESC') {
        if($this->tableExists('global')){
            if($limit === 0) {
                $this->db->query("SELECT * FROM global ORDER BY $orderBy $order");
            } else {
                $this->db->query("SELECT * FROM global ORDER BY $orderBy $order  LIMIT $limit");
            }
            

            if($row = $this->db->resultSet()) {
                return $row;
            } else {
                return false;
            }
        }
        
    }

    public function getGlobalSumByDays($days) {
        if($this->tableExists('global')){
            $this->db->query("SELECT * from global ORDER BY date DESC LIMIT {$days}");

            if($row = $this->db->resultSet()){
                $confirmed = 0;
                $deaths = 0;
                $recovered = 0;
                foreach($row as $date) {
                    $confirmed = $confirmed + $date->new_confirmed;
                    $deaths = $deaths + $date->new_deaths;
                    $recovered = $recovered + $date->new_recovered;
                }

                $active = $row[0]->active;
                $date = $row[0]->date;

                return [
                    'active' => $active,
                    'confirmed' => $confirmed,
                    'deaths' => $deaths,
                    'recovered' => $recovered,
                    'date' => $date,
                ];
            } else {
                return false;
            }
        }
        
    }

    public function getCountryAll($country, $limit = 0, $orderBy = 'date', $order = 'DESC') {
        if($this->tableExists('cases')){
            if($limit === 0) {
                $this->db->query("SELECT * FROM cases WHERE country_id = '$country' ORDER BY $orderBy $order ");
            } else {
                $this->db->query("SELECT * FROM cases WHERE country_id = '$country' ORDER BY $orderBy $order LIMIT $limit");
            }
            

            if($row = $this->db->resultSet()) {
                return $row;
            } else {
                return false;
            }
        }
    }

    public function getCountry($country,) {
        if($this->tableExists('cases')){
            $this->db->query("SELECT * FROM cases WHERE name = '$country' ORDER BY date DESC ");

            if($row = $this->db->single()) {
                return $row;
            } else {
                return false;
            }
        }


    }

    public function getCountrySumByDays($country, $days) {
        if($this->tableExists('cases')){
            $this->db->query("SELECT * from cases WHERE name = '$country' ORDER BY date DESC LIMIT {$days}");

            if($row = $this->db->resultSet()){
                $confirmed = 0;
                $deaths = 0;
                $recovered = 0;
                foreach($row as $date) {
                    $confirmed = $confirmed + $date->new_confirmed;
                    $deaths = $deaths + $date->new_deaths;
                    $recovered = $recovered + $date->new_recovered;
                }

                $active = $row[0]->active;
                $date = $row[0]->date;

                return [
                    'name' => $country,
                    'active' => $active,
                    'confirmed' => $confirmed,
                    'deaths' => $deaths,
                    'recovered' => $recovered,
                    'date' => $date,
                ];
            } else {
                return false;
            }
        }
        
    }
 
    public function getTopConfirmed() {
        if($this->tableExists('cases')){
            $this->db->query(" SELECT * FROM cases ORDER BY date DESC, confirmed Desc LIMIT 10");

            if($row = $this->db->resultSet())  {
                return $row;
            } else {
                return false;
            }
        }
        
    }

    public function getTopDeaths() {
        if($this->tableExists('cases')){
            $this->db->query(" SELECT * FROM cases ORDER BY date DESC, deaths Desc LIMIT 10");

            if($row = $this->db->resultSet())  {
                return $row;
            } else {
                return false;
            }
        }
        
    }

    public function getTopRecovered() {
        if($this->tableExists('cases')){
            $this->db->query(" SELECT * FROM cases ORDER BY date DESC, recovered Desc LIMIT 10");

            if($row = $this->db->resultSet())  {
                return $row;
            } else {
                return false;
            }
        }
        
    }

    public function getTables(){
        $this->db->query("SHOW TABLES");

        if($row = $this->db->resultSet()) {
            return $row;
        } else {
            return false;
        }
    }

    public function tableExists($table){
        $this->db->query("SHOW TABLES WHERE Tables_in_covidtracker = '{$table}'");

        $this->db->execute();

        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getRowCount($table) {
        $this->db->query("SELECT * FROM $table");

        if($this->db->execute()){
            return $rows = $this->db->rowCount();
        } else {
            return false;
        }
    }

    public function getLastEntry($id) {
        if($this->tableExists('cases')){
            $this->db->query("SELECT * FROM cases WHERE country_id = {$id} ORDER BY date DESC LIMIT 1");

            if($this->db->execute()) {
                return $row = $this->db->single();
            } else {
                return false;
            }
        }
        
    }

    public function getFirstEntry($id) {
        if($this->tableExists('cases')){
            $this->db->query("SELECT * FROM cases WHERE country_id = {$id} ORDER BY date ASC LIMIT 1");

            if($this->db->execute()) {
                return $row = $this->db->single();
            } else {
                return false;
            }
        }
        
    }

    public function getLastGlobalEntry() {
        if($this->tableExists('global')){
            $sql = $this->db->query("SELECT * FROM global ORDER BY date DESC LIMIT 1");

            if($this->db->execute()) {
                return $rpw = $this->db->single();
            } else {
                return false;
            }
        }
        
        
    }

    public function getSumOFCases($date) {
        if($this->tableExists('cases')){
            $this->db->query("SELECT SUM(active) AS active, SUM(recovered) AS recovered, SUM(new_recovered) as new_recovered, SUM(deaths) AS deaths, SUM(new_deaths) as new_deaths, SUM(confirmed) AS confirmed, SUM(new_confirmed) as new_confirmed, date FROM `cases` WHERE date = '$date' ");

            if($row = $this->db->single()){
                return $row;
            } else {
                return false;
            }
        }
        
    }

    public function createTable($query) {
        $this->db->query($query);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function deleteTable($query) {
        $this->db->query($query);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function insertCountry($data) {
        $this->db->query("INSERT INTO countries (name, slug, status) VALUES (:name, :slug, :status)");

        $this->db->bind(":name", $data['country']);
        $this->db->bind(":slug", $data['slug']);
        $this->db->bind(":status", $data['status']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function insertCases($data) {
        $this->db->query("INSERT INTO cases (country_id, name, active, deaths, new_deaths, recovered, new_recovered,  confirmed, new_confirmed, date) VALUES (:country_id, :name,  :active, :deaths, :new_deaths , :recovered, :new_recovered,  :confirmed, :new_confirmed, :date)");

        $this->db->bind(":country_id", $data['country_id']);
        $this->db->bind(":name", $data['name']);
        $this->db->bind(":active", $data['active']);
        $this->db->bind(":deaths", $data['deaths']);
        $this->db->bind(":new_deaths", $data['newDeaths']);
        $this->db->bind(":recovered", $data['recovered']);
        $this->db->bind(":new_recovered", $data['newRecovered']);
        $this->db->bind(":confirmed", $data['confirmed']);
        $this->db->bind(":new_confirmed", $data['newConfirmed']);
        $this->db->bind(":date", $data['date']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function insertGlobal($data) {
        $this->db->query("INSERT INTO global (name, active, deaths, new_deaths, recovered, new_recovered, confirmed, new_confirmed, date) VALUES (:name, :active, :deaths, :new_deaths, :recovered, :new_recovered, :confirmed, :new_confirmed, :date)");

        $this->db->bind(":name" , $data['name']);
        $this->db->bind(":active" , $data['active']);
        $this->db->bind(":deaths" , $data['deaths']);
        $this->db->bind(":new_deaths" , $data['newDeaths']);
        $this->db->bind(":recovered" , $data['recovered']);
        $this->db->bind(":new_recovered" , $data['newRecovered']);
        $this->db->bind(":confirmed" , $data['confirmed']);
        $this->db->bind(":new_confirmed" , $data['newConfirmed']);
        $this->db->bind(":date" , $data['date']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    
}

?>