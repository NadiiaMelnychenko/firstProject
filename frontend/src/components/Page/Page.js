import './Page.css'
import Header from "../Header/Header";
import Footer from "../Footer";
import Banner from "../Banner";
import Catalog from "../Catalog";

function Page(props) {
    return <div>
        <Header/>
        <Banner/>
        <Banner/>
        <Banner/>
        <Catalog/>
        <Footer/>
    </div>
}

export default Page;