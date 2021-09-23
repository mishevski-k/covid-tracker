<?php require APPROOT . "/views/includes/head.php"; ?>
<div class="container">
    <?php require APPROOT . "/views/includes/nav.php"; ?>
    <div class="main-container">
        <?php require APPROOT . "/views/pages/worldwide-banner.php" ?>
        <?php require APPROOT . "/views/pages/info-display.php" ?>
        <div class="cases">
            <div class="table-container">
                <h1>Countries <i class="gg-arrow-up-o" id="toggle-table-confirmed"></i></h1>
                <table cellspacing="0" id="table-confirmed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Country</th>
                            <th>Total Cases</th>
                            <th>New Cases</th>
                            <th>Total Deaths</th>
                            <th>New Deaths</th>
                            <th>Total Recovered</th>
                            <th>New Recovered</th>
                            <th>Active Cases</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if(!empty($data['global'])) { ?>
                            <tr id="global">
                                <td><a href="<?php echo URLROOT ?>/countries/statistic/global">0</a></td>
                                <td>Global</td>
                                <td><?php echo number_format($data['global']['confirmed']) ?></td>
                                <td class="<?php if($data['global']['new_confirmed'] > 0) echo "clr=info"  ?>"><?php echo number_format($data['global']['new_confirmed']) ?></td>
                                <td><?php echo number_format($data['global']['deaths']) ?></td>
                                <td class="<?php if($data['global']['new_deaths'] > 0) echo "clr=danger"  ?>"><?php echo number_format($data['global']['new_deaths']) ?></td>
                                <td><?php echo number_format($data['global']['recovered']) ?></td>
                                <td class="<?php if($data['global']['new_recovered'] > 0) echo "clr=success"  ?>"><?php echo number_format($data['global']['new_recovered']) ?></td>
                                <td><?php echo number_format($data['global']['active']) ?></td>
                            </tr>
                        <?php } else { ?>
                            <tr id="global">
                                <td>0</td>
                                <td>Global</td>
                                <td>NO DATA!</td>
                                <td>NO DATA!</td>
                                <td>NO DATA!</td>
                                <td>NO DATA!</td>
                                <td>NO DATA!</td>
                                <td>NO DATA!</td>
                                <td>NO DATA!</td>
                            </tr>
                        <?php } ?>
                        
                        <?php if(!empty($data['countriesCases'])) { $i = 1;  foreach($data['countriesCases'] as $country):?>
                            <tr>
                                <td><a href="<?php echo URLROOT . "/countries/statistic/" . $country->country_id ?>"><?php echo $i ?></a></td>
                                <td><?php echo $country->name ?></td>
                                <td><?php echo number_format($country->confirmed) ?></td>
                                <td class="<?php if($country->new_confirmed > 0) echo "clr-info" ?>"><?php echo number_format($country->new_confirmed) ?></td>
                                <td><?php echo number_format($country->deaths) ?></td>
                                <td class="<?php if($country->new_deaths > 0) echo "clr-danger" ?>"><?php echo number_format($country->new_deaths) ?></td>
                                <td><?php echo number_format($country->recovered) ?></td>
                                <td class="<?php if($country->new_recovered > 0) echo "clr-success" ?>"><?php echo number_format($country->new_recovered) ?></td>
                                <td><?php echo number_format($country->active) ?></td>
                        </tr>
                        <?php $i++; endforeach; } else { ?>
                            <tr>
                            <td>NO DATA!</td>
                            <td>NO DATA!</td>
                            <td>NO DATA!</td>
                            <td>NO DATA!</td>
                            <td>NO DATA!</td>
                            <td>NO DATA!</td>
                            <td>NO DATA!</td>
                            <td>NO DATA!</td>
                            <td>NO DATA!</td>
                        </tr>
                        <?php } ?>                      
                    </tbody>
                </table>
            </div>
    
            
            </div>
        </div>
    </div>
    <?php require APPROOT . "/views/includes/footer.php"; ?>
</div>