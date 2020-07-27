<?php

/**
 * Создаем страницу настроек
 */
add_action('admin_menu', 'add_plugin_page');
function add_plugin_page(){
    add_options_page( 'Plugin settings', 'External Link Attribute', 'manage_options', 'elf_slug', 'elf_options_page_output' );
}

function elf_options_page_output(){
    ?>
    <div class="wrap">
        <h2><?php echo get_admin_page_title() ?></h2>

        <form action="options.php" method="POST">
            <?php
            settings_fields( 'option_group' );     // скрытые защитные поля
            do_settings_sections( 'elf_page' ); // секции с настройками (опциями). У нас она всего одна 'section_id'
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

/**
 * Регистрируем настройки.
 */
add_action('admin_init', 'plugin_settings');
function plugin_settings(){

    //$post_types_arr = getCurrentPostTypes();

    register_setting( 'option_group', 'option_attr', 'sanitize_callback' );

    add_settings_section( 'section_attr', '', '', 'elf_page' );
    //add_settings_section( 'section_post_type', 'Which post types use attribute filtering:', '', 'elf_page' );

    add_settings_field('attr_nofollow', 'Nofollow attribute for external links', 'fill_attr_nofollow', 'elf_page', 'section_attr' );
    add_settings_field('attr_blank', 'Open links in a new tab', 'fill_attr_blank', 'elf_page', 'section_attr' );

//    foreach ($post_types_arr as $value) {
//        var_dump($value);
//        add_settings_field("$value", "$value", 'fill_post_type', 'elf_page', 'section_post_type' );
//
//    }
}
//function fill_post_type(){
//    $val = get_option('option_attr');
//    $val = $val ? $val['post_type'] : null;
//        ?>
<!--        <input type="checkbox" name="option_attr[post_type]" value="1" --><?php //checked( 1, $val ) ?><!-- />-->
<!--        --><?php
//    }

## Опция Nofollow
function fill_attr_nofollow(){
    $val = get_option('option_attr');
    $val = $val ? $val['nofollow'] : null;
    ?>
    <label><input type="checkbox" name="option_attr[nofollow]" value="1" <?php checked( 1, $val ) ?> /></label>
    <?php
}

## Опция _blank
function fill_attr_blank(){
    $val = get_option('option_attr');
    $val = $val ? $val['blank'] : null;
    ?>
    <label><input type="checkbox" name="option_attr[blank]" value="1" <?php checked( 1, $val ) ?> /></label>
    <?php
}

## Очистка данных
function sanitize_callback( $options ){
    // очищаем
    foreach( $options as $name => & $val ){

            $val = intval( $val );
    }

    return $options;
}