// Stock a language in a parameter. Return the parameter depending to the selected language
function trans(e, a, b)
{
    if(e == 'fr_FR')
    {
        return a;
    }
    else if(e == 'en')
    {
        return b;
    }
}

// A function for transform the text if the page is smaller (responsive) with the translation in english
function transformText(elements, fr, en)
{
    if(document.querySelector(elements))
    {
        if(document.body.clientWidth < 415)
        {
            let textBtn = document.querySelectorAll(elements);

            textBtn.forEach(element =>
            {
                console.log(element);
                if(element.localName == 'a')
                {
                    element.innerText = trans(element.dataset['locale'], fr, en);
                }
                else if(element.localName == 'input')
                {
                    element.value = trans(element.dataset['locale'], fr, en);
                }
            });
        }
    }
}