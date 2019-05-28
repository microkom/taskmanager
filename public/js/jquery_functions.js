$(document).ready(function () {
    
    /**
    * Retrieve positions according to task
    */
    $("#task_assign_task").change(function () {
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
                
                $("#position_assign_task").empty();
                for (var i = 0; i < response.length; i++) {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    $("#position_assign_task").append("<option value='" + id + "'>" + name + "</option>");
                }
            }
        });
    });
    
    
    /**
    * Assign class 'active' to active button by capturing the current url '/assigntask'
    */
    
 /*    if ($($('span#position-index-blade').length)){
        $('#btn-set-pos').addClass('active')
    }

     */
});

$(document).ready(function () {
    $('#tabla_hoy').DataTable();
});


/* POSITION index.blade functions for buttons and forms */

/* Click to Edit the position and show SAVE and DELETE buttons */
$(document).ready(function () {
    var count = 0
    $('td.editable').click(function () {
        
        if (count < 1) {
            $(this).find('.pos_input').removeAttr('disabled').css('border', '1px solid lightgray').css('border-radius', '3px ')
            $(this).parent().find('.btn').show();
            count++;
        } else {
            
        }
    });
    
    /* Save button, works for updating or saving a new position*/
    $('.save').click(function (e) {
        e.preventDefault()
        var form = $(this).parents('form');
        swal({
            title: "Guardar",
            text: "Desea guardar esta entrada?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willSave) => {
            if (willSave) {
                form.submit();
            } else {
                $(this).parent().parent().parent().find('.pos_input').removeAttr('style').prop('disabled', 'disabled')
                $(this).parent().parent().parent().find('.btn').hide();
            }
        });
    })
    
    /* Delete button */
    $('.delete').on('click', function (e) {
        try {
            e.preventDefault()
            var form = $(this).parents('form');
            swal({
                title: "Borrar",
                text: "Desea borrar esta entrada?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willSave) => {
                try {
                    if (willSave) {
                        form.submit();
                        
                    } else {
                        $(this).parent().parent().parent().find('.pos_input').removeAttr('style').prop('disabled', 'disabled')
                        $(this).parent().parent().parent().find('.btn').hide();
                    }
                } catch (err) {
                    console.log(err)
                }
            });
        } catch (er) {
            console.log(er)
        }
    })
    
})