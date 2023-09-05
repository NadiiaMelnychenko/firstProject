import React from "react";
import {createBrowserRouter, Link, Outlet, RouterProvider} from
        "react-router-dom";
import Banner from "../Banner";
import Counter from "../Counter";
import BannerMain from "../BannerMain";
import Catalog from "../Catalog";
import Main from "../Main";
import Product from "../Product";

const categoryItems = ["one", "two", "three"]

let router = createBrowserRouter(
    [
        {
            path: "/", element: <>
                <nav className="navbar navbar-expand-lg bg-body-tertiary">
                    <div className="container-fluid">
                        <Link to="/" className="navbar-brand">New Site</Link>
                        <button className="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span className="navbar-toggler-icon"></span>
                        </button>
                        <div className="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul className="navbar-nav me-auto mb-2 mb-lg-0">
                                <li className="nav-item">
                                    <Link to="/" className="nav-link active" aria-current="page">Home</Link>
                                </li>
                                <li className="nav-item">
                                    <Link to="/counter" className="nav-link">Counters</Link>
                                </li>
                                <li className="nav-item">
                                    <Link to="/product" className="nav-link">Products</Link>
                                </li>
                                <li className="nav-item dropdown">
                                    <a className="nav-link dropdown-toggle" href="#" role="button"
                                       data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        Category
                                    </a>
                                    <ul className="dropdown-menu">
                                        {categoryItems.map((categotyName, index) =>
                                            <li key={index} ><a className="dropdown-item" href="#">{categotyName}</a>
                                            </li>
                                        )}
                                    </ul>
                                </li>
                                <li className="nav-item">
                                    <a className="nav-link disabled" aria-disabled="true">Disabled</a>
                                </li>
                            </ul>
                            <form className="d-flex" role="search">
                                <input className="form-control me-2" type="search" placeholder="Search"
                                       aria-label="Search"/>
                                <button className="btn btn-outline-success" type="submit">Search</button>
                            </form>
                        </div>

                    </div>
                </nav>
                <Outlet/>
            </>,
            children:
                [
                    {
                        index: true,
                        element: <>
                            <BannerMain name="Album example" text="Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely."/>
                            <Banner/>
                            <Catalog/>
                            <Main/>
                        </>
                    },
                    {
                        path: "counter", element: <>
                            <Counter value={4} min={3} max={7}/>
                            <Counter value={4}/>
                        </>
                    },
                    {
                        path: "product?/:productId", element: <Product/>
                    }
                ],
            errorElement: <h1>Error 404 !</h1>
        }
    ]);

function Header() {
    return <RouterProvider router={router}/>
}

export default Header;


//
// {/*<a className="navbar-brand" href="#">{title}</a>*/}
// <button className="navbar-toggler" type="button" data-bs-toggle="collapse"
//         data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
//         aria-expanded="false" aria-label="Toggle navigation">
//     <span className="navbar-toggler-icon"></span>
// </button>
// <div className="collapse navbar-collapse" id="navbarSupportedContent">
//     <ul className="navbar-nav me-auto mb-2 mb-lg-0">
//         <li className="nav-item">
//             <Link to="/" className="nav-link active" aria-current="page">Home</Link>
//             {/*<a className="nav-link active" aria-current="page" href="#">Home</a>*/}
//         </li>
//         <li className="nav-item">
//             <Link to="/counter" className="nav-link">Counters</Link>
//             {/*<a className="nav-link" href="#">Link</a>*/}
//         </li>
//         <li className="nav-item dropdown">
//             <a className="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
//                aria-expanded="false">
//                 {dropdown}
//             </a>
//             <ul className="dropdown-menu">
//                 {categoryItems.map((categotyName, index) =>
//                     <li><a className="dropdown-item" href="#" key={index}>{categotyName}</a></li>
//                 )}
//             </ul>
//         </li>
//         <li className="nav-item">
//             <a className="nav-link disabled" aria-disabled="true">Disabled</a>
//         </li>
//     </ul>
//     <form className="d-flex" role="search">
//         <input className="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
//         <button className="btn btn-outline-success" type="submit">Search</button>
//     </form>
// </div>