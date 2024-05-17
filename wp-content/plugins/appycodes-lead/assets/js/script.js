jQuery(document).ready(function ($) {
    // AJAX form submission
    $('#appycodes-lead-form').submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var submitBtn = form.find('input[type="submit"]');
        var loader = '<span class="spinner is-active"></span>';

        submitBtn.attr('disabled', true).val('Submitting...').after(loader);

        var formData = form.serialize();

        $.ajax({
            type: 'POST',
            url: appycodes_lead_ajax.ajax_url,
            data: formData + '&action=appycodes_lead_submit_form&nonce=' + appycodes_lead_ajax.nonce,
            success: function (response) {
                if (response.success) {
                    form.find('.appycodes-lead-message').html('<div class="notice notice-success is-dismissible">' + response.data.message + '</div>');
                    // Automatically remove success message and form details after 0.5 seconds
                    setTimeout(function () {
                        form.find('.appycodes-lead-message').fadeOut('fast');
                        form.trigger('reset');
                    }, 500);
                } else {
                    form.find('.appycodes-lead-message').html('<div class="notice notice-error is-dismissible">' + response.data.message + '</div>');
                }
                submitBtn.attr('disabled', false).val('Submit');
                form.find('.spinner').remove();
            },
            error: function (textStatus, errorThrown) {
                form.find('.appycodes-lead-message').html('<div class="notice notice-error is-dismissible">An error occurred: ' + errorThrown + '</div>');
                submitBtn.attr('disabled', false).val('Submit');
                form.find('.spinner').remove();
            }
        });
    });
});
