    <select name="select-country" id="select-country">
        <?php if(isset($data['country'])): ?>
            <option value="" selected><?php echo $data['country']['name'] ?></option>
        <?php endif; ?>
        <?php foreach($data['countries'] as $country): ?>
            <option value="<?php echo $country->slug ?>" name="country" ><?php echo $country->name ?></option>
        <?php endforeach; ?>
    </select>
    
    
    <h1 id="country">
        <?php if(isset($data['country'])) { 
            echo $data['country']['name'];
        } elseif(isset($data['countries'])) {
            echo $data['countries'][0]->name;
        }
        ?>
    </h1>
    <p>Date: <?php if(isset($data['country'])) echo date("F j, Y", strtotime($data['country']['date'])); ?> </p>
    <div class="case-type">
        <h1>Confirmed: <span> <?php if(isset($data['country'])) echo number_format_short($data['country']['confirmed']) ?> </span></h1>
    </div>
    <div class="case-type">
        <h1>Deaths: <span class="clr-danger"><?php if(isset($data['country'])) echo number_format_short($data['country']['deaths']) ?></span></h1>
    </div>
    <div class="case-type">
        <h1>Recovered: <span class="clr-success"><?php if(isset($data['country'])) echo number_format_short($data['country']['recovered']) ?></span></h1>
    </div>
    <div class="case-type">
        <h1>Active Cases: <span class="clr-info"><?php if(isset($data['country'])) echo number_format_short($data['country']['active']) ?></span></h1>
    </div>
    <div class="filter-container">
        <div class="filter <?php if($data['country']['filter'] === 'total') echo "active" ?> country-total-filter">
            Total
        </div>
        <div class="filter <?php if($data['country']['filter'] === 'daily') echo "active" ?> country-daily-filter">
            Daily
        </div>
        <div class="filter <?php if($data['country']['filter'] === 'month') echo "active" ?> country-month-filter">
            Montly
        </div>
        <div class="filter <?php if($data['country']['filter'] === 'quarter') echo "active" ?> country-quarter-filter">
            90 days
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            let countryCases = function(){

                                        let country = $(".info-by-country #country").text();

                                            $.ajax({
                                                url: "countries/country",
                                                method: "POST",
                                                data:{
                                                    country: country,
                                                    id: "country_total"
                                                },
                                                success:function(data){
                                                    $(".info-by-country").html(data);
                                                }

                                            })
                                        }



        $("#select-country").change(function(){

            let country = $(this).find('option:selected').text();

            $.ajax({
                url: "countries/getCountry",
                method: "POST",
                data:{
                    country: country
                },
                success:function(data){
                    $(".info-by-country").html(data);
                }

            })
        })

        $(".country-daily-filter").click(function(){

            let country = $(".info-by-country #country").text();

            if($(".country-daily-filter").hasClass("active")){
                countryCases();
            } else {
                $.ajax({
                    url: "countries/country",
                    method: "POST",
                    data:{
                        country: country,
                        id: "country_daily"
                    },
                    success:function(data){
                        $(".info-by-country").html(data);
                    }
            
                })
            }

                
        })

        $(".country-total-filter").click(function(){

            let country = $(".info-by-country #country").text();

            if($(".country-total-filter").hasClass("active")){
                countryCases();
            } else {
                $.ajax({
                    url: "countries/country",
                    method: "POST",
                    data:{
                        country: country,
                        id: "country_total"
                    },
                    success:function(data){
                        $(".info-by-country").html(data);
                    }

                })
            }

            
        })

        $(".country-month-filter").click(function(){

            let country = $(".info-by-country #country").text();

            if($(".country-month-filter").hasClass("active")){
                countryCases();
            } else {
                $.ajax({
                    url: "countries/country",
                    method: "POST",
                    data:{
                        country: country,
                        id: "country_month"
                    },
                    success:function(data){
                        $(".info-by-country").html(data);
                    }

                })
            }


        })

        $(".country-quarter-filter").click(function(){

            let country = $(".info-by-country #country").text();

            if($(".country-quarter-filter").hasClass("active")){
                countryCases();
            } else {
                $.ajax({
                    url: "countries/country",
                    method: "POST",
                    data:{
                        country: country,
                        id: "country_quarter"
                    },
                    success:function(data){
                        $(".info-by-country").html(data);
                    }

                })
            }


        })



    });
    </script>