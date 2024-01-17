import React from 'react';
import BarChart from "../../components/backoffice/BarChart";
import Template from "../../components/layouts/backoffice/Template";


function Index() {
    return (
        <Template>
            <div className="container">
                <div className="row justify-content-center align-items-center">
                    <div className="col-md-10">
                        <BarChart />
                    </div>
                </div>
            </div>
        </Template>
    );
}

export default Index;