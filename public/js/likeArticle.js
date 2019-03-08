if(document.querySelector('ion-icon[name=heart]') && document.querySelector('ion-icon[name=heart-empty]'))
{
    let like = document.querySelector('.like');
    let heartEmpty = document.querySelector('ion-icon[name=heart-empty]');
    let heartFull = document.querySelector('ion-icon[name=heart]');
    let countLike = document.querySelector('.nb-like-article');
    
    like.addEventListener('click', (e) =>
    {
        let data = new FormData();
    
        data.append('ajax-like', 'true'); // make the same action to a hidden input where the value is true
        fetch('/article/'+like.dataset['id']+'/show', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
            {
                let isLiked = JSON.parse(promise);
                countLike.innerText = isLiked.nbLike+' likes'; // get to our JS object the number of likes
    
                if(isLiked.content)
                {
                    heartFull.style.display = 'inline-block';
                    heartEmpty.style.display = 'none';
                }
                else
                {
                    heartFull.style.display = 'none';
                    heartEmpty.style.display = 'inline-block';
                }
            });
    });
    
    if(document.querySelector('.member-like').dataset['like'] == 'true')
    {
        heartFull.style.display = 'inline-block';
        heartEmpty.style.display = 'none';
    }
    else
    {
        heartFull.style.display = 'none';
        heartEmpty.style.display = 'inline-block';
    }
}