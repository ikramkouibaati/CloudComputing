import axios from "axios";
import { useState, useEffect } from "react";
import { Link } from "react-router-dom";

function FilterMenuLeft({ handleFilter }) {

    const [categories, setCategories] = useState([]);
    const [selectedCategory, setSelectedCategory] = useState(null);

    const [materiaux, setMateriaux] = useState([]);

    const handleCategoryClick = (category) => {
        setSelectedCategory((prevSelectedCategory) =>
            prevSelectedCategory === category ? null : category
        );
        handleFilter({ categorie: category.id_categorie });
    };

    useEffect(() => {
        axios
            .get(`http://127.0.0.1:8000/api/categories`)
            .then((res) => {
                setCategories(res.data);
            })
            .catch((error) => {
                console.error('Error fetching categories:', error);
            });
        axios
            .get(`http://127.0.0.1:8000/api/materiel`)
            .then((res) => {
                setMateriaux(res.data);
            })
            .catch((error) => {
                console.error('Error fetching categories:', error);
            });

    }, []);

    return (
        <ul className="list-group list-group-flush rounded">
            <li className="list-group-item d-flex align-items-center">
                <h5 className="mt-1 mb-1 mr-3">En stock</h5>
                <input type="checkbox" name="in_stock" />
            </li>
            <li className="list-group-item d-none d-lg-block">
                <h5 className="mt-1 mb-2">Catégories</h5>
                <div className="d-flex flex-wrap my-2">
                    {categories.map(category => (
                        <button
                            key={category.id_categorie}
                            className={`btn btn-sm ${selectedCategory === category ? "btn-dark" : "btn-outline-dark"
                                } rounded-pill me-2 mb-2`}
                            onClick={() => handleCategoryClick(category)}
                        >
                            {category.nom_categorie}
                        </button>
                    ))}
                </div>
            </li>
            <li className="list-group-item">
                <h5 className="mt-1 mb-1">Matériaux</h5>
                <div className="d-flex flex-column">
                    {materiaux.map((materiel, i) => {
                        return (
                            <div key={i} className="form-check">
                                <input className="form-check-input" type="checkbox" />
                                <label className="form-check-label" htmlFor="flexCheckDefault">
                                    {materiel.nom}
                                </label>
                            </div>
                        );
                    })}
                </div>
            </li>
            <li className="list-group-item">
                <h5 className="mt-1 mb-2">Prix</h5>
                <div className="d-grid d-block mb-3">
                    <div className="form-floating mb-2">
                        <input
                            type="text"
                            className="form-control"
                            placeholder="Min"
                        />
                        <label htmlFor="floatingInput">Min Prix</label>
                    </div>
                    <div className="form-floating mb-2">
                        <input
                            type="text"
                            className="form-control"
                            placeholder="Max"
                        />
                        <label htmlFor="floatingInput">Max Prix</label>
                    </div>
                    <button className="btn btn-dark">Appliquer</button>
                </div>
            </li>
        </ul>
    );
}

export default FilterMenuLeft;
