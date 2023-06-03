function copyLink(link) {
    var fullURL = window.location.origin + link;
    var tempInput = document.createElement('input');
    tempInput.value = fullURL;
    document.body.appendChild(tempInput);

    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);

    alert('Link copied to clipboard!');
}