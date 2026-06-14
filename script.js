// SIM-PEND - Utility Scripts
// ===========================

// Auto-hide info boxes after 4 seconds
document.addEventListener('DOMContentLoaded', function() {
    const infoBoxes = document.querySelectorAll('.info-box.show');
    infoBoxes.forEach(function(box) {
        setTimeout(function() {
            box.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            box.style.opacity = '0';
            box.style.transform = 'translateY(-8px)';
            setTimeout(function() { box.style.display = 'none'; }, 500);
        }, 4000);
    });
});
