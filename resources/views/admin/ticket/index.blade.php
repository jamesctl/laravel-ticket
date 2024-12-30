@php
    use App\Enums\Ticket as eTicket;
@endphp
@section('title')
    {{ trans('general.ticket') }}
@stop
@extends('admin.general.master')
@section('content')
    @include('admin.ticket.components.modalEdit')
    <!-- BEGIN: Content-->
    <!-- BEGIN: Content-->
    <section class="app-content content">
        <div class="content-overlay"></div>
        <section class="content-wrapper">
            <section class="content-body">
                <!-- users list start -->
                <section class="users-list-wrapper">
                    <div class="users-list-filter px-1">
                        <div class="users-list-table">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-header">
                                        <div class="content-header row">
                                            <h3>{{ trans('general.list') }} {{ trans('general.ticket') }}</h3>
                                        </div>
                                        {{ html()->form('GET', 'ticket')->class('form-horizontal')->open() }}
                                        <div class="row border rounded py-2 mb-2">
                                            <div class="col-12 col-sm-6 col-lg-3">
                                                <label for="users-list-verified">{{ trans('general.search') }} <span>{{LANGUAGE}}</span></label>
                                                <input type="text" name="title" class="form-control" value="{{ isset($param['title']) ? $param['title'] : '' }}">
                                            </div>

                                            <div class="col-12 col-sm-6 col-lg-3">
                                                <label for="users-list-status">{{ trans('general.status') }}</label>
                                                <fieldset class="form-group">
                                                    <select class="form-control" id="users-list-status" name="status">
                                                        <option value="">{{ trans('general.any') }}</option>
                                                        <option value={{eTicket::IS_PROCESSING}} @if (isset($param['status']) && $param['status'] == eTicket::IS_PROCESSING) selected="selected" @endif>
                                                            {{ trans('general.processing') }}</option>

                                                        <option value={{eTicket::IS_COMPLETE}}
                                                                @if (isset($param['status']) && $param['status'] == eTicket::IS_COMPLETE) selected="selected" @endif>
                                                            {{ trans('general.complete') }}</option>

                                                        <option value={{eTicket::CLOSE}}
                                                            @if (isset($param['status']) && $param['status'] == eTicket::CLOSE) selected="selected" @endif>
                                                            {{ trans('general.close') }}</option>

                                                    </select>
                                                </fieldset>
                                            </div>

                                            <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
                                                <button type="submit"
                                                        class="btn btn-primary btn-block glow users-list-clear mb-0">{{ trans('general.search') }}</button>
                                            </div>
                                        </div>
                                        {{ html()->form()->close() }}
                                    </div>
                                    <div class="card-body">
                                        <!-- datatable start -->
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <td>#id</td>
                                                        <td>{{ trans('general.title') }}</td>
                                                        <td style="min-width: 150px;">{{ trans('general.date') }}</td>
                                                        <td>{{ trans('general.customer_name') }}</td>
                                                        <td>{{ trans('general.admin_name') }}</td>
                                                        <td class="text-center">{{ trans('general.status') }}</td>
                                                        <td>{{ trans('general.action') }}</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @foreach ($items as $item) --}}
                                                        {{-- <tr>
                                                            <td><a
                                                                    href="{{ route('admin.ticket.show', $item->id) }}">{{ $item->id }}</a>
                                                            </td>
                                                            <td>{{$item->title}}</td>
                                                            <td class="col-md-8">{{ Carbon::parse($item->created_at)->format('y-m-d') }}</td>
                                                            <td>{{$item->customer->name}}</td>
                                                            <td>{{ auth()->user()->name }}</td>

                                                            <td class="text-center">{{ $item->status }}</td>

                                                            <td>
                                                                @if(checkPermission('admin.ticket.edit'))
                                                                    <a href="{{ route('admin.ticket.edit', $item->id) }}"><i
                                                                            class="bx bx-edit-alt"></i>
                                                                    </a>
                                                                @endif
                                                                @if(checkPermission('admin.ticket.destroy'))
                                                                    {{ html()->form('delete', route('admin.ticket.destroy', $item->id))->class('d-inline')->open() }}
                                                                    <button class="btn text-danger confirm-button p-0"><i
                                                                            class="bx bx-x"></i></button>
                                                                @endif
                                                                {{ html()->form()->close() }}
                                                            </td>
                                                        </tr> --}}
                                                    {{-- @endforeach --}}
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- @if (!request()->ajax())
                                        <div class="pagination pull-right">{!! $items->render() !!}</div>
                                        @endif --}}

                                        <!-- datatable ends -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
                <!-- users list ends -->
            </section>
        </section>
    </section>
{{--@endsection--}}

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                paging: true,
                ajax: {
                    url: "{{ route('admin.ticket.index') }}",
                    type: "GET",
                    data: function(d) {
                        d.status = '{{ request()->status }}';
                        d.title = '{{ request()->title }}';
                    },
                    error: function(xhr, error, code) {
                        console.error("AJAX Error: " + error);
                        console.log(xhr.responseText);  // Log the response for debugging
                    }
                },
                language: {
                    // "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Vietnamese.json"
                },
                columns: [
                    { data: 'id',
                        render: function(data, type, row) {
                            return '<a href="/admin/ticket/' + data + '">' + data + '</a>';
                        }
                    },
                    { data: 'title' },
                    { data: 'created_at' },
                    { data: 'customer_name' },
                    { data: 'user_name' },
                    { data: 'status' },
                    { data: "actions", "orderable": false, "searchable": false }
                ],

                language: {
                    paginate : {
                        "first": '<button class="btn btn-info"><i class="fa fa-angle-double-left"></i> First</button>',
                        "previous": '<button class="btn btn-success"><i class="fa fa-arrow-left"></i> Previous</button>',
                        "next": '<button class="btn btn-success">Next <i class="fa fa-arrow-right"></i></button>',
                        "last": '<button class="btn btn-info">Last <i class="fa fa-angle-double-right"></i></button>',
                        "page": function(pageNumber) {
                            return '<button class="datatable-button-abc btn btn-info">Page ' + (pageNumber + 1) + '</button>';
                        }
                    }
                },
                pagingType: 'full_numbers'
            });
        });

        function openEditModal(id) {
            const url = `{{ route('admin.ticket.showEdit', ':id') }}`.replace(':id', id);

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    // Dropdown
                    const userDropdown = $('#modalUserList');
                    userDropdown.empty(); // Clear existing options
                    const usersArray = Object.keys(response.users).map(id => ({
                        id: id,
                        name: response.users[id]
                    }));
                    // console.log(response.ticket.user_id);
                    usersArray.forEach(user => {
                        const selected = response.ticket.user_id == user.id ? 'selected' : '';
                        userDropdown.append(`<option value="${user.id}" ${selected}>${user.name}</option>`);
                    });

                    // Status
                    if (['New', 'Complete', 'Processing', 'Close'].includes(response.ticket.status)) {
                        $('#statusTicketSelect').val(response.ticket.status);
                    } else {
                        // Set to a default value if no match
                        $('#statusTicketSelect').val('New');
                    }

                    // input
                    $('#ticket_id').val(response.ticket.id);

                    // Show modal
                    $('#editModal').modal('show');
                },
                error: function(error) {
                    console.log("Error fetching modal content", error);
                }
            });
        }

    </script>
@endpush

@push('css')
    <style>
        /* Pagination button style */
        /* .dataTables_wrapper .dataTables_paginate .paginate_button { */
        .dataTables_wrapper .dataTables_paginate .paginate_button:not(.first):not(.last):not(.previous):not(.next) {
            margin-right: 4px;  /* Space between buttons */
            padding: 2px 5px;   /* Padding inside the buttons */
            border-radius: 4px;  /* Optional: rounded buttons */
            cursor: pointer; 
            background-color: #dcdcdc;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            margin-right: 1px;  /* Space between buttons */
            padding: 2px 5px;   /* Padding inside the buttons */
            border-radius: 4px;  /* Optional: rounded buttons */
            cursor: pointer; 
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            /* background-color: #dcdcdc;  Optional: hover effect */
        }

        /* Customize First and Last buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button.first,
        .dataTables_wrapper .dataTables_paginate .paginate_button.last {
            font-weight: bold;
        }


    </style>
@endpush

