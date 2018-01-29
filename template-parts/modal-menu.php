<?php

/*
Modal - Menu
*/

?>
<div class="modal-menu reveal" id="modal-menu" data-reveal data-overlay="false">
    <div class="modal-content">
        <div class="row small-collapse">
            <div class="small-12 columns">
                
                <nav id="site-navigation" class="nav-primary" role="navigation"  data-equalizer-watch>
                    <h6>Sitemap</h6>
                        <?php
                            // Desktop Menu
                            $args = array(
                                'theme_location' => 'primary',
                                'menu' => 'Primary Menu',
                                'container' => 'false',
                                'container_class' => '',
                                'container_id' => '',
                                'menu_id'        => 'primary-menu',
                                'menu_class'     => 'vertical menu',
                                'before' => '',
                                'after' => '',
                                'link_before' => '',
                                'link_after' => '',
                                'items_wrap' => '<ul id="%1$s" class="%2$s" data-accordion-menu>%3$s</ul>',
                                'depth' => 0
                            );
                            wp_nav_menu($args);
                        ?>
                </nav><!-- #site-navigation -->
                
                
            </div>
            
        </div>
            
    </div>

</div>