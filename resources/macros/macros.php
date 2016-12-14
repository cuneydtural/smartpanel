<?php

Form::macro( 'selectize', function( $name, $list = [], $selected = null, $options = [] )
{
    if ( ! isset($options['class'])) $options['class'] = 'selectize';

    $classes = explode(' ', $options['class']);
    if (!in_array("selectize", $classes))
        $classes[] = "selectize";
    if (!in_array("form-control", $classes))
        $classes[] = "form-control";
    $options['class'] = implode(" ", $classes);

    return Form::select( $name, $list, $selected, $options );
});

Form::macro( 'select2', function( $name, $list = [], $selected = null, $options = [] )
{
    if ( ! isset($options['class'])) $options['class'] = 'form-control';

    $classes = explode(' ', $options['class']);
    if (!in_array("form-control", $classes))
        $classes[] = "form-control";
    $options['class'] = implode(" ", $classes);

    return Form::select( $name, $list, $selected, $options );
});

Form::macro( 'text2', function( $name, $value = null, $options = [] )
{
    if ( ! isset($options['class'])) $options['class'] = 'form-control';

    $classes = explode(' ', $options['class']);
    if (!in_array("form-control", $classes))
        $classes[] = "form-control";
    $options['class'] = implode(" ", $classes);

    return Form::text( $name, $value, $options );
});

Form::macro( 'textarea2', function( $name, $value = null, $options = [] )
{
    if ( ! isset($options['class'])) $options['class'] = 'form-control';

    $classes = explode(' ', $options['class']);
    if (!in_array("form-control", $classes))
        $classes[] = "form-control";
    $options['class'] = implode(" ", $classes);

    return Form::textarea( $name, $value, $options );
});

Form::macro( 'checkbox2', function( $name, $value = 1, $checked = null, $options = [] )
{
    return Form::hidden( $name, '0', ["id"=>""] ) . Form::checkbox($name, $value, $checked, $options) ;
});
