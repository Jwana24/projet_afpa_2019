if(document.querySelectorAll('.btn-edit-comment'))
{
    let editButton = document.querySelectorAll('.btn-edit-comment');

    editButton.forEach((button) =>
    {
        if(button.dataset['post'] == 'false')
        {
            button.addEventListener('click', (e) =>
            {
                e.preventDefault();

                let paragraph = document.querySelector('.content-comment'+e.target.dataset['id']);
                let cancelBtn = document.querySelector('.cancel-comment'+e.target.dataset['id']);
                let formEdit = document.querySelector('.form-edit-comment'+e.target.dataset['id']);
                let editTextarea = document.querySelector('.content-comment-edit'+e.target.dataset['id']);

                if(e.target.dataset['toggle'] == 'false')
                {
                    editTextarea.innerText = paragraph.innerText;
                    paragraph.style.display = 'none';
                    cancelBtn.style.display = 'initial';
                    formEdit.style.display = 'initial';
                    e.target.dataset['toggle'] = 'true';
                    
                    e.target.innerText = trans(e.target.dataset['locale'], 'Enregistrer', 'Save');
                }
                else if(e.target.dataset['toggle'] == 'true')
                {
                    let data = new FormData(formEdit);
                    fetch('/'+e.target.dataset['id']+'/edit', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
                        {
                            paragraph.innerText = JSON.parse(promise).content;
                        });

                    formEdit.style.display = 'none';
                    paragraph.style.display = 'block';
                    cancelBtn.style.display = 'none';
                    e.target.dataset['toggle'] = 'false';
                    
                    if(document.body.clientWidth < 415)
                    {
                        e.target.innerText = trans(e.target.dataset['locale'], 'Editer', 'Edit');
                    }
                    else
                    {
                        e.target.innerText = trans(e.target.dataset['locale'], 'Editer le commentaire', 'Edit comment');
                    }
                }

                cancelBtn.addEventListener('click', (f) =>
                {
                    f.preventDefault();
                    cancelBtn.style.display = 'none';
                    e.target.dataset['toggle'] = 'false';
                    
                    if(document.body.clientWidth < 415)
                    {
                        e.target.innerText = trans(e.target.dataset['locale'], 'Editer', 'Edit');
                    }
                    else
                    {
                        e.target.innerText = trans(e.target.dataset['locale'], 'Editer le commentaire', 'Edit comment');
                    }

                    paragraph.style.display = 'block';
                    formEdit.style.display = 'none';
                    editTextarea.value = paragraph.innerText;
                });
            });
        }
        else if(button.dataset['post'] == 'true')
        {
            button.addEventListener('click', (e) =>
            {
                e.preventDefault();

                let paragraph = document.querySelector('.content-comment-post'+e.target.dataset['id']);
                let cancelBtn = document.querySelector('.cancel-comment-post'+e.target.dataset['id']);
                let formEdit = document.querySelector('.form-edit-comment-post'+e.target.dataset['id']);
                let editTextarea = document.querySelector('.content-comment-edit-post'+e.target.dataset['id']);

                if(e.target.dataset['toggle'] == 'false')
                {
                    editTextarea.innerText = paragraph.innerText;
                    paragraph.style.display = 'none';
                    cancelBtn.style.display = 'initial';
                    formEdit.style.display = 'initial';
                    e.target.dataset['toggle'] = 'true';
                    
                    e.target.innerText = trans(e.target.dataset['locale'], 'Enregistrer', 'Save');
                }
                else if(e.target.dataset['toggle'] == 'true')
                {
                    let data = new FormData(formEdit);
                    fetch('/'+e.target.dataset['id']+'/editpost', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
                        {
                            paragraph.innerText = JSON.parse(promise).content;
                        });

                    formEdit.style.display = 'none';
                    paragraph.style.display = 'block';
                    cancelBtn.style.display = 'none';
                    e.target.dataset['toggle'] = 'false';
                    
                    if(document.body.clientWidth < 415)
                    {
                        e.target.innerText = trans(e.target.dataset['locale'], 'Editer', 'Edit');
                    }
                    else
                    {
                        e.target.innerText = trans(e.target.dataset['locale'], 'Editer le commentaire', 'Edit comment');
                    }
                }

                cancelBtn.addEventListener('click', (f) =>
                {
                    f.preventDefault();
                    cancelBtn.style.display = 'none';
                    e.target.dataset['toggle'] = 'false';
                    
                    if(document.body.clientWidth < 415)
                    {
                        e.target.innerText = trans(e.target.dataset['locale'], 'Editer', 'Edit');
                    }
                    else
                    {
                        e.target.innerText = trans(e.target.dataset['locale'], 'Editer le commentaire', 'Edit comment');
                    }

                    paragraph.style.display = 'block';
                    formEdit.style.display = 'none';
                    editTextarea.value = paragraph.innerText;
                });
            });
        }
    });
}