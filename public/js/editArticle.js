if(document.querySelector('.btn-edit-article'))
{
    let editButton = document.querySelector('.btn-edit-article');

    editButton.addEventListener('click', (e) =>
    {
        e.preventDefault();

        let image = document.querySelector('.image'),
            title = document.querySelector('.title-article'),
            text = document.querySelector('.text-article'),
            formEdit = document.querySelector('.form-edit-article'),
            cancelButton = document.querySelector('.cancel-article');
        
        // Depending to the data-set in the html page (edit.html.twig)
        if(e.target.dataset['toggle'] == 'false')
        {
            title.style.display = 'none';
            text.style.display = 'none';
            formEdit.style.display = 'initial';
            cancelButton.style.display = 'inline-block';
            e.target.dataset['toggle'] = 'true';
            e.target.innerText = trans(e.target.dataset['locale'], 'Enregistrer', 'Save'); // a custom function to translate the word on the button
        }
        else if(e.target.dataset['toggle'] == 'true')
        {
            let data = new FormData(formEdit); // Instantiate formData object with the formEdit in parameters
            
            // Make an Ajax request on the edit article page, we spend data of the form, we return a promise (a tool for managing asynchronous operations)
            fetch('/admin/article/'+e.target.dataset['id']+'/edit', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
            {
                let article = JSON.parse(promise).content; // In the variable 'article' we stock data from the edit article

                image.src = '/' + article['image'];
                title.innerText = article['title'];
                text.innerText = article['text'];
            });

            title.style.display = '';
            text.style.display = '';
            formEdit.style.display = 'none';
            cancelButton.style.display = 'none';
            e.target.dataset['toggle'] = 'false';
            e.target.innerText = trans(e.target.dataset['locale'], 'Editer l\'article', 'Edit article');
        }

        cancelButton.addEventListener('click', (f) =>
        {
            f.preventDefault();

            title.style.display = '';
            text.style.display = '';
            formEdit.style.display = 'none';
            cancelButton.style.display = 'none';
            e.target.dataset['toggle'] = 'false';
            e.target.innerText = trans(e.target.dataset['locale'], 'Editer l\'article', 'Edit article');
        });
    })
}