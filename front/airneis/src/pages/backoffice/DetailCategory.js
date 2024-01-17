import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import axios from 'axios';

import Template from "../../components/layouts/backoffice/Template";

function DetailCategory() {

    const { id } = useParams();
    const [category, setCategory] = useState('');
    const [updatedCategory, setUpdatedCategory] = useState({ nom_categorie: '' });
    const [successMessage, setSuccessMessage] = useState('');
    const [errorMessage, setErrorMessage] = useState('');

    useEffect(() => {
        axios.get(`http://127.0.0.1:8000/api/categories/${id}`).then(res => {
            setCategory(res.data);
            setUpdatedCategory(res.data);
        });
    }, [id]);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setUpdatedCategory(prevState => ({
            ...prevState,
            [name]: value
        }));
    };

    const handleUpdate = () => {
        axios.put(`http://127.0.0.1:8000/api/categories/${id}`, updatedCategory)
            .then(() => {
                setSuccessMessage('Catégorie modifiée avec succès');
                setErrorMessage('');
            })
            .catch(() => {
                setErrorMessage('Une erreur est survenue lors de la mise à jour de la catégorie');
                setSuccessMessage('');
            });
    };

    return (
        <Template title={"Détail Catégorie"}>
            <div className="container">
                <div className="row justify-content-center align-items-center">
                    <div className="col-md-6">
                        {successMessage && <div className="alert alert-success">{successMessage}</div>}
                        {errorMessage && <div className="alert alert-danger">{errorMessage}</div>}

                        <div className="form-row">
                            <div className="form-group col-md-6">
                                <label>ID</label>
                                <input type="text" name="id_categorie" value={category.id_categorie || ''} className="form-control" readOnly />
                            </div>
                        </div>
                        <div className="form-row">
                            <div className="form-group">
                                <label>Nom</label>
                                <input type="text" name="nom_categorie" value={updatedCategory.nom_categorie} className="form-control" onChange={handleChange} />
                            </div>
                        </div>
                        <button className="btn btn-success mt-3" type="submit" onClick={handleUpdate}>
                            Sauvegarder
                        </button>
                    </div>
                </div>
            </div>
        </Template>
    )
}

export default DetailCategory;