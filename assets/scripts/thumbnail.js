const portraitThumbnailImage = [...document.querySelectorAll('.profile-post')]
portraitThumbnailImage.map(img => {
  if (img.clientHeight > img.clientWidth){
    img.classList.add('portrait');
  }else if(img.clientHeight === img.clientWidth){
    img.classList.add('square');
  }else{
    img.classList.add('landscape')
  }
})
