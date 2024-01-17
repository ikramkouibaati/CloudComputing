import { useState } from 'react';
import axios from 'axios';
import Template from '../../components/layouts/backoffice/Template';

function AddCategory() {
    const [nomCategorie, setNomCategorie] = useState('');
    const [successMessage, setSuccessMessage] = useState('');
    const [errorMessage, setErrorMessage] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();

        if (!nomCategorie) {
            setErrorMessage('Veuillez saisir un nom pour la catégorie');
            setSuccessMessage('');
            return;
        }

        axios
            .post(`http://127.0.0.1:8000/api/categories`, {
                nom_categorie: nomCategorie
            })
            .then(() => {
                setSuccessMessage('Catégorie ajoutée avec succès');
                setErrorMessage('');
                setNomCategorie('');
            })
            .catch(() => {
                setErrorMessage("Une erreur est survenue lors de l'ajout de la catégorie");
                setSuccessMessage('');
            });
    };

    return (
        <Template title={'Ajouter une catégorie'}>
            <div className="container">
                <div className="row justify-content-center align-items-center">
                    <div className="col-md-6">
                        {successMessage && <div className="alert alert-success">{successMessage}</div>}
                        {errorMessage && <div className="alert alert-danger">{errorMessage}</div>}

                        <form onSubmit={handleSubmit}>
                            <div className="form-group">
                                <label>Nom</label>
                                <input
                                    type="text"
                                    name="nom_categorie"
                                    value={nomCategorie}
                                    className="form-control"
                                    onChange={(e) => setNomCategorie(e.target.value)}
                                />
                            </div>

                            <button className="btn btn-success m-3" type="submit">
                                Ajouter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </Template>
    );
}

export default AddCategory;
