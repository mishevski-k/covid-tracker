<div class="worldwide-banner">
    <h1>COVID-<span>19</span> PANDEMIC TRACKER</h1>
    <p>Last Updated: <?php if(!empty($data['global'])) echo date("D M j G:i:s T Y", strtotime($data['global']['date'])) ?></p>
    <h2>Worldwide<i class="gg-globe-alt"></i> covid cases! <i class="gg-arrow-up-o" id="toggle-info"></i></h2>
    <div class="cases-info">
        <div class="case-type">
            <h1>Confirmed:</h1>
            <?php if(!empty($data['global']) && $data['global']['confirmed'] > 0) { ?>
                <h2><?php echo number_format_short($data['global']['confirmed']) ?></h2>
            <?php } else { ?>
                <h1>NO DATA!</h1>
            <?php } ?>
        </div>
        <div class="case-type">
            <h1>Deaths:</h1>
            <?php if(!empty($data['global']) && $data['global']['deaths'] > 0) { ?>
                <h2><?php echo number_format_short($data['global']['deaths']) ?></h2>
            <?php }else{ ?>
                <h1>NO DATA!</h1>
            <?php } ?>
        </div>
        <div class="case-type">
            <h1>Recovered:</h1>
            <?php if(!empty($data['global']) && $data['global']['recovered'] > 0) { ?>
                <h2><?php echo number_format_short($data['global']['recovered']) ?></h2>
            <?php }else{ ?>
                <h1>NO DATA!</h1>
            <?php } ?>
        </div>
    </div>
</div>