import React, { useState } from "react";
import { Col, Button, Row, Container, Card, Form } from "react-bootstrap";
import axios from 'axios';
import { useNavigate } from 'react-router-dom'

export default function  RegisterForm() {
    const [nom, setNom] = useState("");
    const [prenom, setPrenom] = useState("");
    const [email, setEmail] = useState("");
    const [mdp, setMdp] = useState("");
    const [telephone, setTelephone] = useState("");
    const navigate = useNavigate();


    const handleRegister = async (event) => {
      event.preventDefault();
      const registerData = {
        nom: nom,
        prenom: prenom,
        email: email,
        mdp: mdp,
        telephone: telephone,
     
      };
      const result = await axios.post('http://127.0.0.1:8000/api/utilisateur', registerData);
      console.log(result.data);
      navigate("/login")
    }


    return (
      <form onSubmit={handleRegister}>
   
      <Container>
        <Row className="vh-100 d-flex justify-content-center align-items-center">
          <Col md={8} lg={6} xs={12}>
            <div className="border border-3 border-primary"></div>
            <Card className="shadow">
              <Card.Body>
                <div className="mb-3 mt-md-4">
                  <h2 className="fw-bold mb-2 text-uppercase ">Brand</h2>
                  
                  <div className="mb-3">
                   
                    <Form.Group className="mb-3">
                        <Form.Label className="text-center">
                         Nom
                        </Form.Label>
                        <Form.Control type="text" placeholder="Enter nom" value={nom} onChange={(e) => setNom(e.target.value)} required/>
                      </Form.Group>

                      <Form.Group className="mb-3" >
                        <Form.Label className="text-center">
                          Prenom
                        </Form.Label>
                        <Form.Control type="text" placeholder="Enter prenom" value={prenom} onChange={(e) => setPrenom(e.target.value)} required />
                      </Form.Group>

                      <Form.Group className="mb-3" controlId="formBasicEmail">
                        <Form.Label className="text-center">
                          Email
                        </Form.Label>
                        <Form.Control type="email" placeholder="Enter email" value={email}  onChange={(e) => setEmail(e.target.value)} required />
                      </Form.Group>

                      <Form.Group className="mb-3">
                        <Form.Label className="text-center">
                         Telephone
                        </Form.Label>
                        <Form.Control type="text" placeholder="Enter telephone" value={telephone}  onChange={(e) => setTelephone(e.target.value)} required/>
                      </Form.Group>

                      <Form.Group
                        className="mb-3"
                        controlId="formBasicPassword"
                      >
                        <Form.Label>Mot de passe</Form.Label>
                        <Form.Control type="password" placeholder="Password" value={mdp}  onChange={(e) => setMdp(e.target.value)} required/>
                      </Form.Group>
                      <Form.Group
                        className="mb-3"
                        controlId="formBasicCheckbox"
                      >
                       
                      </Form.Group>
                      
                        <Button variant="outline-primary" type="submit">
                          Inscription
                        </Button>
                                         
                  </div>
                </div>
              </Card.Body>
            </Card>
          </Col>
        </Row>
      </Container>
      </form>
    );
  };
  