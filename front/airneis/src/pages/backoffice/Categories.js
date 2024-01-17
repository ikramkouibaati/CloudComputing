import axios from 'axios';
import React, { useEffect, useRef, useState } from 'react';
import Table from "../../components/backoffice/Table";
import Template from '../../components/layouts/backoffice/Template';

function Categories() {
    const columns = ['id_categorie', 'nom_categorie'];
    const [categories, setCategories] = useState([]);
    const [successMessage, setSuccessMessage] = useState('');
    const [errorMessage, setErrorMessage] = useState('');
    const messageRef = useRef(null);
    const [checkedRows, setCheckedRows] = useState([]);

    useEffect(() => {
        axios.get(`http://127.0.0.1:8000/api/categories`).then(res => {
            setCategories(res.data);
        });
    }, []);

    const handleDelete = (id) => {
        if (window.confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')) {
            setSuccessMessage('');
            setErrorMessage('');

            axios
                .delete(`http://127.0.0.1:8000/api/categories/${id}`)
                .then(() => {
                    setCategories((prevCategories) => prevCategories.filter((category) => category.id_categorie !== id));
                    setSuccessMessage('Supprimé avec succès !');
                    scrollToAlert();
                })
                .catch((error) => {
                    console.error('Erreur :', error);
                    setErrorMessage('Erreur dans la suppression');
                    scrollToAlert();
                });
        }
    };

    const handleMultipleDelete = () => {
        if (checkedRows.length === 0) {
            setErrorMessage('Aucune catégorie sélectionnée pour la suppression');
            scrollToAlert();
            return;
        }

        const selectedProductIds = checkedRows;
        if (window.confirm('Êtes-vous sûr de vouloir supprimer ces catégories ?')) {

            axios
                .delete(`http://127.0.0.1:8000/api/categories/multiple/${selectedProductIds}`)
                .then(() => {
                    setCategories((prevCategories) => prevCategories.filter((category) => !checkedRows.includes(category.id_categorie)));
                    setSuccessMessage('Catégories supprimés avec succès !');
                    setCheckedRows([]);
                    scrollToAlert();
                })
                .catch((error) => {
                    setErrorMessage('Erreur dans la suppression des catégories');
                    scrollToAlert();
                });
        }
    };

    const handleCheckboxChange = (id, isChecked) => {
        if (isChecked) {
            setCheckedRows((prevRows) => [...prevRows, id]);
        } else {
            setCheckedRows((prevRows) => prevRows.filter((rowId) => rowId !== id));
        }
    };

    const scrollToAlert = () => {
        messageRef.current.scrollIntoView({ behavior: 'smooth' });
    };

    return (
        <Template title={"Catégories"}>
            <div className="MainDiv mb-4">
                <div className="row">
                    <div className="text-center" style={{ marginTop: '20px', marginBottom: '70px' }}>
                        <a href="/backoffice/category/add" className="btn btn-info mr-4" style={{ width: '260px' }}>
                            <span className="text">Ajouter une nouvelle catégorie</span>
                        </a>
                        <button
                            className="btn btn-danger"
                            style={{ width: '200px' }}
                            onClick={handleMultipleDelete}
                            disabled={checkedRows.length === 0}
                        >
                            <span className="text">Supprimer la sélection</span>
                        </button>

                    </div>
                </div>
                <div className="row justify-content-center align-items-center">
                    <div className="col-md-4">
                        {successMessage && <div className="alert alert-success" ref={messageRef}>{successMessage}</div>}
                        {errorMessage && <div className="alert alert-danger" ref={messageRef}>{errorMessage}</div>}
                    </div>
                </div>
                <div style={{ margin: '50px 250px' }}>
                    <Table
                        data={categories}
                        columns={columns}
                        path={"/backoffice/category"}
                        paramKey={"id_categorie"}
                        onDelete={handleDelete}
                        onBulkDelete={handleMultipleDelete}
                        checkedRows={checkedRows}
                        onCheckboxChange={handleCheckboxChange}
                    />
                </div>
            </div>
        </Template>
    );
}

export default Categories;