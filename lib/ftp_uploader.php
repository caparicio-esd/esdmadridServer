<?php


/**
 * 
 * 
 * Functions to upload static assets
 * to another host per FTP
 * 
 */

function upload_to_ftp($args)
{

    /**
     * Route wrangling
     */
    $upload_dir = wp_upload_dir();
    $base_dir = $upload_dir['basedir']; 
    $date_subdir = substr($upload_dir['subdir'], 1); 
    
    $pic_routes = array(
        str_replace($date_subdir."/", "", $args['file'])
    );
    $pic_sizes = array();
    foreach($args["sizes"] as $size) {
        array_push($pic_sizes, $size['file']);
    }
    $pic_routes = array_merge($pic_routes, $pic_sizes);
    // console_log($pic_routes);

    /**
     * ftp connection
     * 
     */
    /**
     * 
     * 
     * 
     * TODO---- stablish ssh tunnel first to connect.... 
     */
    $connection = ftp_connect('home394109063.1and1-data.host', 22);
    $login = ftp_login($connection, 'u66893151-carlos', 'Uploading12345$!');


    /**
     * 
     * 
     */
    if (!$connection || !$login) {
        die('Connection attempt failed, Check your settings');
    } else {
        foreach($pic_routes as $pic_route) {
            $local_route = "$base_dir/$date_subdir/$pic_route";
            $remote_route = "sftp://home394109063.1and1-data.host/esdmadrid_2.0/wp-content/uploads/$date_subdir/$pic_route";
            console_log($connection);

            $ftp_stream = ftp_put(
                $connection, 
                $remote_route, 
                $local_route,
                FTP_BINARY
            );
            
            if (!$ftp_stream) {
                console_log("Connexion failed FTP");
            } else {
                console_log("Connexion FTP succeded");
            }
        }
    }


    return $args;
}

// add_filter('wp_generate_attachment_metadata', 'upload_to_ftp');
