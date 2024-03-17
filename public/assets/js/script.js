document.addEventListener('DOMContentLoaded', function () {
    let sortSelect = document.getElementById('sortSelect');

    sortSelect.addEventListener('change', function () {
        document.getElementById('sortForm').submit();
    });

    let currentSort = new URL(window.location.href).searchParams.get('sort');
    if (currentSort) {
        sortSelect.value = currentSort;
    }
});
