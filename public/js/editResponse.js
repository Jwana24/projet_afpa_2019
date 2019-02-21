if(document.querySelectorAll('.btn-edit-response'))
{
    let editButton = document.querySelectorAll('.btn-edit-response');
    
    editButton.forEach((button) => {
        button.addEventListener('click', (e)  => 
        {
            e.preventDefault();
            
            let paragraph = document.querySelector('.content-response'+e.target.dataset['id']);
            let cancelBtn = document.querySelector('.cancel-response'+e.target.dataset['id']);
            let formEdit = document.querySelector('.form-edit-response'+e.target.dataset['id']);
            let editTextarea = document.querySelector('.content-response-edit'+e.target.dataset['id']);
    
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
                fetch('/'+e.target.dataset['id']+'/editresponse', {method: 'POST', body: data}).then(promise => promise.text()).then(promise => 
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
}
 