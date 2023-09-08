import React from 'react';

const GoodsFilter = ({filterData, setFilterData}) => {

    const onChangeFilterData = (event) => {
        event.preventDefault();

        const {name, value} = event.target;

        setFilterData({...filterData, [name]: value});
    };

    return <>
        <div>
            <label htmlFor="name">Name: </label>
            <input id="name" type="text" name="name" defaultValue={filterData.name ?? ""} onChange={onChangeFilterData}/>
            <br/>
            <label htmlFor="minPrice">Мінімальна ціна: </label>
            <input
                id="minPrice"
                type="number"
                name="minPrice"
                value={filterData.minPrice ?? ""}
                onChange={onChangeFilterData}
            />
            <label htmlFor="maxPrice">Максимальна ціна: </label>
            <input
                id="maxPrice"
                type="number"
                name="maxPrice"
                value={filterData.maxPrice ?? ""}
                onChange={onChangeFilterData}
            />
            <br/>
        </div>
    </>;
};

export default GoodsFilter;