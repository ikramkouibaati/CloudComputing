import React, { useEffect, useState } from 'react';
import axios from 'axios';

import Table from "../../components/backoffice/Table";
import Template from "../../components/layouts/backoffice/Template";

function ListMessages() {

    const [messages, setMessages] = useState([]);
    const columns = ["id_contact", "id_utilisateur", "email", "texte"];

    useEffect(() => {
        axios.get(`http://127.0.0.1:8000/api/contact`).then(res => {
            setMessages(res.data);
        });
    }, []);

    return (
        <Template title={"Contact - Messages"}>
            <div>
                <div className="m-5">
                    <Table columns={columns} data={messages} />
                </div>
            </div>
        </Template>
    )
}

export default ListMessages;