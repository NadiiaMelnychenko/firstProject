import ViewProfile from "./ViewProfile";
import Info from "./Info";

function Main() {
    return <div className="container marketing">
        <div className="row">
            <Info/>
            <ViewProfile/>
            <ViewProfile/>
            <ViewProfile/>
        </div>
    </div>
}

export default Main;