<?php
/**
 * Plugin Name: Tower Manager Plugin 11
 * Description: A plugin to manage tower database with tower_id, name, and bells in the WordPress dashboard.
 * Version: 1.0
 * Author: A
 */


 function tower_manager_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . "towers";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
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
                $name = sanitize_text_field($data[1]);
                $bells = intval($data[2]);
                $image_id = sanitize_text_field($data[3]); // New image_id column

                $wpdb->insert($table_name, [
                    'name' => $name,
                    'bells' => $bells,
                    'image_id' => $image_id // Insert the image_id
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
        <table class="widefat fixed" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Bells</th>
            <th>Image URL</th>  <!-- Add this column -->
        </tr>
    </thead>
    <tbody>
    <?php if ($towers): ?>
        <?php foreach ($towers as $tower): ?>
            <tr>
                <td><?php echo esc_html($tower->tower_id); ?></td>
                <td><?php echo esc_html($tower->name); ?></td>
                <td><?php echo esc_html($tower->bells); ?></td>
                <td>
                    <?php
                    $image_url = esc_url( wp_upload_dir()['baseurl'] . '/2024/10/' . $tower->image_id );
                    echo '<a href="' . $image_url . '">' . $image_url . '</a>';
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No towers found.</td>
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

function tower_manager_display_towers() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'towers';

    // Fetch all towers from the database
    $towers = $wpdb->get_results("SELECT * FROM $table_name");

    // If no towers found, return a message
    if (empty($towers)) {
        return "<p>No towers found.</p>";
    }

    // Start output buffering to capture HTML output
    ob_start();

    // Inject the CSS directly
    ?>
    <style>
    .tower-cards-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: flex-start;
    }
    .tower-card {
        background-color: #fa0092;
        border: 1px solid #ddd;
        border-radius: 8px;
        width: 100%;
        max-width: 23%; /* Ensure max 4 cards per row */
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        text-align: center; /* Center content */
    }
    .tower-card-header h2 {
        margin: 0;
        font-size: 1.5em;
        color: #333;
        text-align: center;
    }
    .tower-card-body p {
        font-size: 1.2em;
        text-align: center;
        margin-top: 10px;
        color: #555;
    }
    .tower-card img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto; /* Center the image */
        border-radius: 8px;
    }

    /* Ensure responsiveness */
    @media (max-width: 1200px) {
        .tower-card {
            max-width: 31%; /* 3 cards per row on medium screens */
        }
    }
    @media (max-width: 900px) {
        .tower-card {
            max-width: 48%; /* 2 cards per row on smaller screens */
        }
    }
    @media (max-width: 600px) {
        .tower-card {
            max-width: 100%; /* 1 card per row on very small screens */
        }
    }
    </style>
    
    <div class="tower-cards-container">
        <?php foreach ($towers as $tower): ?>
            <div class="tower-card">
                <div class="tower-card-header">
                    <h2><?php echo esc_html($tower->name); ?></h2>
                </div>
                <div class="tower-card-body">
                    <img src="<?php echo esc_url( wp_upload_dir()['baseurl'] . '/2024/10/' . $tower->image_id ); ?>" alt="<?php echo esc_attr($tower->name); ?>">
                    <p>Bells: <?php echo esc_html($tower->bells); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php

    // Get the contents from the output buffer and return it
    return ob_get_clean();
}


// Hook function to display towers to the appropriate shortcode
add_shortcode('tower_manager_display_towers', 'tower_manager_display_towers');

add_shortcode('display_towers', 'tower_manager_display_towers');