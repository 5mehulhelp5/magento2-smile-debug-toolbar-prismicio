function smileToggle(uid) {
    document.getElementById('smile-field-' + uid).classList.toggle('field-cover');
}
window.smileToggle = smileToggle;
