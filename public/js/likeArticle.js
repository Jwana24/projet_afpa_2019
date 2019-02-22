let like = document.querySelector('.like'); // Récupère la div qui englobe les 2 icônes
let heartEmpty = document.querySelector('ion-icon[name=heart-empty]');
let heartFull = document.querySelector('ion-icon[name=heart]');
let countLike = document.querySelector('.nb-like-article');

like.addEventListener('click', (e) =>
{
    let data = new FormData();

    data.append('ajax-like', 'true');
    fetch('/article/'+like.dataset['id']+'/show', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
        {
            let isLiked = JSON.parse(promise);
            countLike.innerText = isLiked.nbLike+' likes';

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