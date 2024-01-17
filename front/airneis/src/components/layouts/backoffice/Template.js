import "../../../assets/css/sb-admin-2.css"

import Header from "../../../components/layouts/backoffice/Header";
import Topbar from "../../../components/backoffice/Topbar";
import Sidebar from "../../../components/backoffice/Sidebar";

function Template({ title, children }) {
    return (
        <>
            <Header />
            <div id="wrapper">
                <Sidebar />
                <div id="content-wrapper" className="d-flex flex-column">
                    <div id="content">
                        <Topbar title={title} />
                        <div className="container-fluid">
                            <div className="row">
                                {children}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

export default Template;