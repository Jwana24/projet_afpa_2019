# lesnacs


### What is this project ?

A Symfony 4 / PHP project on the topic "New pets" (exactly the same project as "lesnacs", but with Symfony 4)


### What's in this application ?

It's a multiple pages website :

- in general :

| Navbar | Content |
| ------ | ------ |
| Logo | on click redirection on the homepage |
| Links | Home page, articles page, forum page |
| User | 2 links connection or inscription, profile (if the user is connected) |
| Language | 2 languages : english and french |
| Search bar | when we execute the research, it's open a new page with the results |

| Footer | Content |
| ------ | ------ |
| Main links | Home page, articles page, forum page, profile page (if the user is connected), Legal Notice |
| Other links | 2 external websites links |


- the "home" page :

| Sections | Content |
| ------ | ------ |
| Header | a carousel with 3 images and 3 titles, representing the 3 parts of the website (home, articles and forum) |
| Main | 4 articles cards with the image, the title and the first sentences of the content |
| Contacts form | a sidebar with a form to contact the website manager |

- the "articles" page :

| Sections | Content |
| ------ | ------ |
| List of articles | a title, the first sentences of the content and a button to see the entire article |
| Links | The administrator can delete or edit all the articles |

- an article page :

| Sections | Content |
| ------ | ------ |
| Image | The image of the article |
| Article content | Title and content of the article. The administrator can change directly all of this informations with an editor on the page and validate or cancel the modifications. He can delete the article too. |
| Comments, responses, likes | The members can post comments, responses of comments and likes the articles (the member who post a comment or a response can delete it). The administrator can delete all the comments and responses. |

- the "forum" page :

| Sections | Content |
| ------ | ------ |
| List of posts | All the posts are listed as cards with the subject as title and the first sentences of the content |
| Links | the administrator can delete or edit all the posts. The user can choose an animal category in a selection |

- a post page :

| Sections | Content |
| ------ | ------ |
| Category | The animal category covered by the post |
| Subject | The subject of the post as a title |
| Links | The member who post it can delete or edit it, the administrator can delete or edit the post too. The post can be closed if it's resolve, in this case there can no longer be any comments |
