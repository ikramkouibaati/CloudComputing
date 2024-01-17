import { useEffect, useState } from 'react';
import axios from 'axios';

import DropdownCategory from '../../components/backoffice/DrodownCategory';
import Template from '../../components/layouts/backoffice/Template';

function AddProduct() {

    const [categories, setCategories] = useState([]);
    const [successMessage, setSuccessMessage] = useState('');
    const [errorMessage, setErrorMessage] = useState('');
    const [editedProduct, setEditedProduct] = useState({
        nom_produit: '',
        id_categorie: '',
        description: '',
        prix: '',
        stock: ''
    });

    useEffect(() => {
        const fetchCategories = async () => {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/categories`);
                setCategories(response.data);
            } catch (error) {
                console.log('Error fetching categories');
            }
        };

        fetchCategories();
    }, []);

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

        if (
            !editedProduct.nom_produit ||
            !editedProduct.description ||
            !editedProduct.prix ||
            !editedProduct.stock
        ) {
            setErrorMessage('Veuillez remplir tous les champs');
            setSuccessMessage('');
            return;
        }

        if (isNaN(editedProduct.prix) || isNaN(editedProduct.stock)) {
            setErrorMessage('Veuillez entrer des valeurs numériques pour le prix et/ou le stock');
            setSuccessMessage('');
            return;
        }

        const newProduct = {
            ...editedProduct,
            id_categorie: editedProduct.categorie.id_categorie
        };

        axios
            .post(`http://127.0.0.1:8000/api/produits`, newProduct)
            .then(() => {
                setSuccessMessage('Produit ajouté avec succès');
                setErrorMessage('');
                setEditedProduct({
                    nom_produit: '',
                    id_categorie: '',
                    description: '',
                    prix: '',
                    stock: ''
                });

            })
            .catch(() => {
                setErrorMessage('Une erreur est survenue lors de l\'ajout du produit');
                setSuccessMessage('');
            });
    };

    return (
        <Template title={"Ajouter un produit"}>
            <div className="container">
                <div className="row justify-content-center align-items-center">
                    <div className="col-md-6">
                        {successMessage && <div className="alert alert-success">{successMessage}</div>}
                        {errorMessage && <div className="alert alert-danger">{errorMessage}</div>}

                        <div className="form-group">
                            <label>Nom</label>
                            <input type="text" name="nom_produit" value={editedProduct.nom_produit} className="form-control" onChange={handleChange} />
                        </div>
                        <DropdownCategory categories={categories} selectedCategoryId={editedProduct.categorie?.id_categorie || ""} onChange={handleChange} />
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
                            Ajouter
                        </button>
                    </div>
                </div>
            </div>
        </Template>
    )
}

export default AddProduct;