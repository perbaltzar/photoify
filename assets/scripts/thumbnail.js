const portraitThumbnailImage = [...document.querySelectorAll('.profile-post')]
portraitThumbnailImage.map(img => {
  (img.clientHeight > img.clientWidth) ? img.classList.add('portrait'): img.classList.add('landscape')
})
