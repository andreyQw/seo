// function change(objName, min, max, step) {
//
//     var obj = $('#'+objName);
//     var qty_input = obj.parent().children('.qty').val();
//     // console.log(qty_input);
//     var tmp = +qty_input + step;
//
//     if (tmp<min) tmp=min;
//     if (tmp>max) tmp=max;
//     obj.val(+tmp);
// }


// $('.bull').on('click', function (e) {
//     console.log('here');
//     var price = Number($("#product_price").val());
//     console.log(price);
//     // console.log(e.target);
//
//     if(e.target.value === "+"){
//         var current_value = Number($(e.currentTarget).children('#quantity').val()) + 1;
//         $(e.currentTarget).children('#quantity').val(current_value);
//
//         var total = Number(price) * Number(current_value);
//         // console.log(total);
//
//         var sss = $(e.currentTarget).parent();
//         $($(sss)[0].nextElementSibling).children('#total_row').text(total);
//     }
//
//     if(e.target.value === "-"){
//         var current_value = Number($(e.currentTarget).children('#quantity').val()) - 1;
//         if(current_value < 1){current_value = 1;}
//         $(e.currentTarget).children('#quantity').val(current_value);
//
//         var total = Number(price) * Number(current_value);
//         var sss = $(e.currentTarget).parent();
//         $($(sss)[0].nextElementSibling).children('#total_row').text(total)
//     }
// });

