document.querySelectorAll('select[id^="roleSelect"]').forEach(function (roleSelect) {
    roleSelect.addEventListener('change', function (){
        let formId = this.id.replace('roleSelect', 'roleForm');
        let form = document.getElementById(formId);
        form.submit();
    });
});
