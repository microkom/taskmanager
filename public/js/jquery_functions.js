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

$(document).on('click', 'td.editable', function (e) {
    var count = 0
    var form = $('.form_delete')
    if (count < 1) {
        $(this).find('.pos_input').removeAttr('disabled').css('border', '1px solid lightgray').css('border-radius', '3px ')
        $(this).parent().find('.btn').show();
        count++;
    } else {
        
    }
})
$(document).on('click', '.save', function (e) {  
    /* Save button, works for updating or saving a new position*/
    
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
            cancel()
        }
    });
    
})    

$(document).on('click', '.delete', function (e) {
    try {
        e.preventDefault()
        var form = $(this).parent()
        console.log(form)
        swal({
            title: "ADVERTENCIA",
            text: "Borrar esta entrada puede causar que la base de datos deje de funcionar, está seguro de querer borrarla?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willSave) => {
            try {
                if (willSave) {
                    form.submit()
                    
                } else {
                    cancel()
                }
            } catch (err) {
                console.log(err)
            }
        });
    } catch (er) {
        console.log(er)
    }
})

function cancel() {
    $('table').find('.pos_input').removeAttr('style').prop('disabled', 'disabled')
    $('table').find('.save').hide();
    $('table').find('.delete').hide();
}

$(document).on('click', '.delete_assigned_task', function (e) {
    try {
        e.preventDefault()
        let id = $(this).parent().find('.task_id').val()
        let link = "/assignTask/delete/"+id
        console.log(link)
       swal({
            title: "ADVERTENCIA",
            text: "Al borrar este registro el sistema no reasignará otra persona para dicha tarea, desea continuar?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willSave) => {
                try {
                    if (willSave) {
                        window.location.href = link

                    } else {
                        cancel()
                    }
                } catch (err) {
                    console.log(err)
                }
            });
    } catch (er) {
        console.log(er)
    }
})
/* $(document).mouseup(function (e) {
    var container = $("#tabla_hoy"); // YOUR CONTAINER SELECTOR

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        cancel()
    }
}); */
$(document).on(
    'keydown', function (event) {
        if (event.key == "Escape") {
            cancel()
        }
    }); 