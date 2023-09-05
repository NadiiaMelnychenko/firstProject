import {useParams} from "react-router-dom";
import React from "react";

function Product() {
    const params = useParams();
    const productId = (params.productId==="product")?"all in list":params.productId   ;

    return <div>
        <h2>Product {productId}</h2>
    </div>
}

export default Product;
