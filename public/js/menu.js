if(document.querySelector('.logo-language'))
{
    let logoLanguage = document.querySelector('.logo-language');
    let menu = document.querySelector('.submenu');
    let show = false;

    logoLanguage.addEventListener('click', function()
    {
        if(show)
        {
            menu.style.display = 'none';
            show = false;
        }
        else
        {
            menu.style.display = 'inline-block';
            show = true;
        }
    });
}

if(document.querySelector('.span-registration'))
{
    let spanRegistration = document.querySelector('.span-registration');
    let registration = document.querySelector('.submenu1');
    let show = false;

    spanRegistration.addEventListener('click', function()
    {
        if(show)
        {
            registration.style.display = 'none';
            show = false;
        }
        else
        {
            registration.style.display = 'inline-block';
            show = true;
        }
    });
}