function deleteProfile() {
    if (confirm('Delete profile?')) {
        location.replace('delete_profile.php');
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
