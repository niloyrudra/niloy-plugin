<div class="wrap">
    <h1>Custom Fields Manager</h1>
    <?php settings_errors() ?>

    <form action="options.php" method="post">

        <?php
        
            settings_fields( 'niloy_plugin_cf_settings' );
            do_settings_sections( 'niloy_custom_fields' );
            submit_button();

        ?>

    </form>


<!-- <?php
	// if($_POST) {
		// if(isset($_POST['state'])) {
			// if($_POST['state'] == 'NULL') {
				// echo '<p>Please select an option from the select box.</p>';
			// }
			// else {
				// echo '<p>You have selected: <strong>', $_POST['state'], '</strong>.</p>';
			// }
		// }
	// }
// ?>
<form action="options.php" method="post">
	<fieldset>
		<legend>Please select a state</legend>
		<select name="state">
			<option value="NULL">-- Please select a state --</option>
			<option value="AK">AK - Alaska</option>
			<option value="AL">AL - Alabama</option>
			<option value="WY">WY - Wyoming</option>
		</select>

	</fieldset>
</form> -->

</div>