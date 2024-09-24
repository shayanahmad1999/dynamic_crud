$(document).ready(function () {

    $('#add_data').click(function () {
        let url = $(this).attr('action_url');
        $.get(url, function (data) {
            $('#modal .modal-content').html(data);
            $('#modal').modal('show');
        });
    });

    $(document).on('submit', '#form_submit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        let url = $(this).attr('action_url');
        $('#modal .modal-content').prepend('<div class="loading">Loading...</div>');
        $.post(url, formData, function (data) {
            let url = $('#search').attr('action_url');
            $('#record_table').load(url);
            $('#modal').modal('hide');
            Swal.fire('Success', data.message, 'success');
        }).fail(function (response) {
            let errors = response.responseJSON.errors;
            if (errors) {
                let errorMsg = 'Validation errors:\n';
                $.each(errors, function (key, value) {
                    errorMsg += value.join(', ') + '\n';
                });
                Swal.fire('Error', errorMsg, 'danger');
            } else {
                Swal.fire('Error', 'An unexpected error occurred. Please try again.', 'danger');
            }
        }).always(function () {

            $('#modal .loading').remove();
        });
    });

    $('#search').on('keyup', function () {
        let searchQuery = $(this).val();
        let url = $(this).attr('action_url');
        debounceTimer = setTimeout(() => {
            $.get(url, {
                search: searchQuery
            }, function (data) {
                $('#record_table').html(data);
            });
        }, 300);
    });

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        let url = $('#search').attr('action_url');
        $.get(url + '?page=' + page, function (data) {
            $('#record_table').html(data);
        });
    });

    $(document).on('click', '.edit', function () {
        let id = $(this).data('id');
        let url = $(this).attr('action_url');
        $.get(url, function (data) {
            $('#modal .modal-content').html(data);
            $('#modal').modal('show');
        });
    });

    $(document).on('submit', '#form_edit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        let url = $(this).attr('action_url');

        $.ajax({
            url: url,
            type: 'PUT',
            data: formData,
            success: function (data) {
                $('#modal').modal('hide');
                let url = $('#search').attr('action_url');
                $('#record_table').load(url);
                Swal.fire('Success', data.message, 'success');
            },
            error: function (xhr) {
                Swal.fire('Error', 'Error updating item', 'error');
            }
        });
    });

    $(document).on('click', '.delete', function () {
        let id = $(this).data('id');
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
                    type: 'DELETE',
                    data: {
                        _token: token
                    },
                    success: function (data) {
                        let url = $('#search').attr('action_url');
                        $('#record_table').load(url);
                        Swal.fire('Success', data.message, 'success');
                    },
                    error: function (xhr) {
                        Swal.fire('Error', 'Error deleting item', 'error');
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire('Cancelled', 'Category deletion was cancelled.', 'info');
            }
        });
    });
    
});