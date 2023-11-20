@extends('backend.layouts.app')

@section('title')
    Content
@endsection

@section('page-breadcumb')
    Content
@endsection

@section('page-section')
    Data
@endsection

@section('after-main-style')
    <link rel="stylesheet" href="{{ asset('argon/assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('argon/assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('argon/assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}" />
@endsection

@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="mb-0">Master Content</h3>
                <button type="button" class="btn btn-primary" id="btn-add-modal" data-toggle="modal"
                    data-target="#createModal">Add
                    Content</button>
            </div>

            <div class="table-responsive py-4">
                <table class="table table-flush" id="datatable">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Page</th>
                            <th>Language</th>
                            <th>Section</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Data Language</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="form-control-label">
                            Page
                        </label>
                        <select name="addPage" id="addPage" class="form-control text-dark">
                            <option value="">-- Select Pages --</option>
                            @foreach ($pages as $page)
                                <option value="{{ $page->id }}">{{ $page->page_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-control-label">
                            Language
                        </label>
                        <select name="addLang" id="addLang" class="form-control text-dark">
                            <option value="">-- Select Languages --</option>
                            @foreach ($langs as $lang)
                                <option value="{{ $lang->id }}">{{ $lang->language }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-control-label">
                            Section
                        </label>
                        <select name="addSection" id="addSection" class="form-control text-dark" disabled>
                            <option value="">-- Select Sections --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-control-label">
                            Title
                        </label>
                        <input type="text" class="form-control text-dark" name="addTitle" id="addTitle" disabled>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-control-label">
                            Content
                        </label>
                        <input type="text" class="form-control text-dark" name="addContent" id="addContent" disabled>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-save-add">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Language</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="form-control-label">
                            Code
                        </label>
                        <input type="hidden" name="editId" id="editId">
                        <input type="text" class="form-control text-dark" name="editCode" id="editCode">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-control-label">
                            Language
                        </label>
                        <input type="text" class="form-control text-dark" name="editLanguage" id="editLanguage">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-save-edit">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after-main-script')
    <script src="{{ asset('argon/assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('argon/assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('argon/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('argon/assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('argon/assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('argon/assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('argon/assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('argon/assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                ajax: "{{ route('backend.content.index') }}",
                columns: [{
                        data: "id",
                        render: function(data, type, row, meta) {
                            return meta.row + 1
                        }
                    },
                    {
                        data: "page_name",
                        name: "page_name"
                    },
                    {
                        data: "language",
                        name: "language"
                    },
                    {
                        data: "section",
                        name: "section"
                    },
                    {
                        data: "title",
                        name: "title"
                    },
                    {
                        data: "content_value",
                        name: "content_value"
                    },
                    {
                        data: "id",
                        render: function(data, type, row, meta) {
                            let html = "<button class='btn btn-success btn-edit' data-id='" +
                                data +
                                "'>Edit</button>";

                            html += "<button class='btn btn-danger btn-delete' data-id='" +
                                data +
                                "'>Delete</button>";
                            return html;
                        }
                    }
                ]
            });

            $('#btn-add-modal').click(function(e) {
                $('#addSection option').remove();
                addSectionOption("-- Select Sections --", "");
                $('#addSection').attr('disabled', true);
                $('#addTitle').attr('disabled', true);
                $('#addContent').attr('disabled', true);
                $('#addTitle').val('');
                $('#addContent').val('');
                $('#addPage').val('');
                $('#addLang').val('');
            });

            $('#btn-save-add').click(function(e) {
                var page = $('#addPage').val();
                var lang = $('#addLang').val();
                var section = $('#addSection').val();
                var title = $('#addTitle').val();
                var content = $('#addContent').val();
                if (page == "" || lang == "" || section == "" || title == "" || content == "") {
                    $('#createModal').modal('hide');
                    Swal.fire({
                        icon: "error",
                        title: "Warning",
                        text: "Please fill the field",
                        timer: 3000
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('backend.content.store') }}",
                        data: {
                            'page_id': page,
                            'lang_id': lang,
                            'title': title,
                            'section': section,
                            'content': content,
                            '_token': "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(resp) {
                            $('#createModal').modal('hide');
                            if (resp.code == 200) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    text: resp.message,
                                    timer: 3000
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Warning",
                                    text: resp.message,
                                    timer: 3000
                                });
                            }
                            table.ajax.reload();
                        }
                    });
                }
            });

            var DTbody = $('#datatable tbody');

            DTbody.on('click', '.btn-delete', function() {
                var id = $(this).data("id");
                $.ajax({
                    type: "GET",
                    url: "{{ route('backend.lang.destroy') }}",
                    data: {
                        "id": id
                    },
                    success: function(resp) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: resp.message,
                            timer: 3000
                        });
                        table.ajax.reload();
                    }
                });
            });

            DTbody.on('click', '.btn-edit', function() {
                var id = $(this).data("id");
                $.ajax({
                    type: "GET",
                    url: "{{ route('backend.lang.edit') }}",
                    data: {
                        "id": id
                    },
                    success: function(resp) {
                        $('#editModal').modal('show');
                        $('#editId').val(resp.data.id);
                        $('#editCode').val(resp.data.code);
                        $('#editLanguage').val(resp.data.language);
                    }
                });
            });

            $('#btn-save-edit').click(function(e) {
                var id = $('#editId').val();
                var code = $('#editCode').val();
                var language = $('#editLanguage').val();
                if (code == "" || language == "") {
                    $('#editModal').modal('hide');
                    Swal.fire({
                        icon: "error",
                        title: "Warning",
                        text: "Please fill the field",
                        timer: 3000
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('backend.lang.update') }}",
                        data: {
                            "id": id,
                            "code": code,
                            "language": language,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(resp) {
                            $('#editModal').modal('hide');
                            if (resp.code == 200) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    text: resp.message,
                                    timer: 3000
                                });
                                table.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Warning",
                                    text: resp.message,
                                    timer: 3000
                                });
                            }
                        }
                    });
                }
            });

            $('#addPage').change(function() {
                if ($(this).val() != "") {
                    $('#addSection').removeAttr('disabled');
                    $('#addTitle').attr('disabled', true);
                    $('#addContent').attr('disabled', true);
                    $('#addTitle').val('');
                    $('#addContent').val('');
                    $.ajax({
                        type: "GET",
                        url: "{{ route('backend.content.index') }}",
                        data: {
                            "page_id": $(this).val()
                        },
                        success: function(resp) {
                            $('#addSection option').remove();
                            addSectionOption("-- Select Sections --", "");
                            data = resp.data;
                            data.forEach(element => {
                                addSectionOption(element.section, element.id);
                            });
                        }
                    });
                } else {
                    $('#addSection option').remove();
                    addSectionOption("-- Select Sections --", "");
                    $('#addSection').attr('disabled', true);
                    $('#addTitle').attr('disabled', true);
                    $('#addContent').attr('disabled', true);
                    $('#addTitle').val('');
                    $('#addContent').val('');
                }
            });

            function addSectionOption(text, value) {
                var o = new Option(text, value);
                $(o).html(text);
                $('#addSection').append(o);
            }

            $('#addSection').change(function() {
                if ($(this).val() != "") {
                    $('#addTitle').removeAttr('disabled');
                    $('#addContent').removeAttr('disabled');
                    $('#addTitle').val('');
                    $('#addContent').val('');
                } else {
                    $('#addTitle').attr('disabled', true);
                    $('#addContent').attr('disabled', true);
                    $('#addTitle').val('');
                    $('#addContent').val('');
                }
            });
        });
    </script>
@endsection
