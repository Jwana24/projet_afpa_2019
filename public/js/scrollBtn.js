// INDEX ARTICLES PAGE

if(document.querySelector('.list-articles'))
{
    let arrowDown = document.querySelector('.arrow-down');
    let arrowUp = document.querySelector('.arrow-up');
    let btnElements = document.querySelectorAll('.card');
    let arrayBtnElements = btnElements[btnElements.length - 10].offsetTop;

    window.addEventListener('scroll', () =>
    {
        if(window.scrollY > arrayBtnElements)
        {
            arrowDown.style.display = 'none';
            arrowUp.style.display = 'initial';
        }
        else
        {
            arrowDown.style.display = 'initial';
            arrowUp.style.display = 'none';
        }
    });

    arrowDown.addEventListener('click', (e) =>
    {
        e.preventDefault();

        if(window.scrollY <= arrayBtnElements)
        {
            if(document.querySelector('.btn-open[aria-expanded=true]'))
            {
                let btnOpen = document.querySelector('.btn-open[aria-expanded=true]');
                btnOpen.setAttribute('aria-expanded', 'false');
                btnOpen.parentElement.parentElement.parentElement.children[1].classList.remove('show');
            }

            window.scrollTo(0, window.scrollY + 600);
        }
    });

    arrowUp.addEventListener('click', (e) =>
    {
        e.preventDefault();
        window.scrollTo(0, 0);
    });
}


// INDEX FORUM PAGE

if(document.querySelector('.list-posts'))
{
    let arrowDownF = document.querySelector('.arrow-down-f');
    let arrowUpF = document.querySelector('.arrow-up-f');
    let btnElementsF = document.querySelectorAll('.card');
    let arrayBtnElementsF = btnElementsF[btnElementsF.length - 3].offsetTop;

    window.addEventListener('scroll', () =>
    {
        if(window.scrollY > arrayBtnElementsF)
        {
            arrowDownF.style.display = 'none';
            arrowUpF.style.display = 'initial';
        }
        else
        {
            arrowDownF.style.display = 'initial';
            arrowUpF.style.display = 'none';
        }
    });

    arrowDownF.addEventListener('click', (e) =>
    {
        e.preventDefault();

        if(window.scrollY <= arrayBtnElementsF)
        {
            window.scrollTo(0, window.scrollY + 490);
        }
    });

    arrowUpF.addEventListener('click', (e) =>
    {
        e.preventDefault();
        window.scrollTo(0, 0);
    });
}