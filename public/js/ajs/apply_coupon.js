// var action = $(selector).data('action');
// var email = $(selector).attr('data-email-id');
//
// $(function() {
//
//     var discount_type; //discount_type(discount_id) 1->%, 2->$
//     var discount;
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//
//     $('#btn-my').on('click', function() {
//         //First Order
//         var coupon = $('#coupon').val();
//
//         $.ajax({
//             type: "GET",
//             url: '/getCoupon/'+coupon,
//             success: function(data) {
//                 discount_type = data.discount_id;
//                 discount = data.amount;
//                 console.log(data);
//             },
//             error: function (er) {
//                 console.log(er);
//             }
//         });
//         return false;
//     });
// });