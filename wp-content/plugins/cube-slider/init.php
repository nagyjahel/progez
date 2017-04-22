<?php
/*
Plugin Name: Cube Slider
Plugin URI: http://diseñowebmadrid.com/cube-slider/
Description: Responsive and customizable 3D Wordpress slider for your site.
Version: 1.1
Author: Webpsilon S.C.P.
Author URI: http://webpsilon.com/

Copyright 2015  Webpsilon S.C.P.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
*/



function style_cube() {
    wp_enqueue_style( 'percent-style', plugin_dir_url( __FILE__ ).'css/style.css');
}add_action('wp_enqueue_scripts', 'style_cube', 1);


function cube_stats_add_header(){
    wp_enqueue_script('jquery');
    wp_enqueue_style('extendpro-font-awesome', plugin_dir_url( __FILE__ ).'assets/font-awesome/css/font-awesome.min.css');
    wp_enqueue_script('extendpro-cubescript', plugin_dir_url( __FILE__ ).'js/cube_slider.js');

    wp_enqueue_script('eventhelper-cubescript', plugin_dir_url( __FILE__ ).'js/EventHelpers.js');
    wp_enqueue_script('cssquery-cubescript', plugin_dir_url( __FILE__ ).'js/cssQuery-p.js');
    wp_enqueue_script('sylvester-cubescript', plugin_dir_url( __FILE__ ).'js/sylvester.js');
    wp_enqueue_script('csssandpaper-cubescript', plugin_dir_url( __FILE__ ).'js/cssSandpaper.js');
}add_action('wp_enqueue_scripts', 'cube_stats_add_header', 2);

add_action('admin_enqueue_scripts', 'wp_enqueue_color_picker');
function wp_enqueue_color_picker(){
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker-script', plugins_url('script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}



function cubeslider_animation( $atts ) {
    global $wpdb;
    $table_name = $wpdb->prefix . "cubesliderconfig";
    $re = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY idslider DESC" ); // If user don't add an id, it's going to select the last one.

    extract( shortcode_atts( array(
        'id' => '',
    ), $atts, 'multilink' ) );  
    

    if ($id != '')
    $re = $wpdb->get_results( "SELECT * FROM $table_name WHERE idslider=$id" ); // We select the register selected by the user

    $name = $re[0]->name;
    $about = $re[0]->about;
    $title1 = $re[0]->title1;
    $title2 = $re[0]->title2;
    $title3= $re[0]->title3;
    $title4= $re[0]->title4;
    $description1= $re[0]->description1;
    $description2= $re[0]->description2;
    $description3= $re[0]->description3;
    $description4= $re[0]->description4;
    $icon1= $re[0]->icon1;
    $icon2= $re[0]->icon2;
    $icon3= $re[0]->icon3;
    $icon4= $re[0]->icon4;
    $color1= $re[0]->color1;
    $color2= $re[0]->color2;
    $color3= $re[0]->color3;
    $color4= $re[0]->color4;


    // Comment form styling
    $content='

    <div id="wrapper" class="clearfix">
        <div class="slider-outer">
            <div class="slider-inner">
                <div data-slide="1" class="slide front active">
                    <div class="slide-title" style="margin:10px !important;">'.$title1.'<i class="fa '.$icon1.'" style="color: '.$color1.' !important"></i></div>
                    <div class="slide-description" style="margin:10px !important;">'.$description1.'</div>
                </div>
                <div data-slide="2" class="slide top">
                    <div class="slide-title" style="margin:10px !important;">'.$title2.'<i class="fa '.$icon2.'" style="color: '.$color2.' !important"></i></div>
                    <div class="slide-description" style="margin:10px !important;">'.$description2.'</div>
                </div>
                <div data-slide="3" class="slide back">
                    <div class="slide-title" style="margin:10px !important;">'.$title3.'<i class="fa '.$icon3.'" style="color: '.$color3.' !important"></i></div>
                    <div class="slide-description" style="margin:10px !important;">'.$description3.'</div>
                </div>
                <div data-slide="4" class="slide bottom">
                    <div class="slide-title" style="margin:10px !important;">'.$title4.'<i class="fa '.$icon4.'" style="color: '.$color4.' !important"></i></div>
                    <div class="slide-description" style="margin:10px !important;">'.$description4.'</div>        
                </div>
            </div>
        </div>

        <div class="cent_nav">
        <nav id="nav" class="clearfix">
            <ul class="clearfix">
                <li style="background: none !important;"><a href="href" data-slide="1" class="btn focus" style="color: '.$color1.' !important; border-color: '.$color1.' !important">1</a></li>
                <li style="background: none !important;"><a href="href" data-slide="2" class="btn" style="color: '.$color2.' !important; border-color: '.$color2.' !important">2</a></li>
                <li style="background: none !important;"><a href="href" data-slide="3" class="btn" style="color: '.$color3.' !important; border-color: '.$color3.' !important">3</a></li>
                <li style="background: none !important;"><a href="href" data-slide="4" class="btn" style="color: '.$color4.' !important; border-color: '.$color4.' !important">4</a></li>
            </ul>
        </nav>
        </div>
    </div>

    ';
    return $content;
    
}add_shortcode( 'cubeslider', 'cubeslider_animation' );



// Admin menu creation
add_action('admin_menu', 'cubeslider_menu');
function cubeslider_menu() {
    add_options_page('Cube Slider - Admin', 'Cube Slider', 'manage_options', 'cubeslider', 'settings_cubeslider');
}



function cube_db_function_files(){
    // Table creation
    global $wpdb;
    $table_name2 = $wpdb->prefix . "cubesliderconfig";
    $re_files = $wpdb->query("select * from $table_name2");
    
    // Files table
        if(empty($re_files)) {
            $sql = "CREATE TABLE $table_name2(
            idslider mediumint( 9 ) NOT NULL AUTO_INCREMENT ,

            name longtext NOT NULL ,
            about longtext NOT NULL,
            title1 longtext NOT NULL ,
            title2 longtext NOT NULL ,
            title3 longtext NOT NULL ,
            title4 longtext NOT NULL ,
            description1 longtext NOT NULL ,
            description2 longtext NOT NULL ,
            description3 longtext NOT NULL ,
            description4 longtext NOT NULL ,
            icon1 longtext NOT NULL ,
            icon2 longtext NOT NULL ,
            icon3 longtext NOT NULL ,
            icon4 longtext NOT NULL ,
            color1 longtext NOT NULL ,
            color2 longtext NOT NULL ,
            color3 longtext NOT NULL ,
            color4 longtext NOT NULL ,


            PRIMARY KEY (idslider)

            );";
            
            
            $wpdb->query($sql);

            // $sql = "INSERT INTO $table_name2 (name, about, title1, title2, title3, title4, description1, description2, description3, description4) VALUES('Name', 'About', 'Title 1', 'Title 2', 'Title 3', 'Title 4', 'Description 1', 'Description 2', 'Description 3', 'Description 4');";
            // $wpdb->query($sql);
        }

    $re_files = $wpdb->query("select * from $table_name2");
    return $re_files;
}





// Settings for the admin menu
function settings_cubeslider(){
    global $wpdb;
    $re_files=cube_db_function_files(); // Files database
    $table_name2 = $wpdb->prefix . "cubesliderconfig";

    if (isset($_REQUEST["new"])){
        $sql = "INSERT INTO $table_name2 (name, about, title1, title2, title3, title4, description1, description2, description3, description4, icon1, icon2, icon3, icon4, color1, color2, color3, color4) VALUES('Name', 'About', 'Title 1', 'Title 2', 'Title 3', 'Title 4', 'Description 1', 'Description 2', 'Description 3', 'Description 4', 'fa-', 'fa-', 'fa-', 'fa-', '#81d742', '#81d742', '#81d742', '#81d742');";
        $wpdb -> query($sql);
    }

    $content='
    <div class="wrap">
    ';
    echo "<h1>Cube Slider Admin page</h1>";
    echo "Customize here the social media accounts that you want to add on the Cube Slider plugin.<br /><br />";
    echo '<form method="post"><input type="submit" name="new" id="new" class="button button-primary" value="New Cube Slider"  /></form>';
    

    if(isset($_POST['submit'])){
        $sql = "UPDATE $table_name2 SET name='".$_POST['name']."', about='".$_POST['about']."', title1='".$_POST['title1']."', title2='".$_POST['title2']."', title3='".$_POST['title3']."', title4='".$_POST['title4']."', description1='".$_POST['description1']."', description2='".$_POST['description2']."', description3='".$_POST['description3']."', description4='".$_POST['description4']."', icon1='".$_POST['icon1']."', icon2='".$_POST['icon2']."', icon3='".$_POST['icon3']."', icon4='".$_POST['icon4']."', color1='".$_POST['color1']."', color2='".$_POST['color2']."', color3='".$_POST['color3']."', color4='".$_POST['color4']."' WHERE idslider=".$_POST['idslider']."";
        $re = $wpdb->query($sql);
    }

    if(isset($_POST['new'])){
        $re = $wpdb->get_results( "SELECT * FROM $table_name2 ORDER BY idslider DESC" );
    }
    if(isset($_POST['edit'])){
        $re = $wpdb->get_results( "SELECT * FROM $table_name2 WHERE idslider=".$_POST['idslider']."");
    }
    if(isset($_POST['delete'])){
        $sql = "DELETE FROM $table_name2 WHERE idslider=".$_POST['idslider']."";
        $re = $wpdb->query($sql);
    }
    
    if(isset($_POST['new']) || isset($_POST['edit'])){
    echo "<h2>Titles</h2>";

    ?>


    <!-- Titles -->
    <form method="post">
        <input type="hidden" value="<?php echo $re[0]->idslider; ?>" id="idslider" name="idslider">

        <label for="name">
            Name for your <strong>Cube Slider</strong>:<br />
        </label>
        <input type="text" name="name" id="name" value="<?php echo $re[0]->name; ?>" />
        <br />
        <label for="about">
            Please, add a description to identify your slider in the future.<br />
        </label>
        <input type="text" name="about" id="about" value="<?php echo $re[0]->about; ?>" />
        <br />
        <br /><br />


    <?php echo "<h2>Titles and contents to show</h2>";?>

        <label for="title1">
            What do you want in <strong>Title 1</strong>?<br />
        </label>
        <input type="text" name="title1" id="title1" value="<?php echo $re[0]->title1; ?>" />
        <br />
        <label for="description1">
            What's going to be their <strong>DESCRIPTION</strong>?<br />
        </label>
        <input type="text" name="description1" id="description1" value="<?php echo $re[0]->description1; ?>" />
        <br /><br />

        <label for="title2">
            What do you want in <strong>Title 2</strong>?<br />
        </label>
        <input type="text" name="title2" id="title2" value="<?php echo $re[0]->title2; ?>" />
        <br />
        <label for="description2">
            What's going to be their <strong>DESCRIPTION</strong>?<br />
        </label>
        <input type="text" name="description2" id="description2" value="<?php echo $re[0]->description2; ?>" />
        <br /><br />

        <label for="title3">
            What do you want in <strong>Title 3</strong>?<br />
        </label>
        <input type="text" name="title3" id="title3" value="<?php echo $re[0]->title3; ?>" />
        <br />
        <label for="description3">
            What's going to be their <strong>DESCRIPTION</strong>?<br />
        </label>
        <input type="text" name="description3" id="description3" value="<?php echo $re[0]->description3; ?>" />
        <br /><br />

        <label for="title4">
            What do you want in <strong>Title 4</strong>?<br />
        </label>
        <input type="text" name="title4" id="title4" value="<?php echo $re[0]->title4; ?>" />
        <br />
        <label for="description4">
            What's going to be their <strong>DESCRIPTION</strong>?<br />
        </label>
        <input type="text" name="description4" id="description4" value="<?php echo $re[0]->description4; ?>" />
        <br />
        <br /><br />


        <!-- Icons -->
        <?php echo "<h2>Icons to show</h2>";?>

        <?php
            $font_awesome_icons = array( 'fa-500px' => '\f26e','fa-adjust' => '\f042','fa-adn' => '\f170','fa-align-center' => '\f037','fa-align-justify' => '\f039','fa-align-left' => '\f036','fa-align-right' => '\f038','fa-amazon' => '\f270','fa-ambulance' => '\f0f9','fa-anchor' => '\f13d','fa-android' => '\f17b','fa-angellist' => '\f209','fa-angle-double-down' => '\f103','fa-angle-double-left' => '\f100','fa-angle-double-right' => '\f101','fa-angle-double-up' => '\f102','fa-angle-down' => '\f107','fa-angle-left' => '\f104','fa-angle-right' => '\f105','fa-angle-up' => '\f106','fa-apple' => '\f179','fa-archive' => '\f187','fa-area-chart' => '\f1fe','fa-arrow-circle-down' => '\f0ab','fa-arrow-circle-left' => '\f0a8','fa-arrow-circle-o-down' => '\f01a','fa-arrow-circle-o-left' => '\f190','fa-arrow-circle-o-right' => '\f18e','fa-arrow-circle-o-up' => '\f01b','fa-arrow-circle-right' => '\f0a9','fa-arrow-circle-up' => '\f0aa','fa-arrow-down' => '\f063','fa-arrow-left' => '\f060','fa-arrow-right' => '\f061','fa-arrow-up' => '\f062','fa-arrows' => '\f047','fa-arrows-alt' => '\f0b2','fa-arrows-h' => '\f07e','fa-arrows-v' => '\f07d','fa-asterisk' => '\f069','fa-at' => '\f1fa','fa-backward' => '\f04a','fa-balance-scale' => '\f24e','fa-ban' => '\f05e','fa-bar-chart' => '\f080','fa-barcode' => '\f02a','fa-bars' => '\f0c9','fa-battery-empty' => '\f244','fa-battery-full' => '\f240','fa-battery-half' => '\f242','fa-battery-quarter' => '\f243','fa-battery-three-quarters' => '\f241','fa-bed' => '\f236','fa-beer' => '\f0fc','fa-behance' => '\f1b4','fa-behance-square' => '\f1b5','fa-bell' => '\f0f3','fa-bell-o' => '\f0a2','fa-bell-slash' => '\f1f6','fa-bell-slash-o' => '\f1f7','fa-bicycle' => '\f206','fa-binoculars' => '\f1e5','fa-birthday-cake' => '\f1fd','fa-bitbucket' => '\f171','fa-bitbucket-square' => '\f172','fa-black-tie' => '\f27e','fa-bold' => '\f032','fa-bolt' => '\f0e7','fa-bomb' => '\f1e2','fa-book' => '\f02d','fa-bookmark' => '\f02e','fa-bookmark-o' => '\f097','fa-briefcase' => '\f0b1','fa-btc' => '\f15a','fa-bug' => '\f188','fa-building' => '\f1ad','fa-building-o' => '\f0f7','fa-bullhorn' => '\f0a1','fa-bullseye' => '\f140','fa-bus' => '\f207','fa-buysellads' => '\f20d','fa-calculator' => '\f1ec','fa-calendar' => '\f073','fa-calendar-check-o' => '\f274','fa-calendar-minus-o' => '\f272','fa-calendar-o' => '\f133','fa-calendar-plus-o' => '\f271','fa-calendar-times-o' => '\f273','fa-camera' => '\f030','fa-camera-retro' => '\f083','fa-car' => '\f1b9','fa-caret-down' => '\f0d7','fa-caret-left' => '\f0d9','fa-caret-right' => '\f0da','fa-caret-square-o-down' => '\f150','fa-caret-square-o-left' => '\f191','fa-caret-square-o-right' => '\f152','fa-caret-square-o-up' => '\f151','fa-caret-up' => '\f0d8','fa-cart-arrow-down' => '\f218','fa-cart-plus' => '\f217','fa-cc' => '\f20a','fa-cc-amex' => '\f1f3','fa-cc-diners-club' => '\f24c','fa-cc-discover' => '\f1f2','fa-cc-jcb' => '\f24b','fa-cc-mastercard' => '\f1f1','fa-cc-paypal' => '\f1f4','fa-cc-stripe' => '\f1f5','fa-cc-visa' => '\f1f0','fa-certificate' => '\f0a3','fa-chain-broken' => '\f127','fa-check' => '\f00c','fa-check-circle' => '\f058','fa-check-circle-o' => '\f05d','fa-check-square' => '\f14a','fa-check-square-o' => '\f046','fa-chevron-circle-down' => '\f13a','fa-chevron-circle-left' => '\f137','fa-chevron-circle-right' => '\f138','fa-chevron-circle-up' => '\f139','fa-chevron-down' => '\f078','fa-chevron-left' => '\f053','fa-chevron-right' => '\f054','fa-chevron-up' => '\f077','fa-child' => '\f1ae','fa-chrome' => '\f268','fa-circle' => '\f111','fa-circle-o' => '\f10c','fa-circle-o-notch' => '\f1ce','fa-circle-thin' => '\f1db','fa-clipboard' => '\f0ea','fa-clock-o' => '\f017','fa-clone' => '\f24d','fa-cloud' => '\f0c2','fa-cloud-download' => '\f0ed','fa-cloud-upload' => '\f0ee','fa-code' => '\f121','fa-code-fork' => '\f126','fa-codepen' => '\f1cb','fa-coffee' => '\f0f4','fa-cog' => '\f013','fa-cogs' => '\f085','fa-columns' => '\f0db','fa-comment' => '\f075','fa-comment-o' => '\f0e5','fa-commenting' => '\f27a','fa-commenting-o' => '\f27b','fa-comments' => '\f086','fa-comments-o' => '\f0e6','fa-compass' => '\f14e','fa-compress' => '\f066','fa-connectdevelop' => '\f20e','fa-contao' => '\f26d','fa-copyright' => '\f1f9','fa-creative-commons' => '\f25e','fa-credit-card' => '\f09d','fa-crop' => '\f125','fa-crosshairs' => '\f05b','fa-css3' => '\f13c','fa-cube' => '\f1b2','fa-cubes' => '\f1b3','fa-cutlery' => '\f0f5','fa-dashcube' => '\f210','fa-database' => '\f1c0','fa-delicious' => '\f1a5','fa-desktop' => '\f108','fa-deviantart' => '\f1bd','fa-diamond' => '\f219','fa-digg' => '\f1a6','fa-dot-circle-o' => '\f192','fa-download' => '\f019','fa-dribbble' => '\f17d','fa-dropbox' => '\f16b','fa-drupal' => '\f1a9','fa-eject' => '\f052','fa-ellipsis-h' => '\f141','fa-ellipsis-v' => '\f142','fa-empire' => '\f1d1','fa-envelope' => '\f0e0','fa-envelope-o' => '\f003','fa-envelope-square' => '\f199','fa-eraser' => '\f12d','fa-eur' => '\f153','fa-exchange' => '\f0ec','fa-exclamation' => '\f12a','fa-exclamation-circle' => '\f06a','fa-exclamation-triangle' => '\f071','fa-expand' => '\f065','fa-expeditedssl' => '\f23e','fa-external-link' => '\f08e','fa-external-link-square' => '\f14c','fa-eye' => '\f06e','fa-eye-slash' => '\f070','fa-eyedropper' => '\f1fb','fa-facebook' => '\f09a','fa-facebook-official' => '\f230','fa-facebook-square' => '\f082','fa-fast-backward' => '\f049','fa-fast-forward' => '\f050','fa-fax' => '\f1ac','fa-female' => '\f182','fa-fighter-jet' => '\f0fb','fa-file' => '\f15b','fa-file-archive-o' => '\f1c6','fa-file-audio-o' => '\f1c7','fa-file-code-o' => '\f1c9','fa-file-excel-o' => '\f1c3','fa-file-image-o' => '\f1c5','fa-file-o' => '\f016','fa-file-pdf-o' => '\f1c1','fa-file-powerpoint-o' => '\f1c4','fa-file-text' => '\f15c','fa-file-text-o' => '\f0f6','fa-file-video-o' => '\f1c8','fa-file-word-o' => '\f1c2','fa-files-o' => '\f0c5','fa-film' => '\f008','fa-filter' => '\f0b0','fa-fire' => '\f06d','fa-fire-extinguisher' => '\f134','fa-firefox' => '\f269','fa-flag' => '\f024','fa-flag-checkered' => '\f11e','fa-flag-o' => '\f11d','fa-flask' => '\f0c3','fa-flickr' => '\f16e','fa-floppy-o' => '\f0c7','fa-folder' => '\f07b','fa-folder-o' => '\f114','fa-folder-open' => '\f07c','fa-folder-open-o' => '\f115','fa-font' => '\f031','fa-fonticons' => '\f280','fa-forumbee' => '\f211','fa-forward' => '\f04e','fa-foursquare' => '\f180','fa-frown-o' => '\f119','fa-futbol-o' => '\f1e3','fa-gamepad' => '\f11b','fa-gavel' => '\f0e3','fa-gbp' => '\f154','fa-genderless' => '\f22d','fa-get-pocket' => '\f265','fa-gg' => '\f260','fa-gg-circle' => '\f261','fa-gift' => '\f06b','fa-git' => '\f1d3','fa-git-square' => '\f1d2','fa-github' => '\f09b','fa-github-alt' => '\f113','fa-github-square' => '\f092','fa-glass' => '\f000','fa-globe' => '\f0ac','fa-google' => '\f1a0','fa-google-plus' => '\f0d5','fa-google-plus-square' => '\f0d4','fa-google-wallet' => '\f1ee','fa-graduation-cap' => '\f19d','fa-gratipay' => '\f184','fa-h-square' => '\f0fd','fa-hacker-news' => '\f1d4','fa-hand-lizard-o' => '\f258','fa-hand-o-down' => '\f0a7','fa-hand-o-left' => '\f0a5','fa-hand-o-right' => '\f0a4','fa-hand-o-up' => '\f0a6','fa-hand-paper-o' => '\f256','fa-hand-peace-o' => '\f25b','fa-hand-pointer-o' => '\f25a','fa-hand-rock-o' => '\f255','fa-hand-scissors-o' => '\f257','fa-hand-spock-o' => '\f259','fa-hdd-o' => '\f0a0','fa-header' => '\f1dc','fa-headphones' => '\f025','fa-heart' => '\f004','fa-heart-o' => '\f08a','fa-heartbeat' => '\f21e','fa-history' => '\f1da','fa-home' => '\f015','fa-hospital-o' => '\f0f8','fa-hourglass' => '\f254','fa-hourglass-end' => '\f253','fa-hourglass-half' => '\f252','fa-hourglass-o' => '\f250','fa-hourglass-start' => '\f251','fa-houzz' => '\f27c','fa-html5' => '\f13b','fa-i-cursor' => '\f246','fa-ils' => '\f20b','fa-inbox' => '\f01c','fa-indent' => '\f03c','fa-industry' => '\f275','fa-info' => '\f129','fa-info-circle' => '\f05a','fa-inr' => '\f156','fa-instagram' => '\f16d','fa-internet-explorer' => '\f26b','fa-ioxhost' => '\f208','fa-italic' => '\f033','fa-joomla' => '\f1aa','fa-jpy' => '\f157','fa-jsfiddle' => '\f1cc','fa-key' => '\f084','fa-keyboard-o' => '\f11c','fa-krw' => '\f159','fa-language' => '\f1ab','fa-laptop' => '\f109','fa-lastfm' => '\f202','fa-lastfm-square' => '\f203','fa-leaf' => '\f06c','fa-leanpub' => '\f212','fa-lemon-o' => '\f094','fa-level-down' => '\f149','fa-level-up' => '\f148','fa-life-ring' => '\f1cd','fa-lightbulb-o' => '\f0eb','fa-line-chart' => '\f201','fa-link' => '\f0c1','fa-linkedin' => '\f0e1','fa-linkedin-square' => '\f08c','fa-linux' => '\f17c','fa-list' => '\f03a','fa-list-alt' => '\f022','fa-list-ol' => '\f0cb','fa-list-ul' => '\f0ca','fa-location-arrow' => '\f124','fa-lock' => '\f023','fa-long-arrow-down' => '\f175','fa-long-arrow-left' => '\f177','fa-long-arrow-right' => '\f178','fa-long-arrow-up' => '\f176','fa-magic' => '\f0d0','fa-magnet' => '\f076','fa-male' => '\f183','fa-map' => '\f279','fa-map-marker' => '\f041','fa-map-o' => '\f278','fa-map-pin' => '\f276','fa-map-signs' => '\f277','fa-mars' => '\f222','fa-mars-double' => '\f227','fa-mars-stroke' => '\f229','fa-mars-stroke-h' => '\f22b','fa-mars-stroke-v' => '\f22a','fa-maxcdn' => '\f136','fa-meanpath' => '\f20c','fa-medium' => '\f23a','fa-medkit' => '\f0fa','fa-meh-o' => '\f11a','fa-mercury' => '\f223','fa-microphone' => '\f130','fa-microphone-slash' => '\f131','fa-minus' => '\f068','fa-minus-circle' => '\f056','fa-minus-square' => '\f146','fa-minus-square-o' => '\f147','fa-mobile' => '\f10b','fa-money' => '\f0d6','fa-moon-o' => '\f186','fa-motorcycle' => '\f21c','fa-mouse-pointer' => '\f245','fa-music' => '\f001','fa-neuter' => '\f22c','fa-newspaper-o' => '\f1ea','fa-object-group' => '\f247','fa-object-ungroup' => '\f248','fa-odnoklassniki' => '\f263','fa-odnoklassniki-square' => '\f264','fa-opencart' => '\f23d','fa-openid' => '\f19b','fa-opera' => '\f26a','fa-optin-monster' => '\f23c','fa-outdent' => '\f03b','fa-pagelines' => '\f18c','fa-paint-brush' => '\f1fc','fa-paper-plane' => '\f1d8','fa-paper-plane-o' => '\f1d9','fa-paperclip' => '\f0c6','fa-paragraph' => '\f1dd','fa-pause' => '\f04c','fa-paw' => '\f1b0','fa-paypal' => '\f1ed','fa-pencil' => '\f040','fa-pencil-square' => '\f14b','fa-pencil-square-o' => '\f044','fa-phone' => '\f095','fa-phone-square' => '\f098','fa-picture-o' => '\f03e','fa-pie-chart' => '\f200','fa-pied-piper' => '\f1a7','fa-pied-piper-alt' => '\f1a8','fa-pinterest' => '\f0d2','fa-pinterest-p' => '\f231','fa-pinterest-square' => '\f0d3','fa-plane' => '\f072','fa-play' => '\f04b','fa-play-circle' => '\f144','fa-play-circle-o' => '\f01d','fa-plug' => '\f1e6','fa-plus' => '\f067','fa-plus-circle' => '\f055','fa-plus-square' => '\f0fe','fa-plus-square-o' => '\f196','fa-power-off' => '\f011','fa-print' => '\f02f','fa-puzzle-piece' => '\f12e','fa-qq' => '\f1d6','fa-qrcode' => '\f029','fa-question' => '\f128','fa-question-circle' => '\f059','fa-quote-left' => '\f10d','fa-quote-right' => '\f10e','fa-random' => '\f074','fa-rebel' => '\f1d0','fa-recycle' => '\f1b8','fa-reddit' => '\f1a1','fa-reddit-square' => '\f1a2','fa-refresh' => '\f021','fa-registered' => '\f25d','fa-renren' => '\f18b','fa-repeat' => '\f01e','fa-reply' => '\f112','fa-reply-all' => '\f122','fa-retweet' => '\f079','fa-road' => '\f018','fa-rocket' => '\f135','fa-rss' => '\f09e','fa-rss-square' => '\f143','fa-rub' => '\f158','fa-safari' => '\f267','fa-scissors' => '\f0c4','fa-search' => '\f002','fa-search-minus' => '\f010','fa-search-plus' => '\f00e','fa-sellsy' => '\f213','fa-server' => '\f233','fa-share' => '\f064','fa-share-alt' => '\f1e0','fa-share-alt-square' => '\f1e1','fa-share-square' => '\f14d','fa-share-square-o' => '\f045','fa-shield' => '\f132','fa-ship' => '\f21a','fa-shirtsinbulk' => '\f214','fa-shopping-cart' => '\f07a','fa-sign-in' => '\f090','fa-sign-out' => '\f08b','fa-signal' => '\f012','fa-simplybuilt' => '\f215','fa-sitemap' => '\f0e8','fa-skyatlas' => '\f216','fa-skype' => '\f17e','fa-slack' => '\f198','fa-sliders' => '\f1de','fa-slideshare' => '\f1e7','fa-smile-o' => '\f118','fa-sort' => '\f0dc','fa-sort-alpha-asc' => '\f15d','fa-sort-alpha-desc' => '\f15e','fa-sort-amount-asc' => '\f160','fa-sort-amount-desc' => '\f161','fa-sort-asc' => '\f0de','fa-sort-desc' => '\f0dd','fa-sort-numeric-asc' => '\f162','fa-sort-numeric-desc' => '\f163','fa-soundcloud' => '\f1be','fa-space-shuttle' => '\f197','fa-spinner' => '\f110','fa-spoon' => '\f1b1','fa-spotify' => '\f1bc','fa-square' => '\f0c8','fa-square-o' => '\f096','fa-stack-exchange' => '\f18d','fa-stack-overflow' => '\f16c','fa-star' => '\f005','fa-star-half' => '\f089','fa-star-half-o' => '\f123','fa-star-o' => '\f006','fa-steam' => '\f1b6','fa-steam-square' => '\f1b7','fa-step-backward' => '\f048','fa-step-forward' => '\f051','fa-stethoscope' => '\f0f1','fa-sticky-note' => '\f249','fa-sticky-note-o' => '\f24a','fa-stop' => '\f04d','fa-street-view' => '\f21d','fa-strikethrough' => '\f0cc','fa-stumbleupon' => '\f1a4','fa-stumbleupon-circle' => '\f1a3','fa-subscript' => '\f12c','fa-subway' => '\f239','fa-suitcase' => '\f0f2','fa-sun-o' => '\f185','fa-superscript' => '\f12b','fa-table' => '\f0ce','fa-tablet' => '\f10a','fa-tachometer' => '\f0e4','fa-tag' => '\f02b','fa-tags' => '\f02c','fa-tasks' => '\f0ae','fa-taxi' => '\f1ba','fa-television' => '\f26c','fa-tencent-weibo' => '\f1d5','fa-terminal' => '\f120','fa-text-height' => '\f034','fa-text-width' => '\f035','fa-th' => '\f00a','fa-th-large' => '\f009','fa-th-list' => '\f00b','fa-thumb-tack' => '\f08d','fa-thumbs-down' => '\f165','fa-thumbs-o-down' => '\f088','fa-thumbs-o-up' => '\f087','fa-thumbs-up' => '\f164','fa-ticket' => '\f145','fa-times' => '\f00d','fa-times-circle' => '\f057','fa-times-circle-o' => '\f05c','fa-tint' => '\f043','fa-toggle-off' => '\f204','fa-toggle-on' => '\f205','fa-trademark' => '\f25c','fa-train' => '\f238','fa-transgender' => '\f224','fa-transgender-alt' => '\f225','fa-trash' => '\f1f8','fa-trash-o' => '\f014','fa-tree' => '\f1bb','fa-trello' => '\f181','fa-tripadvisor' => '\f262','fa-trophy' => '\f091','fa-truck' => '\f0d1','fa-try' => '\f195','fa-tty' => '\f1e4','fa-tumblr' => '\f173','fa-tumblr-square' => '\f174','fa-twitch' => '\f1e8','fa-twitter' => '\f099','fa-twitter-square' => '\f081','fa-umbrella' => '\f0e9','fa-underline' => '\f0cd','fa-undo' => '\f0e2','fa-university' => '\f19c','fa-unlock' => '\f09c','fa-unlock-alt' => '\f13e','fa-upload' => '\f093','fa-usd' => '\f155','fa-user' => '\f007','fa-user-md' => '\f0f0','fa-user-plus' => '\f234','fa-user-secret' => '\f21b','fa-user-times' => '\f235','fa-users' => '\f0c0','fa-venus' => '\f221','fa-venus-double' => '\f226','fa-venus-mars' => '\f228','fa-viacoin' => '\f237','fa-video-camera' => '\f03d','fa-vimeo' => '\f27d','fa-vimeo-square' => '\f194','fa-vine' => '\f1ca','fa-vk' => '\f189','fa-volume-down' => '\f027','fa-volume-off' => '\f026','fa-volume-up' => '\f028','fa-weibo' => '\f18a','fa-weixin' => '\f1d7','fa-whatsapp' => '\f232','fa-wheelchair' => '\f193','fa-wifi' => '\f1eb','fa-wikipedia-w' => '\f266','fa-windows' => '\f17a','fa-wordpress' => '\f19a','fa-wrench' => '\f0ad','fa-xing' => '\f168','fa-xing-square' => '\f169','fa-y-combinator' => '\f23b','fa-yahoo' => '\f19e','fa-yelp' => '\f1e9','fa-youtube' => '\f167','fa-youtube-play' => '\f16a','fa-youtube-square' => '\f166' );
        ?>


        <table>
            <thread>
                <tr>
                    <th><?php echo "<h3>Icon 1</h3>";?></th>
                </tr>
            </thread>

            <tbody>
                <tr>
                    <td>
                        <select id="icon1" name="icon1">
                        <?php
                        $actual=$re[0]->icon1;
                        foreach($font_awesome_icons as $k=>$v) {
                            if($k==$actual) echo '<option value="'.$k.'" selected>'.$k.'</option>';
                            else echo '<option value="'.$k.'">'.$k.'</option>';
                        }
                        ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" id="color1" name="color1" value="<?php echo $re[0]->color1; ?>" class="wp-color-picker-field" data-default-color="<?php echo $re[0]->color1; ?>" />
                    <script>jQuery(document).ready(function($){
                        $('.wp-color-picker-field').wpColorPicker();
                    });</script>
                    </td>
                </tr>
            </tbody>
        </table>

        
        <table>
            <thread>
                <tr>
                    <th><?php echo "<h3>Icon 2</h3>";?></th>
                </tr>
            </thread>

            <tbody>
                <tr>
                    <td>
                        <select id="icon2" name="icon2">
                        <?php
                        $actual=$re[0]->icon2;
                        foreach($font_awesome_icons as $k=>$v) {
                            if($k==$actual) echo '<option value="'.$k.'" selected>'.$k.'</option>';
                            else echo '<option value="'.$k.'">'.$k.'</option>';
                        }
                        ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" id="color2" name="color2" value="<?php echo $re[0]->color2; ?>" class="wp-color-picker-field" data-default-color="<?php echo $re[0]->color2; ?>" />
                    <script>jQuery(document).ready(function($){
                        $('.wp-color-picker-field').wpColorPicker();
                    });</script>
                    </td>
                </tr>
            </tbody>
        </table>    
            

        <table>
            <thread>
                <tr>
                    <th><?php echo "<h3>Icon 3</h3>";?></th>
                </tr>
            </thread>

            <tbody>
                <tr>
                    <td>
                        <select id="icon3" name="icon3">
                        <?php
                        $actual=$re[0]->icon3;
                        foreach($font_awesome_icons as $k=>$v) {
                            if($k==$actual) echo '<option value="'.$k.'" selected>'.$k.'</option>';
                            else echo '<option value="'.$k.'">'.$k.'</option>';
                        }
                        ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" id="color3" name="color3" value="<?php echo $re[0]->color3; ?>" class="wp-color-picker-field" data-default-color="<?php echo $re[0]->color3; ?>" />
                    <script>jQuery(document).ready(function($){
                        $('.wp-color-picker-field').wpColorPicker();
                    });</script>
                    </td>
                </tr>
            </tbody>
        </table>
        
        
        <table>
            <thread>
                <tr>
                    <th><?php echo "<h3>Icon 4</h3>";?></th>
                </tr>
            </thread>

            <tbody>
                <tr>
                    <td>
                        <select id="icon4" name="icon4">
                        <?php
                        $actual=$re[0]->icon4;
                        foreach($font_awesome_icons as $k=>$v) {
                            if($k==$actual) echo '<option value="'.$k.'" selected>'.$k.'</option>';
                            else echo '<option value="'.$k.'">'.$k.'</option>';
                        }
                        ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" id="color4" name="color4" value="<?php echo $re[0]->color4; ?>" class="wp-color-picker-field" data-default-color="<?php echo $re[0]->color4; ?>" />
                    <script>jQuery(document).ready(function($){
                        $('.wp-color-picker-field').wpColorPicker();
                    });</script>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Check all the icon designs on Font-awesome.</a> 

        <br /><br />

        <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"  />
        <br /><br /><hr>
    </form>


    <?php 

    }
        $re_files = $wpdb->get_results( "SELECT * FROM $table_name2 ORDER BY idslider DESC" );



    echo "<br /><h2>History</h2><h4>Check your created sliders. (new to old):</h4>";

        $count_reg=count($re_files);

        if ($count_reg == 0){
            echo "You don't have any Cube Slider created, yet.";
        }

        $c=0;

        while($c<$count_reg){

    ?>

    
    <table class="widefat" style="width:auto, height:auto">
        <thead>
        <tr>
            <th><b>ID</th>
            <th><b>NAME</b></th>
            <th><b>ABOUT</b></th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td><?php echo $re_files[$c]->idslider;?></td>
            <td><?php echo $re_files[$c]->name;?></td> 
            <td><?php echo $re_files[$c]->about;?></td>
        </tr>
        </tbody>
    </table>

    <p>Copy and paste where you want to show the slider: [cubeslider id=<?php echo $re_files[$c]->idslider; ?>]</p>
    <form method="post">
        <input type="hidden" value="<?php echo $re_files[$c]->idslider; ?>" id="idslider" name="idslider" />
        <input type="submit" name="edit" id="edit" class="button button-seconday" style="background-color: #449D44; border-color: #255625; color: white;" value="Click to edit slider <?php echo $re_files[$c]->idslider; ?> details"  />
        <input type="submit" name="delete" id="delete" class="button button-seconday" style="background-color: #D9534F; border-color: #D43F3A; color: white;" value="Click to delete slider <?php echo $re_files[$c]->idslider; ?>"  />
    </form>

    <br /><hr><br />
<?php
    $c++;
    } // While
}
?>