transformText('.btn-edit-comment', 'Editer', 'Edit', 'Editer commentaire', 'Edit comment');
transformText('.btn-edit-response', 'Editer', 'Edit', 'Editer réponse', 'Edit response');

transformText('.delete-comment-article', 'Supprimer', 'Delete', 'Supprimer commentaire', 'Delete comment');
transformText('.delete-response-article', 'Supprimer', 'Delete', 'Supprimer réponse', 'Delete response');

transformText('.btn-edit-post', 'Editer', 'Edit', 'Editer le post', 'Edit post');
transformText('.btn-delete-post', 'Supprimer', 'Delete', 'Supprimer le post', 'Delete post');

window.addEventListener('resize', () =>
{
    transformText('.btn-edit-comment', 'Editer', 'Edit', 'Editer commentaire', 'Edit comment');
    transformText('.btn-edit-response', 'Editer', 'Edit', 'Editer réponse', 'Edit response');

    transformText('.delete-comment-article', 'Supprimer', 'Delete', 'Supprimer commentaire', 'Delete comment');
    transformText('.delete-response-article', 'Supprimer', 'Delete', 'Supprimer réponse', 'Delete response');

    transformText('.btn-edit-post', 'Editer', 'Edit', 'Editer le post', 'Edit post');
    transformText('.btn-delete-post', 'Supprimer', 'Delete', 'Supprimer le post', 'Delete post');
})