import React from "react";

const GoodsItem = ({ good }) => {

    return <>
        <tr>
            <td>{good.name}</td>
            <td>{good.price}</td>
            <td>{good.addTime}</td>
        </tr>
    </>
};

export default GoodsItem;