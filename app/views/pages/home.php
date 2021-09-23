<?php require APPROOT . "/views/includes/head.php"; ?>
<div class="container">
    <?php require APPROOT . "/views/includes/nav.php"; ?>
    <div class="main-container">
        <?php require APPROOT . "/views/pages/worldwide-banner.php" ?>
        <?php require APPROOT . "/views/pages/info-display.php" ?>
        <div class="covid-banner">
            <h1><a href="https://www.cdc.gov/coronavirus/2019-ncov/prevent-getting-sick/prevention.html">Inform yourself!</a> To stop the spread of covid</h1>
        </div>
        <div class="top-countries-cases">
            <div class="table-container">
                <h1>Top 10 Countries by confirmed cases<i class="gg-arrow-up-o" id="toggle-table-confirmed"></i></h1>
                <table cellspacing="0" id="table-confirmed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Country</th>
                            <th>Total Cases</th>
                            <th>Total Deaths</th>
                            <th>Total Recovered</th>
                            <th>Active Cases</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if(!empty($data['global'])) { ?>
                            <tr id="global">
                                <td>0</td>
                                <td>Global</td>
                                <td><?php echo number_format($data['global']['confirmed']) ?></td>
                                <td><?php echo number_format($data['global']['deaths']) ?></td>
                                <td><?php echo number_format($data['global']['recovered']) ?></td>
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
                            </tr>
                        <?php } ?>
                        
                        <?php if(!empty($data['topConfirmed'])) { $i = 1; foreach($data['topConfirmed'] as $case): ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $case->name ?></td>
                                <td><?php echo number_format($case->confirmed) ?></td>
                                <td><?php echo number_format($case->deaths) ?></td>
                                <td><?php echo number_format($case->recovered) ?></td>
                                <td><?php echo number_format($case->active) ?></td>
                            </tr>
                        <?php $i++; endforeach; } else{ ?>
                            <tr>
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
            <div class="table-container">
                <h1>Top 10 Countries by deaths<i class="gg-arrow-down-o" id="toggle-table-deaths"></i></h1>
                <table cellspacing="0" id="table-deaths">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Country</th>
                            <th>Total Cases</th>
                            <th>Total Deaths</th>
                            <th>Total Recovered</th>
                            <th>Active Cases</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if(!empty($data['global'])) { ?>
                            <tr id="global">
                                <td>0</td>
                                <td>Global</td>
                                <td><?php echo number_format($data['global']['confirmed']) ?></td>
                                <td><?php echo number_format($data['global']['deaths']) ?></td>
                                <td><?php echo number_format($data['global']['recovered']) ?></td>
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
                            </tr>
                        <?php } ?>
                        
                        <?php if(!empty($data['topDeaths'])) { $i = 1;  foreach($data['topDeaths'] as $case): ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $case->name ?></td>
                                <td><?php echo number_format($case->confirmed) ?></td>
                                <td><?php echo number_format($case->deaths) ?></td>
                                <td><?php echo number_format($case->recovered) ?></td>
                                <td><?php echo number_format($case->active) ?></td>
                            </tr>
                        <?php $i++; endforeach; } else{ ?>
                            <tr>
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
            <div class="table-container">
                <h1>Top 10 Countries by recovered<i class="gg-arrow-down-o" id="toggle-table-recovered"></i></h1>
                <table cellspacing="0" id="table-recovered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Country</th>
                            <th>Total Cases</th>
                            <th>Total Deaths</th>
                            <th>Total Recovered</th>
                            <th>Active Cases</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php if(!empty($data['global'])) { ?>
                            <tr id="global">
                                <td>0</td>
                                <td>Global</td>
                                <td><?php echo number_format($data['global']['confirmed']) ?></td>
                                <td><?php echo number_format($data['global']['deaths']) ?></td>
                                <td><?php echo number_format($data['global']['recovered']) ?></td>
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
                            </tr>
                        <?php } ?>

                        <?php if(!empty($data['topRecovered'])) { $i = 1; foreach($data['topRecovered'] as $case): ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $case->name ?></td>
                                <td><?php echo number_format($case->confirmed) ?></td>
                                <td><?php echo number_format($case->deaths) ?></td>
                                <td><?php echo number_format($case->recovered) ?></td>
                                <td><?php echo number_format($case->active) ?></td>
                            </tr>
                        <?php $i++; endforeach; } else{ ?>
                            <tr>
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
        <div class="more-info">
            <h1>A detailed documentaion about every country can be found <a href="<?php echo URLROOT ?>/countries/index">here!</a></h1>
        </div>
    </div>
    <?php require APPROOT . "/views/includes/footer.php"; ?>
</div>