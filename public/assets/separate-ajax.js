$(document).ready(function () {

    $(document).on('click', '#add', function (e) {
        e.preventDefault();
        let url = $(this).attr('action_url');
        $.get(url, function (data) {
            $('#container').replaceWith(data);
            $('.title').html("Create New User");
            $('.col-md-4').html('');

        }).fail(function (response) {
            let errors = response.responseJSON.errors;
            if (errors) {
                let errorMsg = 'Validation errors:\n';
                $.each(errors, function (key, value) {
                    errorMsg += value.join(', ') + '\n';
                });
                Swal.fire('Error', errorMsg, 'danger');
            } else {
                Swal.fire('Error', 'An unexpected error occurred. Please try again.',
                    'danger');
            }
        })
    });

    $(document).on('submit', '#submit_form', function (e) {
        e.preventDefault();
        let url = $(this).attr('action_url');
        let data = $(this).serialize();
        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire('Success', response.message, 'success');
                    $('#submit_form')[0].reset();
                }
                if (response.status === 'update') {
                    Swal.fire('Success', response.message, 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let error = '';
                    $.each(errors, function (key, value) {
                        error += value[0];
                    });
                    Swal.fire('Error', error, 'error');
                } else {
                    Swal.fire('Error', 'An unexpected error occurred. Please try again.', 'error');
                }
            }
        });
    });

    function fetch_data(query = '', url) {
        $.ajax({
            url: url,
            method: "GET",
            data: {
                search: query
            },
            success: function (data) {
                $('#record_data').html(data);
            }
        });
    }

    let typingTimer;
    let debounceTime = 300;
    $('#search').on('keyup', function () {
        clearTimeout(typingTimer);
        let query = $(this).val();
        let url = $(this).attr('action_url');
        typingTimer = setTimeout(function () {
            fetch_data(query, url);
        }, debounceTime);
    });

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        let url = $('#search').attr('action_url');
        $.get(url + '?page=' + page, function (data) {
            $('#record_data').html(data);
        });
    });

    $(document).on('click', '.edit', function () {
        var id = $(this).data('id');
        let url = $(this).attr('action_url');
        $.ajax({
            url: url,
            method: 'GET',
            success: function (data) {
                $('#container').replaceWith(data);
                $('.title').html("Update User");
                $('.col-md-4').html('');
            }
        });
    });

    $(document).on('click', '.delete', function () {
        var id = $(this).data('id');
        let url = $(this).attr('action_url');
        let token = $('meta[name="csrf-token"]').attr('content');
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
                    method: 'DELETE',
                    data: {
                        _token: token
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire('Success', response.message, 'success');
                            $('table tbody').find('button[data-id="' + id +
                                '"]').closest('tr').remove();
                            let url = $('#search').attr('action_url');
                            $('#record_data').load(url)
                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire('Cancelled', 'Item deletion was cancelled.', 'info');
            }
        });
    });
});