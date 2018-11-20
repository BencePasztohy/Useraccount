function deleteProfile() {
    if (confirm('Delete profile?')) {
        location.replace('delete-profile.php');
    }
}
let show = false;
function showPwd(realPwd, hiddenPwd) {
    if (!show) {
        document.getElementById('hidden-pwd').innerHTML = realPwd;
        document.getElementById('show-pwd').innerHTML = 'hide';
        show = true;
    } else {
        document.getElementById('hidden-pwd').innerHTML = hiddenPwd;
        document.getElementById('show-pwd').innerHTML = 'show';
        show = false;
    }
}
function deletePost(id) {
    if (confirm('Delete post?')) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == 'deleted') {
                    location.reload();
                } else {
                    alert('Failed to delete post.');
                }
            }
        };
        xmlhttp.open('GET', 'delete-post.php?id=' + id, true);
        xmlhttp.send();
    }
}
let titleCounter = document.getElementById('title-counter');
titleCounter.innerHTML = '0/512';
let titleCounterField = (document.getElementById(
    'title-input'
).onkeyup = function() {
    titleCounter.innerHTML = this.value.length + '/512';
});

let postCounter = document.getElementById('post-counter');
postCounter.innerHTML = '0/1024';
let textCounterField = (document.getElementById(
    'text-input'
).onkeyup = function() {
    postCounter.innerHTML = this.value.length + '/1024';
});
