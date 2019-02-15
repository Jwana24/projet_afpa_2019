let formCategory = document.querySelector('.category');

let category = document.querySelectorAll('.select-category option');

category.forEach(cat =>
{
    cat.addEventListener('click', (e)=>
    {
        console.log(e.target);
        formCategory.submit();
    })
});