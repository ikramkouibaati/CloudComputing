import React, { useEffect, useRef } from 'react';
import { Link } from 'react-router-dom';
import $ from 'jquery';
import 'datatables.net-dt/js/dataTables.dataTables';
import 'datatables.net-dt/css/jquery.dataTables.min.css';

const Table = ({ columns, data, path, paramKey, onDelete = null, checkedRows = null, onCheckboxChange = null }) => {
    const tableRef = useRef(null);

    useEffect(() => {
        if (data && data.length > 0) {
            $(tableRef.current).DataTable({
                autoWidth: true,
                retrieve: true,
                language: {
                    lengthMenu: 'Afficher _MENU_ éléments par page',
                    zeroRecords: 'Nothing found - sorry',
                    info: 'Affichage page _PAGE_ sur _PAGES_',
                    infoEmpty: 'Pas de données disponibles',
                    infoFiltered: '(filtré pour _MAX_ total éléments)',
                    search: 'Rechercher',
                    paginate: {
                        previous: 'Précédent',
                        next: 'Suivant',
                    },
                },
            });
        }
    }, [data]);

    const handleDelete = (id) => {
        onDelete(id);
    };

    const handleCheckboxChange = (event, id) => {
        onCheckboxChange(id, event.target.checked);
    };

    return (
        <div>
            <table ref={tableRef} id="example" className="table table-hover table-bordered">
                <thead>
                    <tr>
                        {checkedRows !== null && handleCheckboxChange !== null ? (
                            <th>Sélectionner</th>
                        ) : (
                            ''
                        )}
                        {columns.map((column, index) => (
                            <th key={index}>{column}</th>
                        ))}
                        {path && paramKey && <th>actions</th>}
                    </tr>
                </thead>
                <tbody>
                    {data.map((result, index) => (
                        <tr key={index}>
                            {checkedRows !== null && handleCheckboxChange !== null ? (
                                <td style={{ textAlign: 'center' }}>
                                    <input
                                        type="checkbox"
                                        id={`checkbox-${index}`}
                                        checked={checkedRows.includes(result[paramKey])}
                                        onChange={(event) => handleCheckboxChange(event, result[paramKey])}
                                    />
                                </td>
                            ) : (
                                ''
                            )}
                            {columns.map((column, columnIndex) => (
                                <td key={columnIndex}>
                                    <div>
                                        {column === 'date_ajout'
                                            ? new Date(result[column]).toLocaleDateString()
                                            : column === 'prix'
                                                ? `${result[column]} €`
                                                : result[column]}
                                    </div>
                                </td>
                            ))}
                            {path && paramKey && (
                                <td style={{ display: 'flex', alignItems: 'center' }}>
                                    <Link to={`${path}/${result[paramKey]}`} className="btn btn-primary mr-3">
                                        Modifier
                                    </Link>
                                    <button className="btn btn-danger" onClick={() => handleDelete(result[paramKey])}>
                                        Supprimer
                                    </button>
                                </td>
                            )}
                        </tr>
                    ))}
                </tbody>
            </table>
        </div >
    );
};

export default Table;
