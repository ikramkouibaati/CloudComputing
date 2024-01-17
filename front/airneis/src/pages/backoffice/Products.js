import React, { useEffect, useRef, useState } from 'react';
import axios from 'axios';
import Table from '../../components/backoffice/Table';
import Template from '../../components/layouts/backoffice/Template';
import DropdownCategory from '../../components/backoffice/DrodownCategory';

const Products = () => {
    const [products, setProducts] = useState([]);
    const [categories, setCategories] = useState([]);
    const [checkedRows, setCheckedRows] = useState([]);
    const columns = ['id_produit', 'nom_produit', 'nom_categorie', 'description', 'prix', 'stock', 'date_ajout'];
    const [successMessage, setSuccessMessage] = useState('');
    const [errorMessage, setErrorMessage] = useState('');
    const messageRef = useRef(null);
    const [newPrice, setNewPrice] = useState('');
    const [newStock, setNewStock] = useState('');
    const [selectedCategoryId, setSelectedCategoryId] = useState('');
    const [selectedCategory, setSelectedCategory] = useState('');

    useEffect(() => {
        axios
            .get(`http://127.0.0.1:8000/api/produits`)
            .then((res) => {
                setProducts(res.data);
            })
            .catch((error) => {
                console.error('Error fetching products:', error);
            });

        axios
            .get(`$http://127.0.0.1:8000/api/categories`)
            .then((res) => {
                setCategories(res.data);
            })
            .catch((error) => {
                console.error('Error fetching categories:', error);
            });

    }, []);

    const handleIndividualDelete = (id) => {
        axios
            .delete(`http://127.0.0.1:8000/api/produits/${id}`)
            .then(() => {
                setProducts((prevProducts) => prevProducts.filter((product) => product.id_produit !== id));
                setSuccessMessage('Produit supprimé avec succès !');
                scrollToAlert();
            })
            .catch((error) => {
                console.error('Erreur :', error);
                setErrorMessage('Erreur dans la suppression du produit');
                scrollToAlert();
            });
    };

    const handleMultipleDelete = () => {
        if (checkedRows.length === 0) {
            setErrorMessage('Aucun produit sélectionné pour la suppression');
            scrollToAlert();
            return;
        }

        const selectedProductIds = checkedRows;
        if (window.confirm('Êtes-vous sûr de vouloir supprimer ces produits ?')) {

            axios
                .delete(`http://127.0.0.1:8000/api/produits/multiple`, {
                    data: { ids: selectedProductIds },
                })
                .then(() => {
                    setProducts((prevProducts) => prevProducts.filter((product) => !checkedRows.includes(product.id_produit)));
                    setSuccessMessage('Produits supprimés avec succès !');
                    setCheckedRows([]);
                    scrollToAlert();
                })
                .catch((error) => {
                    setErrorMessage('Erreur dans la suppression des produits');
                    scrollToAlert();
                });
        }
    };

    const handleDelete = (id) => {
        if (window.confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
            handleIndividualDelete(id);
        }
    };

    const handleMultipleModify = () => {
        if (checkedRows.length === 0) {
            setErrorMessage('Aucun produit sélectionné pour la modification');
            scrollToAlert();
            return;
        }

        if (newPrice !== '' && isNaN(parseFloat(newPrice))) {
            setErrorMessage('Le prix doit être un nombre valide.');
            scrollToAlert();
            return;
        }
        if (newStock !== '' && isNaN(parseInt(newStock))) {
            setErrorMessage('Le stock doit être un nombre entier valide.');
            scrollToAlert();
            return;
        }

        if (newPrice === '' && newStock === '' && selectedCategoryId === '') {
            setErrorMessage('Veuillez fournir au moins un champ à modifier.');
            scrollToAlert();
            return;
        }

        const dataToUpdate = {};
        if (newPrice !== '') {
            dataToUpdate.prix = parseFloat(newPrice);
        }
        if (newStock !== '') {
            dataToUpdate.stock = parseInt(newStock);
        }
        if (selectedCategory !== '') {
            dataToUpdate.nom_categorie = selectedCategory.nom_categorie;
        }

        const selectedProductIds = checkedRows;
        if (window.confirm('Êtes-vous sûr de vouloir modifier ces produits ?')) {
            axios
                .put(`http://127.0.0.1:8000/api/produits`, {
                    ids: selectedProductIds,
                    categorie: selectedCategoryId !== '' ? parseInt(selectedCategoryId) : null,
                    prix: newPrice ?? undefined,
                    stock: newStock ?? undefined,
                })
                .then((response) => {
                    setProducts((prevProducts) =>
                        prevProducts.map((product) => {
                            if (checkedRows.includes(product.id_produit)) {
                                return {
                                    ...product,
                                    prix: dataToUpdate.prix !== undefined ? dataToUpdate.prix : product.prix,
                                    stock: dataToUpdate.stock !== undefined ? dataToUpdate.stock : product.stock,
                                    nom_categorie: dataToUpdate.nom_categorie !== undefined ? dataToUpdate.nom_categorie : product.nom_categorie
                                };

                            }
                            return product;
                        })
                    );

                    setNewPrice('');
                    setNewStock('');
                    setSelectedCategoryId('');
                    setSuccessMessage('Produits modifiés avec succès !');
                    setCheckedRows([]);
                    scrollToAlert();

                    setSelectedCategory((prevCategory) =>
                        prevCategory && selectedCategoryId !== ''
                            ? {
                                ...prevCategory,
                                nom_categorie: selectedCategory.nom_categorie,
                            }
                            : prevCategory
                    );
                })
                .catch((error) => {
                    setErrorMessage('Erreur dans la modification des produits');
                    scrollToAlert();
                });
        }

        setCheckedRows([]);
    };

    const handleCheckboxChange = (id, isChecked) => {
        if (isChecked) {
            setCheckedRows((prevRows) => [...prevRows, id]);
        } else {
            setCheckedRows((prevRows) => prevRows.filter((rowId) => rowId !== id));
        }
    };

    const handleCategoryChange = (event) => {
        const categoryId = event.target.value;
        setSelectedCategoryId(categoryId);

        const selectedCat = categories.find((category) => category.id_categorie === parseInt(categoryId));
        setSelectedCategory(selectedCat);
    };

    const scrollToAlert = () => {
        messageRef.current.scrollIntoView({ behavior: 'smooth' });
    };

    return (
        <Template title={'Produits'}>
            <div>
                <div className="MainDiv mb-4">
                    <div className="row">
                        <div className="text-center" style={{ marginTop: '20px', marginBottom: '50px' }}>
                            <a href="/backoffice/product/add" className="btn btn-success mr-5">
                                <span className="text">Ajouter un nouveau produit</span>
                            </a>
                            <button
                                className="btn btn-danger mr-4"
                                onClick={handleMultipleDelete}
                                disabled={checkedRows.length === 0}
                            >
                                <span className="text">Supprimer la sélection</span>
                            </button>
                            <div className="mx-auto mt-5" style={{ backgroundColor: "#f1f1f1", width: "700px", padding: "20px", borderRadius: "10px" }}>
                                <div className="row">
                                    <div className="col">
                                        <label>Prix</label>
                                        <input
                                            className="form-control"
                                            type="text"
                                            value={newPrice}
                                            onChange={(e) => setNewPrice(e.target.value)}
                                        />
                                    </div>
                                    <div className="col">
                                        <label>Stock</label>
                                        <input
                                            className="form-control"
                                            type="text"
                                            value={newStock}
                                            onChange={(e) => setNewStock(e.target.value)}
                                        />
                                    </div>
                                    <div className="col-6">
                                        <DropdownCategory
                                            categories={categories}
                                            selectedCategoryId={selectedCategoryId}
                                            onChange={handleCategoryChange}
                                        />
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col">
                                        <button
                                            className="btn btn-primary"
                                            onClick={handleMultipleModify}
                                            disabled={checkedRows.length === 0}
                                        >
                                            <span className="text">Modifier la sélection</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="row justify-content-center align-items-center">
                        <div className="col-md-4">
                            {successMessage && (
                                <div className="alert alert-success" ref={messageRef}>
                                    {successMessage}
                                </div>
                            )}
                            {errorMessage && (
                                <div className="alert alert-danger" ref={messageRef}>
                                    {errorMessage}
                                </div>
                            )}
                        </div>
                    </div>
                    <div className="m-4">
                        <Table
                            data={products}
                            columns={columns}
                            path="/backoffice/product"
                            paramKey="id_produit"
                            onDelete={handleDelete}
                            onBulkDelete={handleMultipleDelete}
                            checkedRows={checkedRows}
                            onCheckboxChange={handleCheckboxChange}
                        />
                    </div>
                </div>
            </div>
        </Template >
    );
};

export default Products;
