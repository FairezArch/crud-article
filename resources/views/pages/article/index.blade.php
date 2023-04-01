@extends('master')
@section('title', '- Artikel')

@section('content-page')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Artikel</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    @if (auth()->user()->hasRole('author'))
                    <button class="btn btn-dark" id="addData">
                        <h6 class="m-0 font-weight-bold text-white">Tambah Artikel</h6>
                    </button>
                    @endif
                </div>
                <div class="card-body">
                    <table id="dataTable"></table>
                </div>
            </div>
        </div>
    </div>


    <!-- boostrap model -->
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form id="addEditForm" name="addEditForm" class="form-horizontal">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group row">
                            <label for="title" class="col-sm-4 control-label col-form-label">Judul<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Judul artikel" maxlength="50">
                                <div class="alert alert-danger d-none error-title mt-3 p-2" id="error-title"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="control-label col-form-label">Konten</label>
                            <textarea name="content" id="content" class="form-control" cols="131" rows="5"></textarea>
                            <div class="alert alert-danger d-none error-content mt-3 p-2" id="error-content"></div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10 mt-3">
                            <button type="submit" class="btn btn-primary" id="btn-save" value="create">Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- end bootstrap model -->

@section('add-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(() => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const table = $('#dataTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('article.index') }}",
                columns: [{
                        data: 'title',
                        name: 'title',
                        title: 'Judul'
                    },
                    {
                        data: 'users.name',
                        name: 'users.name',
                        title: 'Pengarang'
                    },
                    {
                        data: 'content',
                        name: 'content',
                        title: 'Konten'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Kelola'
                    }
                ]
            })

            $('#addData').click(function() {
                $('#id').val('')

                $('#title').removeClass('is-invalid');
                $('#error-title').addClass('d-none').text('')

                $('#content').removeClass('is-invalid');
                $('#error-content').addClass('d-none').text('')

                $('#addEditForm').trigger("reset")
                $('#modal-title').html("Tambah Artikel")
                $('#ajaxModel').modal('show')
            });


            $('body').on('click', '.edit', function() {
                let id = $(this).data('id');
                $.get("/article/" + id + "/edit", function(res) {
                    $('#title').removeClass('is-invalid');
                    $('#error-title').addClass('d-none').text('')

                    $('#content').removeClass('is-invalid');
                    $('#error-content').addClass('d-none').text('')

                    $('#addEditForm').trigger("reset");
                    $('#modal-title').html("Edit Artikel");

                    $('#ajaxModel').modal('show');

                    $('#id').val(res.data.id);
                    $('#title').val(res.data.title);
                    $('textarea#content').val(res.data.content);
                })
            })
            $(document).on('submit', '#addEditForm', function(e) {
                e.preventDefault();
                let elm = $('#btn-save');
                elm.attr('disabled', 'disabled');
                let formData = new FormData(this);
                if ($('#id').val() > 0) {
                    formData.append('_method', 'PUT');
                }
                formData.append("addEditForm", true);
                $.ajax({
                    data: formData,
                    url: $('#id').val() > 0 ? "/article/" + $('#id').val() :
                        "{{ route('article.store') }}",
                    type: "POST",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        elm.html(
                            '<div class="spinner-border mr-2" style="width: 1rem!Important; height: 1rem!important;" role="status"><span class="sr-only"></span></div>Loading...'
                        )
                    },
                    success: function(res) {
                        if (res.status) {
                            $('#addEditForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw()
                        } else {
                            alert('Something error');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status == 422) {
                            let errors = JSON.parse(xhr.responseText);
                            $.each(errors.errors, function(key, value) {
                                $(`#${key}`).addClass('is-invalid');
                                $(`#error-${key}`).removeClass('d-none').text(value)
                            })
                        }
                        elm.html('Simpan')
                        elm.removeAttr('disabled')
                    },
                    complete: function() {
                        elm.html('Simpan')
                        elm.removeAttr('disabled')
                    }
                });
            });
            $('body').on('click', '.delete', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        let id = $(this).data("id");
                        $.ajax({
                            url: "/article" + '/' + id,
                            type: "DELETE",
                            dataType: 'json',
                            success: function() {
                                Swal.fire('Success.', 'Hapus data berhasil', 'success')
                                table.draw()
                            }
                        })
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not deleted', '', 'info')
                    }
                });
            })
        })
    </script>
@endsection
@endsection
