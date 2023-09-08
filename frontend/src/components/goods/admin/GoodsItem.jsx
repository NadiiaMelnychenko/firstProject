import React from "react";

function formatDateFromBigInt(bigintDate) {
    const date = new Date(bigintDate * 1000);
    return date.toLocaleString();
}

const GoodsItem = ({ good }) => {

    return <>
        <tr>
            <td>{good.name}</td>
            <td>{good.price}</td>
            <td>{formatDateFromBigInt(good.addTime)}</td>
        </tr>
    </>
};

export default GoodsItem;