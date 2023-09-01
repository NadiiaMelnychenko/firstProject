import ViewProfile from "./ViewProfile";
import Info from "./Info";

function Main() {
    return <div className="container marketing">
        <div className="row">
            <Info/>
            <ViewProfile name="Nadiia" about="Some representative placeholder content for the three columns of text below the carousel. This is the first
            column."/>
            <ViewProfile name="Anton" about="Some new placeholder content for the three columns of text below the carousel. This is the first
            column."/>
            <ViewProfile name="Nika" about="Some again placeholder content for the three columns of text below the carousel. This is the first
            column."/>
        </div>
    </div>
}

export default Main;