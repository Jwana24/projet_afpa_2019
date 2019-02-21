if(document.querySelector('.btn-edit-member'))
{
    let editButton = document.querySelector('.btn-edit-member');
    
    editButton.addEventListener('click', (e)  => 
    {
        e.preventDefault();
        
        let infoProfile = document.querySelector('.info-profile'),
            username = document.querySelector('.username-profile'),
            firstName = document.querySelector('.member-firstName'),
            lastName = document.querySelector('.member-lastName'),
            mail = document.querySelector('.member-mail'),
            description = document.querySelector('.member-description'),
            avatar = document.querySelector('.avatar'),
            formEdit = document.querySelector('.form-edit-member'),
            cancelButton = document.querySelector('.cancel-edit-member');
        
        if(e.target.dataset['toggle'] == 'false')
        {
            infoProfile.style.display = 'none';
            formEdit.style.display = 'initial';
            cancelButton.style.display = 'inline-block';

            e.target.dataset['toggle'] = 'true';

            e.target.innerText = trans(e, 'Enregistrer', 'Save');
        }
        else if (e.target.dataset['toggle'] == 'true')
        {
            let data = new FormData(formEdit);

            fetch('/members/'+e.target.dataset['id']+'/edit', {method: 'POST', body: data}).then(promise => promise.text()).then(promise => 
            {
                let member = JSON.parse(promise).content;
                username.innerText = member['username'];
                lastName.innerText = trans(e, 'Nom : ', 'Last name : ') + member['last_name'];
                firstName.innerText = trans(e, 'Prénom : ', 'First name : ') + member['first_name'];
                mail.innerText = trans(e, 'Email : ', 'Mail : ') + member['mail'];
                description.innerText = 'Description : ' + member['description'];
                avatar.src = '/' + member['avatar'];
            });

            infoProfile.style.display = 'initial';
            formEdit.style.display = 'none';
            cancelButton.style.display = 'none';

            e.target.dataset['toggle'] = 'false';

            e.target.innerText = trans(e, 'Editer mon profil', 'Edit profile');
        }
        
        cancelButton.addEventListener('click', (f) => 
        {
            f.preventDefault();
    
            infoProfile.style.display = 'initial';
            formEdit.style.display = 'none';
            cancelButton.style.display = 'none';

            e.target.dataset['toggle'] = 'false';

            e.target.innerText = trans(e, 'Editer mon profil', 'Edit profile');
        }); 
    });
}

function trans(e, a, b)
{
    if(e.target.dataset['locale'] == 'fr_FR')
    {
        return a;
    }
    else if (e.target.dataset['locale'] == 'en')
    {
        return b;
    }
}