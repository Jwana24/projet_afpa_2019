// let btnEdit = document.querySelector('.btn-edit-comment');

// // // Save the HTML within the p
// // let pHtml = $('#myp').html();
// // // Create a dynamic textarea
// // let editableText = $('<textarea />');
// // // Fill the textarea with the p's text
// // editableText.val(pHtml);
// // // Replace the p with the textarea
// // $('#myp').replaceWith(editableText);
// // editableText.focus();

// $("p").click(() =>
// {
//     let pHtml = $(".text-article-comment").html();
//     let editableText = $("<textarea />");
//     editableText.val(pHtml);
//     $(this).replaceWith(editableText);
//     editableText.focus();
// });

// if existe 
let editButton = document.querySelectorAll('.btn-edit-comment');

editButton.forEach((button) => {
    button.addEventListener('click', (e)  => {
        e.preventDefault();
        let paragraph = document.querySelector('.content-comment'+e.target.dataset['id']);
        let cancelBtn = document.querySelector('.cancel-comment'+e.target.dataset['id']);
        let formEdit = document.querySelector('.form-edit-comment'+e.target.dataset['id']);
        let editTextarea = document.querySelector('.content-comment-edit'+e.target.dataset['id']);

        if(e.target.innerText == 'Editer')
        {
            editTextarea.innerText = paragraph.innerText;
            paragraph.style.display = 'none';

            cancelBtn.style.display = 'initial';

            formEdit.style.display = 'initial';

            e.target.innerText = 'Enregistrer';
        }
        else if (e.target.innerText == 'Enregistrer')
        {
            let data = new FormData(formEdit);
            fetch('/'+e.target.dataset['id']+'/edit', {method: 'POST', body: data}).then(promise => promise.text()).then(promise => 
            {
                paragraph.innerText = JSON.parse(promise).content;
            });

            formEdit.style.display = 'none';
            paragraph.style.display = 'block';
            cancelBtn.style.display = 'none';
            e.target.innerText = 'Editer';
        }

        cancelBtn.addEventListener('click', (f) => {
            f.preventDefault();
            cancelBtn.style.display = 'none';
            e.target.innerText = 'Editer';
            paragraph.style.display = 'block';
            formEdit.style.display = 'none';
            editTextarea.value = paragraph.innerText;
        });
    });
});
 



