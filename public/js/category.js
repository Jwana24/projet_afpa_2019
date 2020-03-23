let formCategory = document.querySelector('.category');

let category = document.querySelectorAll('.select-category option');

// Depending on the selected catagory, the form submit the corresponding data
category.forEach(cat =>
{
    cat.addEventListener('click', (e)=>
    {
        formCategory.submit();
    })
});