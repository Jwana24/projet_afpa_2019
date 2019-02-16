if(document.querySelectorAll('.response_btn'))
{
    let response_btn = document.querySelectorAll('.response_btn');
    let modal = document.querySelector('.modal_response');
    let close_modal = document.querySelector('.close_modal_response');

    response_btn.forEach(function(e)
    {
        e.addEventListener('click', function(f)
        {
            f.preventDefault();
            document.querySelector('input[name=id_comment]').value = f.target.dataset['id'];

            modal.style.display = 'flex';
        })
    })

    close_modal.addEventListener('click', function()
    {
        modal.style.display = 'none';
    })

    window.addEventListener('click', function(g)
    {
        if(g.target == modal)
        {
            modal.style.display = 'none';
        }
    })
}