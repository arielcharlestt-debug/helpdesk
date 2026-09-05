(function ($) {
    acf.addAction('ready', function () {
        if (!WPDocumentationData.is_pro) {
            $('.acf-button-group label').each(function () {
                const $label = $(this);
                const labelText = $label.text().toLowerCase();

                if (labelText.includes('(pro)')) {
                    const $input = $label.find('input');

                    $input.prop('disabled', true);

                    $label
                        .css({ opacity: 0.5, cursor: 'not-allowed', position: 'relative' })
                        .attr('title', 'Available in Pro version');
                }
            });
        }
    });
})(jQuery);
