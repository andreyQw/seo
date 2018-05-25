$(function() {
    $('.switch_input').on('click', function (e) {
        var input = e.target;
        var id = $(e.target).attr('id');

        if ($(input).prop('checked'))
        {
            $(e.target).attr('value', 'show');
            var status = $(e.target).attr('value');
            $data = {'id':id, 'status': status};
            console.log($data);

            $.ajax({
                url: '/product/editProductStatus',
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id':id,
                    'status': status
                },
                success: function(response) {
                    // alert(response);
                },
                dataType: false
            });
        }
        else
        {
            $(e.target).attr('value', 'hide');
            var status = $(e.target).attr('value');
            $data = {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id':id,
                'status': status
            };
            console.log($data);

            $.ajax({
                url: '/product/editProductStatus',
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id':id,
                    'status': status
                },
                success: function() {
                    // alert("Успешное выполнение hide");
                },
                dataType: false
            });
        }
    });
});