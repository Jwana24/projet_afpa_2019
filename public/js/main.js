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
function transformText(elements, fr, en, fr2, en2)
{
    if(document.querySelector(elements))
    {
        let textBtn = document.querySelectorAll(elements);

        if(document.body.clientWidth < 415)
        {
            textBtn.forEach(element =>
            {
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
        else
        {
            textBtn.forEach(element =>
            {
                if(element.localName == 'a')
                {
                    element.innerText = trans(element.dataset['locale'], fr2, en2);
                }
                else if(element.localName == 'input')
                {
                    element.value = trans(element.dataset['locale'], fr2, en2);
                }
            });
        }
    }
}