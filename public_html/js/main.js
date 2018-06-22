$(document).ready(function(){
    $('[aria-label = "Delete"]').click(function() {
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

