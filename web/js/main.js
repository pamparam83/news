$(document).ready(function(){
    $('#modal').click(function(){
        $.ajax({
            url: '/user',
            success: function(data){
                $('#user').html(data);
            }
        });
    });
    $('#modalUser').on('click','[aria-label = "View"]',function() {
        let id = $(this).closest('tr').data('key');
        // alert(id);
        $.ajax({
            url: '/user/view',
            data: {'id': id},
            type: "GET",
            success: function(data){
                $('#user').html(data);
            }
        });
        return false;
    });
    $('#modalUser').on('click','[aria-label = "Update"]',function() {
        let id = $(this).closest('tr').data('key');
        if(id === undefined){
            id = $(this).data('key');
        }
        $.ajax({
            url: '/user/update',
            data: {'id': id},
            type: "GET",
            success: function(data){
                $('#user').html(data);
            }
        });
        return false;
    });
    $('#modalUser').on('click','#user-save',function(){
        let form = $(this).closest('form').serialize(),
            id = $(this).data('id');
        $.ajax({
            url: '/user/update',
            data: "id="+ id + "&"+form,
            type: "POST",
            success: function(data){
                $('#user').html(data);
            }
        });
        return false;
    });
});