let formContainerInsc = document.querySelector('form[name=member]');
let messageSuccess = document.querySelector('.alert');

messageSuccess.style.display = 'none';

formContainerInsc.addEventListener('submit',(e) =>
{
    e.preventDefault();

    let data = new FormData(e.target);

    fetch('/members/inscription', {method: 'POST', body: data}).then(promise => promise.text()).then(promise => {
        for(let i = 0; i <= 7; i++)
        {
            formContainerInsc[i].value = '';
        }

        messageSuccess.style.display = 'flex';
        setTimeout(()=>
        {
            messageSuccess.style.display = 'none';
        }, 5000);
    })
})