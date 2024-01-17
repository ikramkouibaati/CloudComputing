function Topbar({ title }) {

    return (
        <nav className="navbar navbar-light bg-white topbar mb-4 static-top shadow">
            <div className="container d-flex justify-content-center">
                <h2 className="fw-bold text-dark">{title}</h2>
            </div>
        </nav>
    )
}

export default Topbar;