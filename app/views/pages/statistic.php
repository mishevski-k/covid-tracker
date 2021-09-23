<?php require APPROOT . "/views/includes/head.php"; ?>
<div class="container">
    <?php require APPROOT . "/views/includes/nav.php"; ?>
    <div class="main-container">
        <div class="statistic">
                <div class="table-container">
                    <h1>All Data about <?php echo $data['data'][0]->name ?> cases <i class="gg-arrow-up-o" id="toggle-table-confirmed"></i></h1>
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
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['data'] as $entry): ?>
                            <tr>
                                <td><?php echo $entry->id ?></th>
                                <td><?php echo $entry->name ?></th>
                                <td><?php echo number_format($entry->confirmed) ?></th>
                                <td><?php echo number_format($entry->new_confirmed) ?></th>
                                <td><?php echo number_format($entry->deaths) ?></th>
                                <td><?php echo number_format($entry->new_deaths) ?></th>
                                <td><?php echo number_format($entry->recovered) ?></th>
                                <td><?php echo number_format($entry->new_confirmed) ?></th>
                                <td><?php echo number_format($entry->active) ?></td>
                                <td><?php echo $entry->date ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
    <?php require APPROOT . "/views/includes/footer.php"; ?>
</div>