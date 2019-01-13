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
                results.innerHTML = `<div class="search-found-users">
                                        <div>
                                            <p class="search-username">No users found</p>
                                        </div>
                                    </div>`
            }else
            {
                json.forEach(user => {
                    results.innerHTML += `
                    <a href="profile-guest.php?profile_id=${user.id}" >
                        <div class="search-found-users">
                            <img class="comment-avatar" src="/assets/uploads/${user.profile_picture}">
                            <div>
                                <p class="search-username">${user.username}</p>
                                <p class="search-name">${user.first_name} ${user.last_name}</p>
                            </div>
                        </div>
                    </a>
                    `;
                });
            }
        })
    }
})


