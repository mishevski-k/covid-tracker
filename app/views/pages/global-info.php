    <h1>Global cases</h1>
        <p>Date: <?php if(!empty($data['global'])) echo date("F j, Y", strtotime($data['global']['date'])) ?></p>
    <div class="case-type">
        <h1>Confirmed: <span><?php if(!empty($data['global'])) echo number_format_short($data['global']['confirmed']);  else  echo "NO DATA!";  ?></span></h1>
        <h2></h2>
    </div>
    <div class="case-type">
        <h1>Deaths: <span class="clr-danger"><?php if(!empty($data['global'])) echo number_format_short($data['global']['deaths']);  else  echo "NO DATA!";  ?></span></h1>
    </div>
    <div class="case-type">
        <h1>Recovered: <span class="clr-success">
        <?php 
            if(!empty($data['global'])) {
                if($data['global']['recovered'] > 0 ) {
                    echo number_format_short($data['global']['recovered']);
                } else {
                    echo "NO DATA!"; 
                }
            }else {
                echo "NO DATA!";
            }
            ?>
        </span></h1>
    </div>
    <div class="case-type">
        <h1>Active Cases: <span class="clr-info"><?php if(!empty($data['global'])) echo number_format_short($data['global']['active']);  else  echo "NO DATA!";  ?></span></h1>
    </div>
    <div class="filter-container">
        <div class="filter <?php if($data['global']['filter'] === 'total') echo "active" ?> global-total-filter">
            Total
        </div>
        <div class="filter <?php if($data['global']['filter'] === 'daily') echo "active" ?> global-daily-filter">
            Daily
        </div>
        <div class="filter <?php if($data['global']['filter'] === 'month') echo "active" ?> global-month-filter">
            Montly
        </div>
        <div class="filter <?php if($data['global']['filter'] === 'quarter') echo "active" ?> global-quarter-filter">
            90 days
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            let globalCases = function(){
                                            $.ajax({
                                                url: "countries/global",
                                                method: "POST",
                                                data:{
                                                    id: "total"
                                                },
                                                success:function(data){
                                                    $(".global-info").html(data);
                                                }

                                            })
                                        }

        $(".global-daily-filter").click(function(){
            if($(".global-daily-filter").hasClass("active")){
                globalCases();
            } else {
                $.ajax({
                    url: "countries/global",
                    method: "POST",
                    data:{
                        id: "global_daily"
                    },
                    success:function(data){
                        $(".global-info").html(data);
                    }
            
                })
            }

                
        })

        $(".global-total-filter").click(function(){
            if($(".global-total-filter").hasClass("active")){
                globalCases();
            } else {
                $.ajax({
                    url: "countries/global",
                    method: "POST",
                    data:{
                        id: "total"
                    },
                    success:function(data){
                        $(".global-info").html(data);
                    }
        
                })
            }

            
        })

        $(".global-month-filter").click(function(){
            if($(".global-month-filter").hasClass("active")){
                globalCases();
            } else {
                $.ajax({
                    url: "countries/global",
                    method: "POST",
                    data:{
                        id: "month"
                    },
                    success:function(data){
                        $(".global-info").html(data);
                    }
        
                })
            }

            
        })

        $(".global-quarter-filter").click(function(){
            if($(".global-quarter-filter").hasClass("active")){
                globalCases();
            } else {
                $.ajax({
                    url: "countries/global",
                    method: "POST",
                    data:{
                        id: "quarter"
                    },
                    success:function(data){
                        $(".global-info").html(data);
                    }
        
                })
            }

            
        })
    });
    </script>

