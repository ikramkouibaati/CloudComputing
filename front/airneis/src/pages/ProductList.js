import { Link } from "react-router-dom";
import { useState } from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import ScrollToTopOnMount from "../lib/ScrollToTopOnMount";
import FilterMenuLeft from "../components/products/FilterMenuLeft";
import ProductItem from "../components/products/ProductItem";

const categories = [
    "All Products",
    "Phones & Tablets",
    "Cases & Covers",
    "Screen Guards",
    "Cables & Chargers",
    "Power Banks",
];


function ProductList() {
    const [viewType, setViewType] = useState({ grid: true });

    function changeViewType() {
        setViewType({
            grid: !viewType.grid,
        });
    }

    return (
        <div className="container mt-5 py-4 px-xl-5">
            <ScrollToTopOnMount />
            <nav aria-label="breadcrumb" className="bg-custom-light rounded">
                <ol className="breadcrumb p-3 mb-0">
                    <li className="breadcrumb-item">
                        <Link
                            className="text-decoration-none link-secondary"
                            to="/products"
                            replace
                        >
                            All products
                        </Link>
                    </li>
                </ol>
            </nav>

            <div className="h-scroller d-block d-lg-none">
                <nav className="nav h-underline">
                    {categories.map((v, i) => {
                        return (
                            <div key={i} className="h-link me-2">
                                <Link
                                    to="/products"
                                    className="btn btn-sm btn-outline-dark rounded-pill"
                                    replace
                                >
                                    {v}
                                </Link>
                            </div>
                        );
                    })}
                </nav>
            </div>

            <div className="row mb-3 d-block d-lg-none">
                <div className="col-12">
                    <div id="accordionFilter" className="accordion shadow-sm">
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="headingOne">
                                <button
                                    className="accordion-button fw-bold collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseFilter"
                                    aria-expanded="false"
                                    aria-controls="collapseFilter"
                                >
                                    Filter Products
                                </button>
                            </h2>
                        </div>
                        <div
                            id="collapseFilter"
                            className="accordion-collapse collapse"
                            data-bs-parent="#accordionFilter"
                        >
                            <div className="accordion-body p-0">
                                <FilterMenuLeft />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="row mb-4 mt-lg-3">
                <div className="d-none d-lg-block col-lg-3">
                    <div className="border rounded shadow-sm">
                        <FilterMenuLeft />
                    </div>
                </div>
                <div className="col-lg-9">
                    <div className="d-flex flex-column h-100">
                        <div className="row mb-3">
                            <div className="col-lg-3 d-none d-lg-block">
                                <select
                                    className="form-select"
                                    aria-label="Default select example"
                                    defaultValue=""
                                >
                                    <option value="">All Models</option>
                                    <option value="1">Lamp</option>
                                    <option value="2">Table</option>
                                    <option value="3">Closet</option>
                                </select>
                            </div>
                            <div className="col-lg-9 col-xl-5 offset-xl-4 d-flex flex-row">
                                <div className="input-group">
                                    <input
                                        className="form-control"
                                        type="text"
                                        placeholder="Search products..."
                                        aria-label="search input"
                                    />
                                    <button className="btn btn-outline-dark">
                                        <FontAwesomeIcon icon={["fas", "search"]} />
                                    </button>
                                </div>
                                <button
                                    className="btn btn-outline-dark ms-2 d-none d-lg-inline"
                                    onClick={changeViewType}
                                >
                                    <FontAwesomeIcon
                                        icon={["fas", viewType.grid ? "th-list" : "th-large"]}
                                    />
                                </button>
                            </div>
                        </div>
                        <ProductItem viewType={viewType} />
                 </div>
            </div>      
     </div>
</div>
    );
}

export default ProductList;
