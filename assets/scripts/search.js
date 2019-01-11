const searchForm = document.querySelector('.search-form');
const results = document.querySelector('.search-results');


searchForm.addEventListener('keyup', ()=>{
    let formData = new FormData(searchForm);
    if (searchForm[0].value.length > 0){

        fetch('app/users/search.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(json => {
            results.innerHTML = '';
            if (json === 'No users found')
            {
                results.innerHTML = `<div class="comment-container">
                                        <div>
                                            <p class="comment-username">No users found</p>
                                        </div>
                                    </div>`
            }else
            {
                json.forEach(user => {
                    results.innerHTML += `
                    <a href="profile-guest.php?profile_id=${user.id}" >
                        <div class="comment-container">
                            <img class="comment-avatar" src="/assets/uploads/${user.profile_picture}">
                            <div>
                                <p class="comment-username">${user.username}</p>
                            </div>
                        </div>
                    </a>
                    `;
                });
            }
        })
    }
})




/*
<a href="profile-guest.php?profile_id=<?=$follower['following_id'];?>" >
  <div class="comment-container" >
    <img class="comment-avatar" src="<?='/assets/uploads/'.$follower['profile_picture']?>" >
    <div class="" >
        <p class = "comment-username"> <?=$follower['username'];?> </p> 
    </div> 
</div> 
</a>
*/