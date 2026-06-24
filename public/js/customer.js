// LaundryFlow - Customer JS

document.addEventListener('DOMContentLoaded', function () {

    // Highlight active nav item berdasarkan URL
    const path = window.location.pathname;
    document.querySelectorAll('.nav-item').forEach(link => {
        if (link.getAttribute('href') && path.includes(link.getAttribute('href').split('/').pop())) {
            link.classList.add('active');
        }
    });

    // Auto-dismiss flash message (jika ada)
    const flash = document.querySelector('.flash-message');
    if (flash) {
        setTimeout(() => flash.remove(), 3000);
    }

});
