let like = document.querySelector('.like'); // Récupère la div qui englobe les 2 icônes
let formLike = document.querySelector('.like-article form');

like.addEventListener('click', () =>
{
    formLike.submit();
});