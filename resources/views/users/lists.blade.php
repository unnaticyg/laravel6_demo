@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Users <span style="float:right"><a href="{{route('users.create')}}">Add New User</a><span></div>

                <div class="card-body">
                    <table style="font-size:13px;" class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script src="{{ URL::asset('js/jquery.js') }}"></script>  
<script type="text/javascript">
  $(function () {
        $(document).ready( function () {
            $.noConflict();
            var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'full_name', name: 'full_name',orderable: false},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "order": [[1, 'asc']],
            "autoWidth": true,
        });
    }); 
  });
</script>