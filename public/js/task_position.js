$(document).ready(function(){

    $("#task").change(function(){
        var task_id = $(this).val();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/positions_ajax',
            type: 'post',
            data: { task_id : task_id },
            dataType: 'json',
            
            success:function(response){
                console.log(response)
                $("#position").empty();
                for( var i = 0; i< response.length; i++){
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    $("#position").append("<option value='"+id+"'>"+name+"</option>");
                }
            }
        });
    });
});