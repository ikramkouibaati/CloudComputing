import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';
import { format } from "date-fns-tz";


const CommandesList = () => {
  const [commands, setCommands] = useState([]);
  const [activeCommand, setActiveCommand] = useState(null);
  const [commandsDetails, setCommandsDetails] = useState([]);

  useEffect(() => {
    const fetchCommands = async () => {
      try {
        const [commandsResponse, commandsDetailsResponse] = await Promise.all([
          axios.get('http://127.0.0.1:8000/api/commandes', {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`,
            },
          }),
          axios.get('http://127.0.0.1:8000/api/commande-details', {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`,
            },
          }),
        ]);

        setCommands(commandsResponse.data);
        setCommandsDetails(commandsDetailsResponse.data);
      } catch (error) {
        console.error('An error occurred while fetching commands:', error);
      }
    };

    fetchCommands();
  }, []);

  const handleAccordionClick = (commandId) => {
    setActiveCommand(activeCommand === commandId ? null : commandId);
  };


  const formatDate = (dateString) => {
    const date = new Date(dateString);
    return format(date, "dd/MM/yyyy", { timeZone: "UTC" });
  };
  

  return (
    <div className="container mt-4">
      <h2 className="mb-4">Liste des commandes</h2>
      {commands.map((commande) => (
        <div key={commande.id_commande} className="card mb-4">
          <div
            className="card-header"
            onClick={() => handleAccordionClick(commande.id_commande)}
            style={{ cursor: 'pointer' }}
          >
            <h5 className="mb-0">
              Commande du {formatDate(commande.date_commande)}
            </h5>
          </div>
          {activeCommand === commande.id_commande && (
            <div className="card-body">
              <p>Date: {formatDate(commande.date_commande)}</p>
              <p>Prix Total: {commande.prix_total}</p>
           
              {commandsDetails.map((commandeDetail) => {
                if (commandeDetail.id_commande === commande.id_commande) {
                  return (
                    <div key={commandeDetail.id_produit}>
                      <hr className="my-2" /> 
                      <p>Produit: {commandeDetail.nom_produit}</p>       
                      <p>Quantité: {commandeDetail.quantite}</p>
                      <p>Description: {commandeDetail.description}</p>
                      <p>Prix du produit: {commandeDetail.prix}</p>
                    </div>
                  );
                }
                return null;
              })}
            </div>
          )}
        </div>
      ))}
    </div>
  );
};

export default CommandesList;
