document.querySelectorAll('[data-seat-booking]').forEach((form) => {
    const seats = Array.from(form.querySelectorAll('[data-seat]'));
    const selectedLabel = form.querySelector('[data-selected-seats]');
    const totalPrice = form.querySelector('[data-total-price]');
    const confirmButton = form.querySelector('[data-confirm-booking]');
    const plusButton = form.querySelector('[data-seat-plus]');
    const minusButton = form.querySelector('[data-seat-minus]');
    const ticketPrice = Number(form.dataset.ticketPrice);
    let selectedSeats = [];

    const availableRows = () => {
        const rows = new Map();
        seats.forEach((seat) => {
            if (!seat.classList.contains('seat-unavailable')) {
                if (!rows.has(seat.dataset.row)) {
                    rows.set(seat.dataset.row, []);
                }
                rows.get(seat.dataset.row).push(seat);
            }
        });
        return rows;
    };

    const update = () => {
        selectedLabel.textContent = selectedSeats.length
            ? `${selectedSeats.length} selected`
            : '0 selected';
        totalPrice.textContent = (selectedSeats.length * ticketPrice).toFixed(2);
        confirmButton.disabled = selectedSeats.length === 0;
        plusButton.disabled = !canAddSeat();
        minusButton.disabled = selectedSeats.length === 0;

        seats.forEach((seat) => {
            const isSelected = selectedSeats.includes(seat);
            seat.classList.toggle('seat-selected', isSelected);
            seat.classList.toggle('seat-available', !isSelected && !seat.classList.contains('seat-unavailable'));
            const hiddenInput = form.querySelector(`[name="seatIds[]"][value="${seat.dataset.seatId}"]`);

            if (isSelected && !hiddenInput) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'seatIds[]';
                input.value = seat.dataset.seatId;
                form.appendChild(input);
            } else if (!isSelected && hiddenInput) {
                hiddenInput.remove();
            }
        });
    };

    const canAddSeat = () => {
        if (selectedSeats.length === 0) {
            return Array.from(availableRows().values()).some((row) => row.length > 0);
        }

        const lastSeat = selectedSeats[selectedSeats.length - 1];
        const row = availableRows().get(lastSeat.dataset.row) || [];
        const nextSeat = row.find((seat) => Number(seat.dataset.seatNumber) > Number(lastSeat.dataset.seatNumber));
        return Boolean(nextSeat && Number(nextSeat.dataset.seatNumber) === Number(lastSeat.dataset.seatNumber) + 1);
    };

    const addSeat = () => {
        if (selectedSeats.length === 0) {
            return;
        }

        const lastSeat = selectedSeats[selectedSeats.length - 1];
        const row = availableRows().get(lastSeat.dataset.row) || [];
        const nextSeat = row.find((seat) => Number(seat.dataset.seatNumber) === Number(lastSeat.dataset.seatNumber) + 1);
        if (nextSeat) {
            selectedSeats.push(nextSeat);
        }
        update();
    };

    const selectStartingSeat = (startingSeat) => {
        const desiredCount = Math.max(selectedSeats.length, 1);
        const row = availableRows().get(startingSeat.dataset.row) || [];
        const startingIndex = row.indexOf(startingSeat);
        const contiguousSeats = row.slice(startingIndex, startingIndex + desiredCount);
        const hasContiguousSeats = contiguousSeats.length === desiredCount
            && contiguousSeats.every((seat, index) => index === 0
                || Number(seat.dataset.seatNumber) === Number(contiguousSeats[index - 1].dataset.seatNumber) + 1);

        selectedSeats = hasContiguousSeats ? contiguousSeats : [startingSeat];
        update();
    };

    seats.forEach((seat) => {
        if (!seat.classList.contains('seat-unavailable')) {
            seat.addEventListener('click', () => selectStartingSeat(seat));
        }
    });

    plusButton.addEventListener('click', addSeat);
    minusButton.addEventListener('click', () => {
        selectedSeats.pop();
        update();
    });
    update();
});
