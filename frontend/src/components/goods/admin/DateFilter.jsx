import React, { useState } from 'react';
import convertBigintToDate from "../../../utils/convertBigintToDate";



const DateFilter = ({ onDateChange }) => {
    const [startDate, setStartDate] = useState('');
    const [endDate, setEndDate] = useState('');

    const handleFilter = () => {
        const startDateBigInt = convertBigintToDate(startDate);
        const endDateBigInt = convertBigintToDate(endDate);

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
