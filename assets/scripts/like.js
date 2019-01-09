const likeButtons = document.querySelectorAll('.like-button');


Array.from(likeButtons).forEach((likeButton) => {
    console.log(likeButton);
    likeButton.addEventListener('click', () =>{
        fetch()
    });
});