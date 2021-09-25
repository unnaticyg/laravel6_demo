/*$(document).on('ready', function () {
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
});*/
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
});