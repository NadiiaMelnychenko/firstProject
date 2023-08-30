import About from "./about";
import RecentPosts from "./RecentPosts";
import Archives from "./Archives";
import Elsewhere from "./Elsewhere";

function SideBar() {
    return <div className="col-md-4">
        <div className="position-sticky" top="2rem">
            <About/>

            <div>
                <h4 className="fst-italic">Recent posts</h4>
                <ul className="list-unstyled">
                    <RecentPosts/>
                    <RecentPosts/>
                    <RecentPosts/>
                </ul>
            </div>

            <div className="p-4">
                <h4 className="fst-italic">Archives</h4>
                <ol className="list-unstyled mb-0">
                    <Archives/>
                </ol>
            </div>

            <div className="p-4">
                <h4 className="fst-italic">Elsewhere</h4>
                <ol className="list-unstyled">
                    <Elsewhere/>
                </ol>
            </div>
        </div>
    </div>
}

export default SideBar;