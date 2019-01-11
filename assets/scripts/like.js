'use strict'
// Manage likes on posts
const [...likeForms] = document.querySelectorAll('.like-button-form');
const [...likeButtons] = document.querySelectorAll('.like-button');



// Updating likes on feed.php
likeForms.forEach((likeForm) => {
    likeForm.addEventListener('submit', event => {
        
        event.preventDefault();

        const formData = new FormData(likeForm);
        if (likeForm[1].value === 'like') {
            fetch('app/posts/like.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(json => {
                    let likes = document.querySelector(`.likes-post${likeForm[0].value}`);
                    likes.innerText = json;
                    likes.innerText += " likes";
                    likeForm[1].value = 'unlike';
                }
                )
                
                
            } else {
                fetch('app/posts/unlike.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(json => {
                    let likes = document.querySelector(`.likes-post${likeForm[0].value}`);
                    likes.innerText = json;
                    likes.innerText += " likes";
                    likeForm[1].value = 'like';
                });
        }
    })
});

likeButtons.forEach(likeButton => {
    likeButton.addEventListener('click', () => {
        let btnId = likeButton.dataset.id;
        let [...likeButtonIMGs] = document.querySelectorAll(`.like-button-${btnId}`);
        likeButtonIMGs.forEach(likeButtonIMG => {
            likeButtonIMG.classList.toggle('hidden');  
        })
    })
})
     
