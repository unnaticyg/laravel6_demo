@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Users <span style="float:right"><a href="{{route('users.create')}}">Add New User</a><span></div>

                <div class="card-body">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>First Name</th>
                                <th>Last Name</th>
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
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    }); 
    $(document).on('click', '.delete-user', function(){
        var user_id = $(this).data("id");
        var r = confirm("Are You sure want to delete ?");
        if (r == true) {
            $.ajax({
                type: "GET",
                url: "users/destroy/"+user_id,
                success: function (data) {
                var oTable = $('.data-table').dataTable(); 
                oTable.fnDraw(false);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
        })
  });
</script>