import './Page.css'
import Header from "../Header/Header";
import Footer from "../Footer";
import Banner from "../Banner";
import Catalog from "../Catalog";
import BannerMain from "../BannerMain";
import Main from "../Main";

function Page() {
    return <div>
        <Header title="New Site" dropdown="Category"/>
        <BannerMain name="Album example" text="Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely."/>
        <Banner/>
        <Catalog/>
        <Main/>
        <Footer/>
    </div>
}

export default Page;