let btnResponse = document.querySelectorAll('.response-btn');

let containerFormResponse = document.querySelector('.contain-form-response');

containerFormResponse.style.display = 'none';

form = false;

// One form for all the responses : depending on the 'response button', the form move
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
            document.querySelector('input[name=id_comment]').value = e.target.dataset['id']; // bound the response to the comment
            containerFormResponse.remove();

            let containResponse = document.querySelector('.contain-response' + e.target.dataset['id']);
            containResponse.appendChild(containerFormResponse); // the form is bound to the associated response
            form = true;

            window.scrollTo(0, containResponse.offsetTop - 500); // when the form appeard, the window scroll on it
        }
    })

})