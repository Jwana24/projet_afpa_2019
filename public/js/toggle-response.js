let btnResponse = document.querySelectorAll('.response-btn');

let containerFormResponse = document.querySelector('.contain-form-response');

containerFormResponse.style.display = 'none';

form = false;

btnResponse.forEach((bouton)=>{
    bouton.addEventListener('click',(e)=>{
        e.preventDefault();
        if(form)
        {
            containerFormResponse.style.display = 'none';
            form = false;
        }
        else
        {
            containerFormResponse.style.display = 'block';
            document.querySelector('input[name=id_comment]').value = e.target.dataset['id'];
            containerFormResponse.remove();

            let containResponse = document.querySelector('.contain-response' + e.target.dataset['id']);
            containResponse.appendChild(containerFormResponse);
            form = true;

            window.scrollTo(0, containResponse.offsetTop - 500);
        }
    })

})