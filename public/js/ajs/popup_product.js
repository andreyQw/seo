$('.edit_product').on('click', function (e) {
    // var price = Number($("#product_price").val());

    var attributes = $(e.target).data();
    console.log(attributes);
    $('#title').val(attributes.title);
    $('#price').val(attributes.price);
    $('#sku').val(attributes.sku);
    $('#product_form').attr('action', '/product/editProduct/'+attributes.id);
///product/editProduct/1

});

$('#add_new_prod').on('click', function () {
    $('#product_form').attr('action', '/product/addProduct');
});

$(function() {
    setTimeout(function() {
        $('.errors').slideUp("slow");
    }, 4000);
});