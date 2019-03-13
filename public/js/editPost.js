if(document.querySelector('.btn-edit-post'))
{
    let editButton = document.querySelector('.btn-edit-post');

    editButton.addEventListener('click', (e) =>
    {
        e.preventDefault();

        let title = document.querySelector('.title-post'),
            text = document.querySelector('.text-post'),
            formEdit = document.querySelector('.form-edit-post'),
            cancelButton = document.querySelector('.cancel-post');
        
        if(e.target.dataset['toggle'] == 'false')
        {
            title.style.display = 'none';
            text.style.display = 'none';
            formEdit.style.display = 'initial';
            cancelButton.style.display = 'inline-block';
            e.target.dataset['toggle'] = 'true';
            e.target.innerText = trans(e.target.dataset['locale'], 'Enregistrer', 'Save');
        }
        else if(e.target.dataset['toggle'] == 'true')
        {
            let data = new FormData(formEdit);
            
            fetch('/forum/'+e.target.dataset['id']+'/editpost', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
            {
                let post = JSON.parse(promise).content;

                title.innerText = post['title'];
                text.innerText = post['text'];
            });

            title.style.display = '';
            text.style.display = '';
            formEdit.style.display = 'none';
            cancelButton.style.display = 'none';
            e.target.dataset['toggle'] = 'false';

            if(document.body.clientWidth < 415)
            {
                e.target.innerText = trans(e.target.dataset['locale'], 'Editer', 'Edit');
            }
            else
            {
                e.target.innerText = trans(e.target.dataset['locale'], 'Editer le post', 'Edit post');
            }
        }

        cancelButton.addEventListener('click', (f) =>
        {
            f.preventDefault();

            title.style.display = '';
            text.style.display = '';
            formEdit.style.display = 'none';
            cancelButton.style.display = 'none';
            e.target.dataset['toggle'] = 'false';
            
            if(document.body.clientWidth < 415)
            {
                e.target.innerText = trans(e.target.dataset['locale'], 'Editer', 'Edit');
            }
            else
            {
                e.target.innerText = trans(e.target.dataset['locale'], 'Editer le post', 'Edit post');
            }
        });
    })
}