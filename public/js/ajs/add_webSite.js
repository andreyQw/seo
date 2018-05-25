$(function() {
    tr_clone();

});

$(document).ready(function(){
    $('body').on('click', '#btn_delete', function(e){
        e.stopPropagation();
        deleteProjRow(e);
        e.preventDefault();
        // $(document).on('click.bs.dropdown.data-api', '#add_website_drop', function (e) {
        //     e.stopPropagation();
        // });
    });
});

function deleteProjRow(e) {
    $(e.currentTarget).parent().parent().parent().parent().remove();
}

function tr_clone() {
    var tr_project = $('#tr_project').clone();
    console.log(tr_project);

    tr_project.attr('id', $('.row_table').length);

    tr_project.show();
    $('#t_body').append(tr_project);
}



$('.add_more').on('click', function () {

    var tr_project = $('#tr_project').clone();
    console.log(tr_project);

    tr_project.attr('id', $('.row_table').length);
    // tr_project.children().eq(0).children().attr('id', 'urlId_'+ $('.row_table').length);
    // tr_project.children().eq(0).children().attr('value', data.projects[i].project_url);

    tr_project.show();
    $('#t_body').append(tr_project);
});
