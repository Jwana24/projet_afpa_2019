// INSCRIPTION
let formContainerInsc = document.querySelector('form[name=member]');
let messageSuccess = document.querySelector('.alert');

let closeModal = document.querySelector('.cross-close');
let modalInsc = document.querySelector('.modal_inscription');

let btnInsc = document.querySelector('.btn-inscription');

// CONNECTION
let closeModalCo = document.querySelector('.cross-close-co');
let modalCo = document.querySelector('.modal_connection');

let btnCo = document.querySelector('.btn-connection');



// INSCRIPTION

formContainerInsc.addEventListener('submit',(e) =>
{
    e.preventDefault();

    let data = new FormData(e.target);

    fetch('/members/inscription', {method: 'POST', body: data}).then(promise => promise.text()).then(promise => {

        modalInsc.style.display = 'none';

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

closeModal.addEventListener('click', () =>
{
    modalInsc.style.display = 'none';
});

btnInsc.addEventListener('click', (e) =>
{
    e.preventDefault();
    modalCo.style.display = 'none';

    if(modalInsc.style.display == 'none' || modalInsc.style.display == '')
    {
        modalInsc.style.display = 'flex';
    }

    else if(modalInsc.style.display == 'flex')
    {
        modalInsc.style.display = 'none';
    }
});

// window.addEventListener('click', function(e)
// {
//     if(e.target != modalInsc && modalInsc.style.display == 'flex' && e.target != btnInsc)
//     {
//         modalInsc.style.display = 'none';
//     }
// })


// CONNECTION

closeModalCo.addEventListener('click', () =>
{
    modalCo.style.display = 'none';
});

btnCo.addEventListener('click', (e) =>
{
    e.preventDefault();
    modalInsc.style.display = 'none';

    if(modalCo.style.display == 'none' || modalCo.style.display == '')
    {
        modalCo.style.display = 'flex';
    }

    else if(modalCo.style.display == 'flex')
    {
        modalCo.style.display = 'none';
    }
});