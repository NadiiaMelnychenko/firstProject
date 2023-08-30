import SideBar from "./SideBar";
import SampleBlog from "./SampleBlog";
import InlineHTMLElements from "./InlineHTMLElements";
import ExampleTable from "./ExampleTable";

function Info() {
    return <div className="row g-5">
        <div className="col-md-8">
            <h3 className="pb-4 mb-4 fst-italic border-bottom">
                From the Firehose
            </h3>

            <article className="blog-post">
                <h2 className="display-5 link-body-emphasis mb-1">Sample blog post</h2>
                <SampleBlog/>
                <h2>Inline HTML elements</h2>
                <InlineHTMLElements/>
            </article>

            <article className="blog-post">
                <h3>Example table</h3>
                <p>And don't forget about tables in these posts:</p>
                <ExampleTable/>

                <p>This is some additional paragraph placeholder content. It's a slightly shorter version of the other
                    highly repetitive body text used throughout.</p>
            </article>

            <nav className="blog-pagination" aria-label="Pagination">
                <a className="btn btn-outline-primary rounded-pill" href="#">Older</a>
                <a className="btn btn-outline-secondary rounded-pill disabled" aria-disabled="true">Newer</a>
            </nav>
            <br/>
        </div>
        <SideBar/>

    </div>
}

export default Info;