if(document.querySelectorAll('.btn-edit-response'))
{
    let editButton = document.querySelectorAll('.btn-edit-response');

    editButton.forEach((button) =>
    {
        if(button.dataset['post'] == 'false')
        {
            button.addEventListener('click', (e) =>
            {
                e.preventDefault();

                let paragraph = document.querySelector('.content-response'+e.target.dataset['id']);
                let cancelBtn = document.querySelector('.cancel-response'+e.target.dataset['id']);
                let formEdit = document.querySelector('.form-edit-response'+e.target.dataset['id']);
                let editTextarea = document.querySelector('.content-response-edit'+e.target.dataset['id']);

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
                    fetch('/'+e.target.dataset['id']+'/editresponse', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
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
                        e.target.innerText = trans(e.target.dataset['locale'], 'Editer la réponse', 'Edit response');
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
                        e.target.innerText = trans(e.target.dataset['locale'], 'Editer la réponse', 'Edit response');
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

                let paragraph = document.querySelector('.content-response-post'+e.target.dataset['id']);
                let cancelBtn = document.querySelector('.cancel-response-post'+e.target.dataset['id']);
                let formEdit = document.querySelector('.form-edit-response-post'+e.target.dataset['id']);
                let editTextarea = document.querySelector('.content-response-edit-post'+e.target.dataset['id']);

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
                    fetch('/'+e.target.dataset['id']+'/editresponsepost', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
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
                        e.target.innerText = trans(e.target.dataset['locale'], 'Editer la réponse', 'Edit response');
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
                        e.target.innerText = trans(e.target.dataset['locale'], 'Editer la réponse', 'Edit response');
                    }

                    paragraph.style.display = 'block';
                    formEdit.style.display = 'none';
                    editTextarea.value = paragraph.innerText;
                });
            });
        }
    });
}