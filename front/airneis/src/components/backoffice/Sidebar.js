function Sidebar() {
    return (
        <ul className="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a className="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div className="sidebar-brand-text mx-3">Admin Airnéis</div>
            </a>
            <div className="sidebar-divider my-0" style={{ borderTop: '1px solid rgba(255,255,255,.15)', margin: '10px 0' }}></div>

            <li className="nav-item active">
                <a className="nav-link" href="/backoffice">
                    <i className="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <div className="sidebar-divider" style={{ borderTop: '1px solid rgba(255,255,255,.15)', margin: '10px 0' }}></div>

            <div className="sidebar-heading">
                Interface
            </div>

            <li className="nav-item">
                <a className="nav-link" href="/backoffice/products">
                    <i className="fas fa-fw fa-cog"></i>
                    <span>Produits</span>
                </a>
            </li>

            <li className="nav-item">
                <a className="nav-link" href="/backoffice/categories">
                    <i className="fas fa-fw fa-cog"></i>
                    <span>Catégories</span>
                </a>
            </li>

            <li className="nav-item">
                <a className="nav-link" href="/backoffice/messages">
                    <i className="fas fa-fw fa-cog"></i>
                    <span>Contact - Messages</span>
                </a>
            </li>
            <div className="sidebar-divider d-none d-md-block" style={{ borderTop: '1px solid rgba(255,255,255,.15)', margin: '10px 0' }}></div>
        </ul>
    );
}

export default Sidebar;