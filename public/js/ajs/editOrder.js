$(function() {
    // console.log( "ready!" );

});

function addProject() {

    var tr_project = $('#tr_project').clone();

    tr_project.attr('id', $('.row_table').length);
    tr_project.children().eq(0).children().attr('id', 'urlId_'+ $('.row_table').length);
    tr_project.children().eq(2).children().children('input')
        .attr('id', 'quantity_'+ $('.row_table').length );
    tr_project.children().eq(2).children().children('input')
        .attr('row', $('.row_table').length);

    tr_project.children().eq(2).children().children('input')
        .attr('prod_price', 120);
    tr_project.children().eq(2).children().children('input')
        .attr('proj_id', $('.row_table').length);

    tr_project.children().eq(3).children('span.product')
        .attr('id', 'total_row_'+ $('.row_table').length )
        .text(Number(1) * Number(120));
    tr_project.children().eq(3).children('input').val('new');


    tr_project.show();
    // tr_project.id =
    console.log(tr_project[0].id);

    $('#t_body').append(tr_project);

    console.log($('#t_body tr').length);
}

function submitForm() {
    // alert("Submitted");
    $('#tr_project').remove();
}
// $( "#editOrderForm" ).submit(function( event ) {
//     $('#tr_project').remove();
//     // alert( "Handler for .submit() called." );
//     event.preventDefault();
// });
// $(document).ready(function() {
//     $("#editOrderForm").submit(function () {
//         alert("Submitted");
//     });
// }