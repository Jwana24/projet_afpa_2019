// if(document.querySelector('.logo-language'))
// {
//     let logoLanguage = document.querySelector('.logo-language');
//     let menu = document.querySelector('.submenu');
//     let show = false;

//     logoLanguage.addEventListener('click', function()
//     {
//         if(show)
//         {
//             menu.style.display = 'none';
//             show = false;
//         }
//         else
//         {
//             menu.style.display = 'inline-block';
//             show = true;
//         }
//     });
// }

// if(document.querySelector('.span-registration'))
// {
//     let spanRegistration = document.querySelector('.span-registration');
//     let registration = document.querySelector('.submenu1');
//     let show = false;

//     spanRegistration.addEventListener('click', function()
//     {
//         if(show)
//         {
//             registration.style.display = 'none';
//             show = false;
//         }
//         else
//         {
//             registration.style.display = 'inline-block';
//             show = true;
//         }
//     });
// }

// if(document.querySelectorAll('.btn-submenu'))
// {
//     let btns = document.querySelectorAll('.btn-submenu');
//     let show = false;

//     btns.forEach((btn) => {
//         btn.addEventListener('click', (e) => {

//         console.log(e);
//         let submenu;

//         if(e.target.localName == "ion-icon")
//         {
//             submenu = e.target.parentElement.parentElement.children[1];
//         }
//         else if (e.target.localName == "a") 
//         {
//             submenu = e.target.parentElement.children[1];
//         }
//         else if (e.target.classList == "btn-submenu") 
//         {
//             submenu = e.target.children[1];
//         }
//         else
//         {
//             submenu = false;
//         }

//         if(submenu != false)
//         {
//             if(submenu.style.display == "none")
//             {
//                 submenu.style.display = "initial";
//             }
//             else
//             {
//                 submenu.style.display = "none";
//             }
//         }
//         });
//     });
// }