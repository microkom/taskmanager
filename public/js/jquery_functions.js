$(document).ready(function () {
    
    /**
    * Retrieve positions according to task
    */
    $("#task").change(function () {
        var task_id = $(this).val();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/task_positions_ajax',
            type: 'post',
            data: { task_id: task_id },
            dataType: 'json',
            
            success: function (response) {
                console.log(response)
                $("#position").empty();
                for (var i = 0; i < response.length; i++) {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    $("#position").append("<option value='" + id + "'>" + name + "</option>");
                }
            }
        });
    });
    
    $(document).ready(function () {
        $('#tabla_hoy').DataTable();
    });
    /**
    * Assign class 'active' to active button by capturing the current url '/assigntask'
    */
    /* var path = window.location.pathname.substring(1)
    $('#' + path).addClass('active');
     */
});