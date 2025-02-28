<?php 
require("config/content-config.php");
if(isset($banner['banner'])) {
    echo '<section id="banners">';
    if(isset($banner['url_banner'])) { 
            echo "<a href='" . $banner['url_banner'] . "' class='link-banner' target='_blank'>";
    }
    echo '<div class="full-banner">';
        
        echo '<div class="img-banner max-width-container">';
            
            if(isset($banner['banner'])) {
                if(intval($banner['predefinido']) == true) {
                    echo '<img src="' . base_url("assets/img/banners/" . $banner['banner']) . '" alt="banner">';
                }
                else {
                    echo '<img src="' . base_url("dynamic-page-content/$url/assets/uploads/img/banners/" . $banner['banner']) . '" alt="banner">';
                }
            }
        echo '</div>';
    echo '</div>';
    if(isset($banner['url_banner'])) { 
        echo '</a>';
    }
    echo '</section>';
} ?>