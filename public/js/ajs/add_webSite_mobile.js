$(function() {

    // $('.dropd_helper').on('click', function () {
    //   console.log('h');
    //   $('#add_website_drop').dropdown('toggle');
    // })

    tr_mobile_clone();

});

$(document).ready(function(){
    $('body').on('click', '#btn_delete_mobile', function(e){
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

function tr_mobile_clone() {
    var tr_project_mobile = $('#tr_project_mobile').clone();
    console.log(tr_project_mobile);

    tr_project_mobile.attr('id', $('.rt').length);

    tr_project_mobile.show();
    $('#t_body_mobile').append(tr_project_mobile);
}



$('.add_more_mobile').on('click', function () {

    var tr_project_mobile = $('#tr_project_mobile').clone();
    console.log(tr_project_mobile);

    tr_project_mobile.attr('id', $('.rt').length);
    // tr_project_mobile.children().eq(0).children().attr('id', 'urlId_'+ $('.rttable').length);
    // tr_project_mobile.children().eq(0).children().attr('value', data.projects[i].project_url);

    tr_project_mobile.show();
    $('#t_body_mobile').append(tr_project_mobile);
});
