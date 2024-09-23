$(document).ready(function() {
    $('#form_submit').on('submit', function(e) {
        e.preventDefault();

        $('#error-messages').hide().html('');

        let url = $(this).attr('action');
        let data = $(this).serialize();

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            cache: false,
            success: function(response) {
                if (response.status === 'success') {
                    // var obj = jQuery.parseJSON(JSON.stringify(response));
                    $('#success-message').html(response.message).fadeIn().delay(2000)
                        .fadeOut();
                        let id = $('#update_key').val();
                    if (id) {
                        $('table tbody').find("button[data-id='" + id +"']").closest('tr').replaceWith(response.data);
                    } else {
                        $('table tbody').prepend(response.data);
                    }
                    $('#update_key').val('');
                    $('#form_submit')[0].reset();
                    $('button[type="submit"]').text('Create User');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = '<div class="alert alert-danger"><ul>';

                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });

                    errorHtml += '</ul></div>';

                    $('#error-messages').html(errorHtml).fadeIn().delay(3000).fadeOut();

                    setTimeout(function() {
                        $('#error-messages').fadeOut();
                    }, 5000);
                }
            }
        });
    });

    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        let url = $(this).attr('action_url');
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: id,
                    cache: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#success-message').html(response.message)
                                .fadeIn()
                                .delay(2000)
                                .fadeOut();
                            $('table tbody').find("button[data-id='" + id +
                                    "']")
                                .closest('tr').remove();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorHtml =
                                '<div class="alert alert-danger"><ul>';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] +
                                    '</li>';
                            });

                            errorHtml += '</ul></div>';
                            $('#error-messages').html(errorHtml).fadeIn().delay(
                                3000).fadeOut();
                            setTimeout(function() {
                                $('#error-messages').fadeOut();
                            }, 5000);
                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire('Cancelled', 'Category deletion was cancelled.', 'info');
            }
        });

    });

    $(document).on('click', '.edit', function(e) {
        e.preventDefault();
        let url = $(this).attr('action_url');
        let id = $(this).data('id');
        $.ajax({
            url: url,
            method: 'GET',
            data: id,
            cache: false,
            success: function(response) {
                if (response.status === 'success') {
                    $.each(response.data, function(key, value) {
                        $('#' + key).val(value);
                    });
                    $('#update_key').val(id);
                    $('button[type="submit"]').text('Update User');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorHtml =
                        '<div class="alert alert-danger"><ul>';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value[0] +
                            '</li>';
                    });

                    errorHtml += '</ul></div>';
                    $('#error-messages').html(errorHtml).fadeIn().delay(
                        3000).fadeOut();
                    setTimeout(function() {
                        $('#error-messages').fadeOut();
                    }, 5000);
                }
            }
        });
    });

    $(document).on('keyup', '#search', function(e) {
        e.preventDefault();
        let url = $(this).attr('action_url')
        let search_string = $('#search').val();
        $.ajax({
            url: url,
            method: 'GET',
            data: {
                search_string: search_string
            },
            success: function(res) {
                $('table tbody').html(res)
                if (res.status == 'Nothing found') {
                    $('table tbody').html(
                        '<tr><td colspan="3" class="text-danger text-center">' +
                        'Nothing found' + '</td></tr>')
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            },
        })
    });

    $('#load-more-btn').click(function(e) {
        e.preventDefault();

        var nextPageUrl = $(this).data('next-page');

        if (nextPageUrl) {
            var $button = $(this);
            $button.prop('disabled', true);
            $button.html('Loading... <div class="spinner"></div>');

            setTimeout(function() {
                $.ajax({
                    url: nextPageUrl,
                    method: 'GET',
                    success: function(data) {
                        $button.prop('disabled', false);
                        $button.html('Load More');
                        $('#data_record').append(data.html);
                        if (data.nextPageUrl) {
                            $button.data('next-page', data.nextPageUrl);
                        } else {
                            $button.remove();
                        }
                    },
                    error: function(xhr, status, error) {
                        $button.prop('disabled', false);
                        $button.html('Load More');
                        console.error(error);
                    }
                });
            }, 100);
        }
    });
});