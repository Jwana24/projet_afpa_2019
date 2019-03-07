transformText('.btn-edit-comment', 'Editer', 'Edit');
transformText('.btn-edit-response', 'Editer', 'Edit');

transformText('.delete-comment-article', 'Supprimer', 'Delete');
transformText('.delete-response-article', 'Supprimer', 'Delete');

window.addEventListener('resize', () =>
{
    transformText('.btn-edit-comment', 'Editer', 'Edit', 'Editer commentaire', 'Edit comment');
    transformText('.btn-edit-response', 'Editer', 'Edit', 'Editer réponse', 'Edit response');

    transformText('.delete-comment-article', 'Supprimer', 'Delete', 'Supprimer commentaire', 'Delete comment');
    transformText('.delete-response-article', 'Supprimer', 'Delete', 'Supprimer réponse', 'Delete response');
})