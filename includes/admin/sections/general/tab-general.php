<?php
/**
 * General Settings template
 */

?>
<div id="tab-activate" class="panel whmc-panel">
    <div class="panel-wrapper">
        <h3>General Settings</h3>
        <form id="whmc-panel" method="post" action="options.php">
            <?php
            settings_fields( 'whmc_general' );
            do_settings_sections( 'whmc_panel_general' );
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
</div>
