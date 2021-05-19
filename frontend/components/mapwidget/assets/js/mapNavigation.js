/**
 * Map interactions (right panel)
 */
jQuery(function($) {
    // collapse-sidebar
    $('.collapse-sidebar').click(function () {
        $('.full').toggle();
        $(this).children('span').first().toggleClass('glyphicon-chevron-left glyphicon-chevron-right');
    });
    // map interaction: toggle hike layer
    $('li.toggle-hike').click(function () {
        var element = $(this).children().first('input');
        $(document).trigger('toggleHikeLyer', element.is(':checked'));
    });

    // map interaction: toggle perimeter layer
    $('li.toggle-perimeter').click(function () {
        var element = $(this).children().first('input');
        $(document).trigger('togglePerimeter', element.is(':checked'))
    });

    // geolocation: find me.
    $('.locate-me').click(function () {
        $(document).trigger('locateMe');
    });

    // move zoom elements - easier than re-attaching custom elements.
    $('.ol-zoom').children().addClass('btn btn-default').appendTo('.zoom');
    $('.ol-zoom-in').addClass('btn btn-default btn-sm zoom-in').html('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>');
    $('.ol-zoom-out').addClass('btn btn-default btn-sm zoom-out').html('<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>');
});
