import './Page.css'
import Header from "../Header/Header";
import Footer from "../Footer";
import Banner from "../Banner";
import Catalog from "../Catalog";
import BannerMain from "../BannerMain";
import Main from "../Main";
import {Link, Route, Routes} from "react-router-dom";
import Counter from "../Counter";
import React from "react";
import Product from "../Product";

function Page() {
    return <div>
        <Header title="New Site" dropdown="Category"/>
        <h3><Link to="/product/all">Products</Link></h3>
        <Routes>
            <Route path="/" element={
                <>
                    <BannerMain name="Album example" text="Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely."/>
                    <Banner/>
                    <Catalog/>
                    <Main/>
                </>
            }/>
            <Route path="/counter" element={
                <>
                    <Counter value={4} min={3} max={7}/>
                    <Counter value={4}/>
                </>
            }/>
            <Route path="/product/:productId" element={<Product/>}>
            </Route>
            <Route path="/*" element={<h1>Error 404!</h1>}/>
        </Routes>
        <Footer/>
    </div>
}

export default Page;
