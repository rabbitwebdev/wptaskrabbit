( function ( blocks, element, components, i18n ) {
    var el = element.createElement;
    var InspectorControls = (wp.blockEditor && wp.blockEditor.InspectorControls) || (wp.editor && wp.editor.InspectorControls);

    blocks.registerBlockType( 'wprabbit/task-form', {
        edit: function ( props ) {
            var attrs = props.attributes;

            function setAttr( key ) {
                return function ( value ) {
                    var next = {};
                    next[ key ] = value;
                    props.setAttributes( next );
                };
            }

            return el( 'div', { className: props.className },
                InspectorControls && el( InspectorControls, {},
                    el(components.PanelBody, { title: i18n.__('Google Reviews', 'wp-rabbit-dev'), initialOpen: true },
                        el( components.TextControl, {
                            label: i18n.__( 'Title', 'wp-rabbit-dev' ),
                            value: attrs.title,
                            onChange: setAttr( 'title' )
                        }),
                        el( components.TextControl, {
                            label: i18n.__( 'Button URL', 'wp-rabbit-dev' ),
                            value: attrs.btnUrl,
                            onChange: setAttr( 'btnUrl' )
                        }),
                        el( components.TextControl, {
                            label: i18n.__( 'Button Text', 'wp-rabbit-dev' ),
                            value: attrs.btnText,
                            onChange: setAttr( 'btnText' )
                        }),
                        el( components.RangeControl, {
                            label: i18n.__( 'Limit', 'wp-rabbit-dev' ),
                            value: attrs.limit,
                            min: 1,
                            max: 20,
                            onChange: setAttr( 'limit' )
                        }),
                        el( components.RangeControl, {
                            label: i18n.__( 'Minimum rating', 'wp-rabbit-dev' ),
                            value: attrs.minRating,
                            min: 1,
                            max: 5,
                            onChange: setAttr( 'minRating' )
                        }),
                        el( components.SelectControl, {
                            label: i18n.__( 'Layout', 'wp-rabbit-dev' ),
                            value: attrs.layout,
                            options: [
                                { label: i18n.__( 'Grid', 'wp-rabbit-dev' ), value: 'grid' },
                                { label: i18n.__('Slider', 'wp-rabbit-dev'), value: 'slider' },
                                 { label: i18n.__( 'Bento Grid', 'wp-rabbit-dev' ), value: 'bento' }
                            ],
                            onChange: setAttr( 'layout' )
                        }),
                         el( components.SelectControl, {
                            label: i18n.__( 'Background Color', 'wp-rabbit-dev' ),
                            value: attrs.bgColor,
                            options: [
                                { label: i18n.__( 'Transparent', 'wp-rabbit-dev' ), value: 'transparent' },
                                { label: i18n.__('Linear Top', 'wp-rabbit-dev'), value: 'bg-linear-to-t from-slate-900 to-slate-950' },
                                { label: i18n.__('Slate', 'wp-rabbit-dev'), value: 'bg-slate-950' },
                                     { label: i18n.__( 'Gradient', 'wp-rabbit-dev' ), value: 'bg-gradient-to-br from-indigo-950 via-slate-900 to-slate-950' },
                                { label: i18n.__( 'Linear Bottom', 'wp-rabbit-dev' ), value: 'bg-linear-to-b from-slate-900 via-indigo-950 to-slate-950' }
                            ],
                            onChange: setAttr( 'bgColor' )
                         }),
                        el(components.SelectControl, {
                            label: i18n.__( 'Padding', 'wp-rabbit-dev' ),
                            value: attrs.padding,
                            options: [
                                { label: i18n.__( 'Normal', 'wp-rabbit-dev' ), value: 'sm:px-4 sm:py-12' },
                                { label: i18n.__('None', 'wp-rabbit-dev'), value: 'none' },
                                { label: i18n.__('Small', 'wp-rabbit-dev'), value: 'sm:px-2 sm:py-6' },
                                { label: i18n.__('Large', 'wp-rabbit-dev'), value: 'sm:px-8 sm:py-24' }
                            ],
                            onChange: setAttr( 'padding' )
                        }),
                        el( components.ToggleControl, {
                            label: i18n.__( 'Show stars', 'wp-rabbit-dev' ),
                            checked: !!attrs.showStars,
                            onChange: setAttr( 'showStars' )
                        }),
                        el( components.ToggleControl, {
                            label: i18n.__( 'Show date', 'wp-rabbit-dev' ),
                            checked: !!attrs.showDate,
                            onChange: setAttr( 'showDate' )
                        }),
                        el( components.ToggleControl, {
                            label: i18n.__( 'Show text', 'wp-rabbit-dev' ),
                            checked: !!attrs.showText,
                            onChange: setAttr( 'showText' )
                        })
                    )
                ),
                el( 'div', { className: 'wp-rabbit-dev' },
                    el( 'strong', {}, 'Task Rabbit' ),
                    el( 'p', { style: { marginTop: '8px' } }, 'Preview uses your front-end output. If you enabled Test Mode, you\'ll see mock reviews.' ),
                    el( 'p', { style: { marginTop: '8px', opacity: 0.75 } },
                        'Limit: ' + (attrs.limit || 6) + ' • Min rating: ' + (attrs.minRating || 1) + ' • Layout: ' + (attrs.layout || 'grid')
                    )
                )
            );
        },
        save: function () {
            return null; // dynamic render
        }
    } );
} )( window.wp.blocks, window.wp.element, window.wp.components, window.wp.i18n );
