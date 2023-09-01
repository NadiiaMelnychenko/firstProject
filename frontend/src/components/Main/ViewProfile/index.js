function ViewProfile({name, about}) {
    return <div className="col-lg-4">
        <svg className="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg"
             role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="var(--bs-secondary-color)"></rect>
        </svg>
        <h2 className="fw-normal">{name}</h2>
        <p>{about}</p>
        <p><a className="btn btn-secondary" href="#">View details »</a></p>
    </div>
}

export default ViewProfile;