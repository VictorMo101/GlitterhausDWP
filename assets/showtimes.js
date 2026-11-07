document.querySelectorAll('[data-showtime-carousel]').forEach((carousel) => {
    const viewport = carousel.querySelector('[data-showtime-viewport]');
    const track = carousel.querySelector('[data-showtime-track]');
    const previous = carousel.querySelector('[data-showtime-previous]');
    const next = carousel.querySelector('[data-showtime-next]');
    const dateCount = track.querySelectorAll('.showtime-day').length;
    let startX = 0;
    let startScrollLeft = 0;
    let dragging = false;

    const updateArrows = () => {
        const maxScroll = viewport.scrollWidth - viewport.clientWidth;
        const hasOverflow = dateCount > 5 && maxScroll > 1;
        previous.hidden = !hasOverflow || viewport.scrollLeft <= 1;
        next.hidden = !hasOverflow || viewport.scrollLeft >= maxScroll - 1;
    };

    const scrollByDate = (direction) => {
        viewport.scrollBy({ left: direction * viewport.clientWidth, behavior: 'smooth' });
    };

    previous.addEventListener('click', () => scrollByDate(-1));
    next.addEventListener('click', () => scrollByDate(1));
    viewport.addEventListener('scroll', updateArrows, { passive: true });
    window.addEventListener('resize', updateArrows);

    viewport.addEventListener('pointerdown', (event) => {
        dragging = true;
        startX = event.clientX;
        startScrollLeft = viewport.scrollLeft;
        viewport.setPointerCapture(event.pointerId);
    });

    viewport.addEventListener('pointermove', (event) => {
        if (dragging) {
            viewport.scrollLeft = startScrollLeft - (event.clientX - startX);
        }
    });

    const stopDragging = (event) => {
        if (dragging) {
            dragging = false;
            viewport.releasePointerCapture(event.pointerId);
        }
    };

    viewport.addEventListener('pointerup', stopDragging);
    viewport.addEventListener('pointercancel', stopDragging);
    updateArrows();
});
