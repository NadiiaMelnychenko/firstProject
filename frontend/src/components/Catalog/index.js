import CatalogElement from "./CatalogElement";

function Catalog() {
    return <div className="album py-5 bg-body-tertiary">
        <div className="container">
            <div className="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <CatalogElement title="Thumbnail" text="This is a wider card with supporting text below as a natural
                    lead-in to additional content. This content is a little bit longer."/>
                <CatalogElement title="Second Title" text=" This content is a little bit longer. This is a wider card with supporting text below as a natural
                    lead-in to additional content."/>
                <CatalogElement title="Third" text="This is a wider card with supporting text below as a natural
                    lead-in to additional content. This content is a little bit longer."/>
            </div>
        </div>
    </div>
}

export default Catalog;