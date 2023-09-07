import React from "react";

const GoodsItem = ({ good }) => {

    return <>
        <div>
            <p>{good.name}</p>
            <p>{good.price}</p>
            <br/>
        </div>
    </>
};

export default GoodsItem;