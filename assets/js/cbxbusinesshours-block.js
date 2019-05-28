'use strict';

console.log('hi there');

( function( blocks, element ) {
    var el = element.createElement;
    var __ = wp.i18n.__; // The __() function for internationalization.

    var blockStyle = {
        backgroundColor: '#900',
        color: '#fff',
        padding: '20px',
    };

    blocks.registerBlockType( 'codeboxr/cbxbusinesshours', {
        title: __('Example: Basic'),
        icon: 'universal-access-alt',
        category: 'layout',
        edit: function() {
            return el(
                'p',
                { style: blockStyle },
                'Hello World, step 1 (from the editor).'
            );
        },
        save: function() {
            return el(
                'p',
                { style: blockStyle },
                'Hello World, step 1 (from the frontend).'
            );
        },
    } );
}(
    window.wp.blocks,
    window.wp.element
) );