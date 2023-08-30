import './Page.css'
import Header from "../Header/Header";
import Footer from "../Footer";
import Banner from "../Banner";
import Catalog from "../Catalog";
import BannerMain from "../BannerMain";
import Main from "../Main";

function Page(props) {
    return <div>
        <Header/>
        <BannerMain/>
        <Banner/>
        <Catalog/>
        <Main/>
        <Footer/>
    </div>
}

export default Page;