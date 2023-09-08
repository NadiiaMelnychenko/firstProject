import React, { useState } from 'react';

function convertDateToBigInt(date) {
    return Math.floor(new Date(date).getTime() / 1000); // Переводимо дату в секунди та округлюємо
}
const DateFilter = ({ onDateChange }) => {
    const [startDate, setStartDate] = useState('');
    const [endDate, setEndDate] = useState('');

    const handleFilter = () => {
        const startDateBigInt = convertDateToBigInt(startDate);
        const endDateBigInt = convertDateToBigInt(endDate);

        onDateChange({ startDate: startDateBigInt, endDate: endDateBigInt });
    };

    return (
        <div>
            <input
                type="date"
                value={startDate}
                onChange={(e) => setStartDate(e.target.value)}
            />
            <input
                type="date"
                value={endDate}
                onChange={(e) => setEndDate(e.target.value)}
            />
            <button onClick={handleFilter}>Фільтрувати</button>
        </div>
    );
};

export default DateFilter;
