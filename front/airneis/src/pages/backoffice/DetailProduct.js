import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import axios from 'axios';

import Template from '../../components/layouts/backoffice/Template';
import DropdownCategory from '../../components/backoffice/DrodownCategory';

function DetailProduct() {

    const { id } = useParams();
    const [product, setProduct] = useState(null);
    const [editedProduct, setEditedProduct] = useState(null);
    const [categories, setCategories] = useState([]);
    const [successMessage, setSuccessMessage] = useState('');
    const [errorMessage, setErrorMessage] = useState('');

    useEffect(() => {
        const fetchData = async () => {
            try {
                const [productRes, categoriesRes] = await Promise.all([
                    axios.get(`http://127.0.0.1:8000/api/produits/${id}`),
                    axios.get(`http://127.0.0.1:8000/api/categories`)
                ]);
                setProduct(productRes.data);
                setEditedProduct(productRes.data);
                setCategories(categoriesRes.data);
            } catch (error) {
                console.log('Error fetching product and categories:', error);
            }
        };

        fetchData();
    }, [id]);

    const handleChange = (e) => {
        const { name, value } = e.target;
        if (name === 'id_categorie') {
            const selectedCategory = categories.find(category => category.id_categorie === parseInt(value));
            setEditedProduct(prevState => ({
                ...prevState,
                categorie: selectedCategory
            }));
        } else {
            setEditedProduct(prevState => ({
                ...prevState,
                [name]: value
            }));
        }
    };

    const handleSave = () => {
        const updatedProduct = {
            ...editedProduct,
            id_categorie: editedProduct.categorie.id_categorie || product.categorie.id_categorie
        };

        axios
            .put(`http://127.0.0.1:8000/api/produits/${id}`, updatedProduct)
            .then(() => {
                setSuccessMessage('Produit modifié avec succès');
                setErrorMessage('');
            })
            .catch(() => {
                setErrorMessage('Une erreur est survenue lors de la mise à jour du produit');
                setSuccessMessage('');
            });
    };

    if (!product || !categories) {
        return <div>Loading...</div>;
    }

    return (
        <Template title={"Détail Produit"}>
            <div className="container">
                <div className="row justify-content-center align-items-center">
                    <div className="col-md-6">
                        {successMessage && <div className="alert alert-success">{successMessage}</div>}
                        {errorMessage && <div className="alert alert-danger">{errorMessage}</div>}

                        {editedProduct && (
                            <div>
                                <div className="form-row">
                                    <div className="form-group col-md-6">
                                        <label>ID</label>
                                        <input type="text" name="date_ajout" value={product.id_produit} className="form-control" readOnly />
                                    </div>
                                    <div className="form-group col-md-6">
                                        <label>Date Ajout</label>
                                        <input type="text" name="date_ajout" value={new Date(product.date_ajout.date).toLocaleString()} className="form-control" readOnly />
                                    </div>
                                </div>
                                <div className="form-group">
                                    <label>Nom</label>
                                    <input type="text" name="nom_produit" value={editedProduct.nom_produit} className="form-control" onChange={handleChange} />
                                </div>
                                <DropdownCategory categories={categories} selectedCategoryId={editedProduct.categorie.id_categorie || ""} onChange={handleChange} />
                                <div className="form-group">
                                    <label>Description</label>
                                    <textarea name="description" value={editedProduct.description} className="form-control" onChange={handleChange} />
                                </div>
                                <div className="form-row">
                                    <div className="form-group col-md-6">
                                        <label>Prix</label>
                                        <input type="text" name="prix" value={editedProduct.prix} className="form-control" onChange={handleChange} />
                                    </div>
                                    <div className="form-group col-md-6">
                                        <label>Stock</label>
                                        <input type="text" name="stock" value={editedProduct.stock} className="form-control" onChange={handleChange} />
                                    </div>
                                </div>
                                <button className="btn btn-success m-3" type="submit" onClick={handleSave}>
                                    Sauvegarder
                                </button>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </Template>
    );
}

export default DetailProduct;
