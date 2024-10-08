<?php
/**
 * Plugin Name: Tower Manager Plugin 11
 * Description: A plugin to manage tower database with tower_id, name, and bells in the WordPress dashboard.
 * Version: 2.0
 * Author: A
 */


 function tower_manager_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . "towers";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "
    CREATE TABLE $table_name (
        tower_id mediumint(9) NOT NULL AUTO_INCREMENT,
        ID mediumint(9) NOT NULL,
        Town tinytext NOT NULL,
        Dedication text,
        District text,
        Photograph varchar(255),
        Practice_night varchar(255),
        Practice_night_italics varchar(255),
        Service_ringing varchar(255),
        Service_ringing_italics varchar(255),
        Ringing_master text,
        Display_ringing_master varchar(255),
        Tower_captain text,
        Display_tower_captain varchar(255),
        Secretary text,
        Display_secretary varchar(255),
        Secretary_address_line_1 text,
        Secretary_address_line_2 text,
        Secretary_address_line_3 text,
        Secretary_address_line_4 text,
        Display_secretary_address text,
        Secretary_telephone varchar(255),
        Display_secretary_telephone varchar(255),
        Secretary_mobile varchar(255),
        Display_secretary_mobile varchar(255),
        Display_secretary_email varchar(255),
        Expose_secretary_email boolean,
        Secretary_email text,
        Secretary_comments text,
        OS_reference varchar(255),
        What3WordsDoorLoc varchar(255),
        Number_of_bells int,
        Comment_1 text,
        Comment_1_link varchar(255),
        Comment_1_italics varchar(255),
        Comment_2 text,
        Comment_2_link varchar(255),
        Comment_2_italics varchar(255),
        Bell_comment text,
        Bell_comment_link varchar(255),
        Bell_comment_italics varchar(255),
        Postcode varchar(20),
        Felstead_ID varchar(50),
        RW_Peal_ID varchar(50),
        Bellboard_place text,
        Bellboard_dedication text,
        Bellboard_county text,
        DoveID varchar(255),
        Map_X float,
        Map_Y float,
        Ground_floor boolean,
        Toilet boolean,
        Practice_night_phone_to_confirm boolean,
        Practice_night_comments text,
        Secretary_address_line_5 text,
        Include_dedication boolean,
        Deputy_secretary text,
        Deputy_secretary_telephone varchar(255),
        Deputy_secretary_email text,
        Deputy_secretary_comments text,
        Ringing_master_telephone varchar(255),
        PRIMARY KEY  (tower_id)
    ) $charset_collate;

        tower_id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        bells int NOT NULL,
        image_id varchar(255) DEFAULT '' NOT NULL,
        PRIMARY KEY  (tower_id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

register_activation_hook( __FILE__, 'tower_manager_create_table' );

// Add a menu item to the WordPress dashboard
function tower_manager_menu() {
    add_menu_page(
        'Tower Manager',       // Page title
        'Tower Manager',       // Menu title
        'manage_options',      // Capability
        'tower-manager',       // Menu slug
        'tower_manager_page',  // Function to display the page content
        'dashicons-admin-site',// Icon
        20                     // Position
    );
}
add_action('admin_menu', 'tower_manager_menu');

// Display the plugin admin page
function tower_manager_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'towers';

    // Check if a CSV file is uploaded
    if (isset($_FILES['tower_csv']) && $_FILES['tower_csv']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['tower_csv']['tmp_name'];

        // Clear the existing towers in the database before importing new data
        $wpdb->query("TRUNCATE TABLE $table_name");

        
    // Open the file and read its content
    if (($handle = fopen($file, 'r')) !== false) {
        // Skip the header row
        fgetcsv($handle);

        // Loop through the file and insert each row into the database
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $wpdb->insert(
                $table_name,
                array(
                    'ID' => $data[0],
                    'Town' => $data[1],
                    'Dedication' => $data[2],
                    'District' => $data[3],
                    'Photograph' => $data[4],
                    'Practice_night' => $data[5],
                    'Practice_night_italics' => $data[6],
                    'Service_ringing' => $data[7],
                    'Service_ringing_italics' => $data[8],
                    'Ringing_master' => $data[9],
                    'Display_ringing_master' => $data[10],
                    'Tower_captain' => $data[11],
                    'Display_tower_captain' => $data[12],
                    'Secretary' => $data[13],
                    'Display_secretary' => $data[14],
                    'Secretary_address_line_1' => $data[15],
                    'Secretary_address_line_2' => $data[16],
                    'Secretary_address_line_3' => $data[17],
                    'Secretary_address_line_4' => $data[18],
                    'Display_secretary_address' => $data[19],
                    'Secretary_telephone' => $data[20],
                    'Display_secretary_telephone' => $data[21],
                    'Secretary_mobile' => $data[22],
                    'Display_secretary_mobile' => $data[23],
                    'Display_secretary_email' => $data[24],
                    'Expose_secretary_email' => $data[25],
                    'Secretary_email' => $data[26],
                    'Secretary_comments' => $data[27],
                    'OS_reference' => $data[28],
                    'What3WordsDoorLoc' => $data[29],
                    'Number_of_bells' => $data[30],
                    'Comment_1' => $data[31],
                    'Comment_1_link' => $data[32],
                    'Comment_1_italics' => $data[33],
                    'Comment_2' => $data[34],
                    'Comment_2_link' => $data[35],
                    'Comment_2_italics' => $data[36],
                    'Bell_comment' => $data[37],
                    'Bell_comment_link' => $data[38],
                    'Bell_comment_italics' => $data[39],
                    'Postcode' => $data[40],
                    'Felstead_ID' => $data[41],
                    'RW_Peal_ID' => $data[42],
                    'Bellboard_place' => $data[43],
                    'Bellboard_dedication' => $data[44],
                    'Bellboard_county' => $data[45],
                    'DoveID' => $data[46],
                    'Map_X' => $data[47],
                    'Map_Y' => $data[48],
                    'Ground_floor' => $data[49],
                    'Toilet' => $data[50],
                    'Practice_night_phone_to_confirm' => $data[51],
                    'Practice_night_comments' => $data[52],
                    'Secretary_address_line_5' => $data[53],
                    'Include_dedication' => $data[54],
                    'Deputy_secretary' => $data[55],
                    'Deputy_secretary_telephone' => $data[56],
                    'Deputy_secretary_email' => $data[57],
                    'Deputy_secretary_comments' => $data[58],
                    'Ringing_master_telephone' => $data[59]
                )
            );
        }
        fclose($handle);
    }

    if (($handle = fopen($file, 'r')) !== false) {
        // Skip the header row
        fgetcsv($handle);
    
        // Loop through the file and insert each row into the database
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            // Sanitize and assign each CSV column to a variable
            $ID = intval($data[0]);
            $Town = sanitize_text_field($data[1]);
            $Dedication = sanitize_text_field($data[2]);
            $District = sanitize_text_field($data[3]);
            $Photograph = sanitize_text_field($data[4]);
            $Practice_night = sanitize_text_field($data[5]);
            $Practice_night_italics = sanitize_text_field($data[6]);
            $Service_ringing = sanitize_text_field($data[7]);
            $Service_ringing_italics = sanitize_text_field($data[8]);
            $Ringing_master = sanitize_text_field($data[9]);
            $Display_ringing_master = sanitize_text_field($data[10]);
            $Tower_captain = sanitize_text_field($data[11]);
            $Display_tower_captain = sanitize_text_field($data[12]);
            $Secretary = sanitize_text_field($data[13]);
            $Display_secretary = sanitize_text_field($data[14]);
            $Secretary_address_line_1 = sanitize_text_field($data[15]);
            $Secretary_address_line_2 = sanitize_text_field($data[16]);
            $Secretary_address_line_3 = sanitize_text_field($data[17]);
            $Secretary_address_line_4 = sanitize_text_field($data[18]);
            $Display_secretary_address = sanitize_text_field($data[19]);
            $Secretary_telephone = sanitize_text_field($data[20]);
            $Display_secretary_telephone = sanitize_text_field($data[21]);
            $Secretary_mobile = sanitize_text_field($data[22]);
            $Display_secretary_mobile = sanitize_text_field($data[23]);
            $Display_secretary_email = sanitize_email($data[24]);
            $Expose_secretary_email = boolval($data[25]);
            $Secretary_email = sanitize_email($data[26]);
            $Secretary_comments = sanitize_textarea_field($data[27]);
            $OS_reference = sanitize_text_field($data[28]);
            $What3WordsDoorLoc = sanitize_text_field($data[29]);
            $Number_of_bells = intval($data[30]);
            $Comment_1 = sanitize_textarea_field($data[31]);
            $Comment_1_link = esc_url_raw($data[32]);
            $Comment_1_italics = sanitize_text_field($data[33]);
            $Comment_2 = sanitize_textarea_field($data[34]);
            $Comment_2_link = esc_url_raw($data[35]);
            $Comment_2_italics = sanitize_text_field($data[36]);
            $Bell_comment = sanitize_textarea_field($data[37]);
            $Bell_comment_link = esc_url_raw($data[38]);
            $Bell_comment_italics = sanitize_text_field($data[39]);
            $Postcode = sanitize_text_field($data[40]);
            $Felstead_ID = sanitize_text_field($data[41]);
            $RW_Peal_ID = sanitize_text_field($data[42]);
            $Bellboard_place = sanitize_text_field($data[43]);
            $Bellboard_dedication = sanitize_text_field($data[44]);
            $Bellboard_county = sanitize_text_field($data[45]);
            $DoveID = sanitize_text_field($data[46]);
            $Map_X = floatval($data[47]);
            $Map_Y = floatval($data[48]);
            $Ground_floor = boolval($data[49]);
            $Toilet = boolval($data[50]);
            $Practice_night_phone_to_confirm = boolval($data[51]);
            $Practice_night_comments = sanitize_textarea_field($data[52]);
            $Secretary_address_line_5 = sanitize_text_field($data[53]);
            $Include_dedication = boolval($data[54]);
            $Deputy_secretary = sanitize_text_field($data[55]);
            $Deputy_secretary_telephone = sanitize_text_field($data[56]);
            $Deputy_secretary_email = sanitize_email($data[57]);
            $Deputy_secretary_comments = sanitize_textarea_field($data[58]);
            $Ringing_master_telephone = sanitize_text_field($data[59]);
    
            // Insert the data into the database
            $wpdb->insert($table_name, [
                'ID' => $ID,
                'Town' => $Town,
                'Dedication' => $Dedication,
                'District' => $District,
                'Photograph' => $Photograph,
                'Practice_night' => $Practice_night,
                'Practice_night_italics' => $Practice_night_italics,
                'Service_ringing' => $Service_ringing,
                'Service_ringing_italics' => $Service_ringing_italics,
                'Ringing_master' => $Ringing_master,
                'Display_ringing_master' => $Display_ringing_master,
                'Tower_captain' => $Tower_captain,
                'Display_tower_captain' => $Display_tower_captain,
                'Secretary' => $Secretary,
                'Display_secretary' => $Display_secretary,
                'Secretary_address_line_1' => $Secretary_address_line_1,
                'Secretary_address_line_2' => $Secretary_address_line_2,
                'Secretary_address_line_3' => $Secretary_address_line_3,
                'Secretary_address_line_4' => $Secretary_address_line_4,
                'Display_secretary_address' => $Display_secretary_address,
                'Secretary_telephone' => $Secretary_telephone,
                'Display_secretary_telephone' => $Display_secretary_telephone,
                'Secretary_mobile' => $Secretary_mobile,
                'Display_secretary_mobile' => $Display_secretary_mobile,
                'Display_secretary_email' => $Display_secretary_email,
                'Expose_secretary_email' => $Expose_secretary_email,
                'Secretary_email' => $Secretary_email,
                'Secretary_comments' => $Secretary_comments,
                'OS_reference' => $OS_reference,
                'What3WordsDoorLoc' => $What3WordsDoorLoc,
                'Number_of_bells' => $Number_of_bells,
                'Comment_1' => $Comment_1,
                'Comment_1_link' => $Comment_1_link,
                'Comment_1_italics' => $Comment_1_italics,
                'Comment_2' => $Comment_2,
                'Comment_2_link' => $Comment_2_link,
                'Comment_2_italics' => $Comment_2_italics,
                'Bell_comment' => $Bell_comment,
                'Bell_comment_link' => $Bell_comment_link,
                'Bell_comment_italics' => $Bell_comment_italics,
                'Postcode' => $Postcode,
                'Felstead_ID' => $Felstead_ID,
                'RW_Peal_ID' => $RW_Peal_ID,
                'Bellboard_place' => $Bellboard_place,
                'Bellboard_dedication' => $Bellboard_dedication,
                'Bellboard_county' => $Bellboard_county,
                'DoveID' => $DoveID,
                'Map_X' => $Map_X,
                'Map_Y' => $Map_Y,
                'Ground_floor' => $Ground_floor,
                'Toilet' => $Toilet,
                'Practice_night_phone_to_confirm' => $Practice_night_phone_to_confirm,
                'Practice_night_comments' => $Practice_night_comments,
                'Secretary_address_line_5' => $Secretary_address_line_5,
                'Include_dedication' => $Include_dedication,
                'Deputy_secretary' => $Deputy_secretary,
                'Deputy_secretary_telephone' => $Deputy_secretary_telephone,
                'Deputy_secretary_email' => $Deputy_secretary_email,
                'Deputy_secretary_comments' => $Deputy_secretary_comments,
                'Ringing_master_telephone' => $Ringing_master_telephone
            ]);
        }
    
        fclose($handle);
        echo '<div class="updated"><p>CSV Imported successfully!</p></div>';
    } else {
        echo '<div class="error"><p>Error opening the file.</p></div>';
    
        }
    }

    // Fetch existing towers from the database
    $towers = $wpdb->get_results("SELECT * FROM $table_name");

    // HTML form for uploading CSV
    ?>
    <div class="wrap">
        <h1>Tower Manager</h1>
        <h2>Upload CSV</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="tower_csv" accept=".csv">
            <p class="submit">
                <input type="submit" class="button-primary" value="Upload CSV">
            </p>
        </form>

        <h2>Existing Towers</h2>
        <style>
    /* Add styling for table rows */
    .widefat tbody tr:nth-child(odd) {
        background-color: #f9f9f9; /* Light grey for odd rows */
    }
    .widefat tbody tr:nth-child(even) {
        background-color: #ffffff; /* White for even rows */
    }
</style>
        <table class="widefat fixed" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Town</th>
            <th>Dedication</th>
            <th>District</th>
            <th>Number of Bells</th>
            <th>Ringing Master</th>
            <th>Tower Captain</th>
            <th>Secretary</th>
            <th>Image URL</th> <!-- Keep this column -->
        </tr>
    </thead>
    <tbody>
    <?php if ($towers): ?>
        <?php foreach ($towers as $tower): ?>
            <tr>
                <td><?php echo esc_html($tower->ID); ?></td>
                <td><?php echo esc_html($tower->Town); ?></td>
                <td><?php echo esc_html($tower->Dedication); ?></td>
                <td><?php echo esc_html($tower->District); ?></td>
                <td><?php echo esc_html($tower->Number_of_bells); ?></td>
                <td><?php echo esc_html($tower->Ringing_master); ?></td>
                <td><?php echo esc_html($tower->Tower_captain); ?></td>
                <td><?php echo esc_html($tower->Secretary); ?></td>
                <td>
                    <?php
                    // Constructing the image URL based on the image_id field
                    $image_url = esc_url( wp_upload_dir()['baseurl'] . '/tower/' . $tower->Photograph );
                    echo '<a href="' . $image_url . '">' . $image_url . '</a>';
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="9">No towers found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>


    </div>
    <?php
}



// Ensure database table exists on plugin upgrade
function tower_manager_update_db_check() {
    tower_manager_create_table();
}
add_action('plugins_loaded', 'tower_manager_update_db_check');
