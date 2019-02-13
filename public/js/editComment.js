let btnEdit = document.querySelector('.btn-edit-comment');

// // Save the HTML within the p
// let pHtml = $('#myp').html();
// // Create a dynamic textarea
// let editableText = $('<textarea />');
// // Fill the textarea with the p's text
// editableText.val(pHtml);
// // Replace the p with the textarea
// $('#myp').replaceWith(editableText);
// editableText.focus();

$("p").click(() =>
{
    let pHtml = $(".text-article-comment").html();
    let editableText = $("<textarea />");
    editableText.val(pHtml);
    $(this).replaceWith(editableText);
    editableText.focus();
});