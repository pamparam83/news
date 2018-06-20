$(document).ready(function(){
//     $('#modal').click(function(){
//         $.ajax({
//             url: '/user',
//             success: function(data){
//                 $('#user').html(data);
//             }
//         });
//     });
//     $('#modalUser').on('click','[aria-label = "View"]',function() {
//         let id = $(this).closest('tr').data('key');
//         // alert(id);
//         $.ajax({
//             url: '/user/view',
//             data: {'id': id},
//             type: "GET",
//             success: function(data){
//                 $('#user').html(data);
//             }
//         });
//         return false;
//     });
//     $('#modalUser').on('click','[aria-label = "Update"]',function() {
//         let id = $(this).closest('tr').data('key');
//         if(id === undefined){
//             id = $(this).data('key');
//         }
//         $.ajax({
//             url: '/user/update',
//             data: {'id': id},
//             type: "POST",
//             success: function(data){
//                 $('#user').html(data);
//             }
//         });
//         return false;
//     });
//     $('#modalUser').on('click','#delete',function() {
//         if(confirm('Are you sure you want to delete this item?')) {
//             let id = $(this).data('delete');
//             $.ajax({
//                 url: '/user/delete',
//                 data: {'id': id},
//                 type: "POST",
//                 success: function (data) {
//                     $('#user').html(data);
//                 }
//             });
//         }
//         return false;
//     });
//     $('#modalUser').on('click','[aria-label = "Delete"]',function() {
//         if(confirm('Are you sure you want to delete this item?')){
//             let id = $(this).closest('tr').data('key');
//             $.ajax({
//                 url: '/user/delete',
//                 data: {'id': id},
//                 type: "POST",
//                 success: function(data){
//                     $('#user').html(data);
//                 }
//             });
//         }
//         return false;
//     });
//
//     $('#modalUser').on('click','#user-save',function(){
//         let form = $(this).closest('form').serialize(),
//             id = $('#usercreateform-id').val(),
//             url = (id === '') ? '/user/create' : '/user/update';
//
//         $.ajax({
//             url: url,
//             data: form,
//             type: "POST",
//             success: function(data){
//                 $('#user').html(data);
//             }
//         });
//         return false;
//     });
//     $('#modalUser').on('click','#user-link',function(){
//         $.ajax({
//             url: '/user/index',
//             type: "GET",
//             success: function(data){
//                 $('#user').html(data);
//             }
//         });
//         return false;
//     });
//     $('#modalUser').on('click','#user-view',function(){
//         id = $(this).data('key');
//         $.ajax({
//             url: '/user/view',
//             data: {'id': id},
//             type: "GET",
//             success: function(data){
//                 $('#user').html(data);
//             }
//         });
//         return false;
//     });
//     $('#modalUser').on('click','#create',function(){
//         $.ajax({
//             url: '/user/create',
//             type: "GET",
//             success: function(data){
//                 $('#user').html(data);
//             }
//         });
//         return false;
//     });
//
//     $('#modalUser').on('click','.filters',function(){
//         // $(':input').change(function(){
//         //         var test = [];
//         //     $(':input').each(function(i, input) {
//         //             test.push($(input).val());
//         //         });
//         //
//         //         alert(test);
//
//
//         // $.ajax({
//         //     url: '/user/create',
//         //     type: "GET",
//         //     success: function(data){
//         //         $('#user').html(data);
//         //     }
//         // });
//         return false;
//         // });
//     });

    $('[aria-label = "Delete"]').click(function() {
        alert(2);
        if(confirm('Are you sure you want to delete this item?')){
            let url = $(this).attr('href');
            $.ajax({
                url: url,
                type: "POST",
                success: function(data){
                    alert(data);
                }
            });
            return false;
        }

    });
    $('.create').click(function(){
        $('#modal').modal('show')
            .find('#modelContent')
            .load($(this).attr('value'));
        return false;
    });

    $('[aria-label = "Update"]').click(function() {
        $('#modal').modal('show')
            .find('#modelContent')
            .load($(this).attr('href'));
        return false;
    });

    $(document).on('click','.activeNews',function(){
        let id = $(this).closest('tr').data('key'),
             td = $(this).closest('td');
        if(id === undefined){
            return false;
        }
            $.ajax({
                url: '/manager/news/draft',
                data: {'id': id},
                type: "POST",
                success: function(){
                    td.html('<span class="label label-default draft">Draft</span>');
                }
            });
        return false;
    });
    $(document).on('click','.draft',function(){
        let id = $(this).closest('tr').data('key'),
            td = $(this).closest('td');
        if(id === undefined){
            return false;
        }
        $.ajax({
            url: '/manager/news/activate',
            data: {'id': id},
            type: "POST",
            success: function(){
                td.html('<span class="label label-success activeNews">Active</span>');

            }
        });
        return false;
    });
});

