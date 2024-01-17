import React, { useState, useEffect } from "react";
import { Button, Card, Row, Col, Container, Form, Modal } from "react-bootstrap";
import OrderSteps from "./OrderSteps";
import { Link } from "react-router-dom";
import axios from "axios";
import jwt_decode from "jwt-decode";


function Cart() {
  const [cartItems, setCartItems] = useState([]);
  const [currentStep, setCurrentStep] = useState(1);
  const [addressOption, setAddressOption] = useState("");
  const [savedDeliveryAddresses, setSavedDeliveryAddresses] = useState([]);
  const [savedBillingAddresses, setSavedBillingAddresses] = useState([]);
  const [paymentMethod, setPaymentMethod] = useState("card");
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [isLogged, setIsLogged] = useState(false);
  const [orderResponse, setOrderResponse] = useState("");
  const [selectedBillingAddressId, setSelectedBillingAddressId] = useState(null);
  const [selectedDeliveryAddressId, setSelectedDeliveryAddressId] = useState(null);


  const getTotal = () => {
    let total = 0;
    cartItems.forEach((item) => {
      total += item.quantity * item.price;
    });
    return total;
  };

  const decreaseQuantity = (item) => {
    if (item.quantity > 1) {
      item.quantity -= 1;
      updateCart([...cartItems]);
    }
  };

  const increaseQuantity = (item) => {
    item.quantity += 1;
    updateCart([...cartItems]);
  };

  const removeFromCart = (item) => {
    const updatedCartItems = cartItems.filter((cartItem) => cartItem.id !== item.id);
    updateCart(updatedCartItems);
  };

  const updateCart = (updatedCartItems) => {
    localStorage.setItem("cartItems", JSON.stringify(updatedCartItems));
    setCartItems(updatedCartItems);
  };

  useEffect(() => {
    const storedCartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
    setCartItems(storedCartItems);

    const storedCurrentStep = localStorage.getItem("currentStep");
    if (storedCurrentStep) {
      setCurrentStep(Number(storedCurrentStep));
    }
  }, []);

  useEffect(() => {
    localStorage.setItem("cartItems", JSON.stringify(cartItems));
    localStorage.setItem("currentStep", currentStep);
  }, [cartItems, currentStep]);

  const handleProceedToDelivery = () => {
    setCurrentStep(2);
  };

  const handleProceedToDeliveryFacturation = () => {
    setCurrentStep(3);
  };

  const handleProceedToPayment = () => {
    setCurrentStep(4);
  };

  const handleProceedToConfirmation = () => {
    setCurrentStep(4);
  };

  const handleAddressOptionChange = (e) => {
    setAddressOption(e.target.value);
    setSelectedDeliveryAddressId(null);
    setSelectedBillingAddressId(null);
  };

  useEffect(() => {

    const token = localStorage.getItem("token");
    const isLogged = !!token;
    setIsLogged(isLogged);

   
    if (isLogged) {
      const savedDeliveryAddresses = JSON.parse(localStorage.getItem("savedDeliveryAddresses")) || [];
      const savedBillingAddresses = JSON.parse(localStorage.getItem("savedBillingAddresses")) || [];
      setSavedDeliveryAddresses(savedDeliveryAddresses);
      setSavedBillingAddresses(savedBillingAddresses);


      const config = {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      };

      const fetchSavedAddresses = async () => {
        try {
          const deliveryResponse = await axios.get("http://127.0.0.1:8000/api/adresses_livraisonUser", config);
          const deliveryData = deliveryResponse.data;
          setSavedDeliveryAddresses(deliveryData.adressesLivraison);

          const billingResponse = await axios.get("http://127.0.0.1:8000/api/adresses_facturationUser", config);
          const billingData = billingResponse.data;
          setSavedBillingAddresses(billingData.adressesFacturation);
        } catch (error) {
          console.log("Error fetching saved addresses:", error);
        }
      };

      fetchSavedAddresses();
    }
  }, [isLogged]);


const handlePaymentSubmit = async () => {

  const data = {
    produits: cartItems.map((item) => ({ id_produit: item.id, quantite: item.quantity })),
    id_adresse_facturation: selectedBillingAddressId,
    id_adresse_livraison: selectedDeliveryAddressId,
  };

  try {
    const token = localStorage.getItem("token");
    if (!token) {
      alert("Please log in to proceed with the payment.");
      return;
    }

    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    };

    const response = await axios.post("http://127.0.0.1:8000/api/commande", data, config);
    setOrderResponse(response.data); 

    
    localStorage.removeItem("cartItems");
    setCartItems([]); 
    setIsModalOpen(true);
    
    setCurrentStep(1);

    
  } catch (error) {

    console.error("Error creating the order:", error);
  }
};


  const handleModalClose = () => {
    setIsModalOpen(false);
  };

  const handleBack = () => {
    setCurrentStep((prevStep) => prevStep - 1);
  };

  const handlePaymentMethodChange = (event) => {
    setPaymentMethod(event.target.value);
  };


  return (
    <div className="container">
      <h5>Panier</h5>
      <OrderSteps currentStep={currentStep} />

      {currentStep === 1 && (
        <Row>
          <Col lg={8}>
            {cartItems.length === 0 ? (
              <p>Your cart is empty.</p>
            ) : (
              <>
                {cartItems.map((item) => (
                  <Card key={item.id} className="mb-3">
                    <Card.Body>
                      <Card.Title>{item.name}</Card.Title>
                      <Card.Text>Price: {item.price.toFixed(2)}</Card.Text>
                      <div className="d-flex justify-content-between align-items-center">
                        <div>
                          Quantity: {item.quantity} <br/>
                          <Button variant="outline-primary" size="sm" onClick={() => decreaseQuantity(item)}>
                            -
                          </Button>{" "}
                          <Button variant="outline-primary" size="sm" onClick={() => increaseQuantity(item)}>
                            +
                          </Button>
                        </div>
                        <Button variant="outline-danger" size="sm" onClick={() => removeFromCart(item)}>
                          Remove
                        </Button>
                      </div>
                      <Card.Text>Total: {(item.quantity * item.price).toFixed(2)}</Card.Text>
                    </Card.Body>
                  </Card>
                ))}
              </>
            )}
          </Col>
          <Col lg={4}>
            <Card>
              <Card.Body>
                <Card.Title>Order Summary</Card.Title>
                <Card.Text>Total: {getTotal().toFixed(2)}</Card.Text>
              </Card.Body>
            </Card>
            <Button variant="outline-primary" onClick={handleProceedToDelivery}>
              Proceed to Delivery
            </Button>
          </Col>
        </Row>
      )}

      {currentStep === 2 && (
        <Row>
          <Col lg={20}>
            <br />
            <Container>
              <Row className="justify-content-center align-items-center">
                <Col xs={10} md={10}>
                  <Form>
                    <Form.Group>
                      <Form.Label>Select Address Livraison Option:</Form.Label>
                     
                      <Form.Check
                        type="radio"
                        name="addressOption"
                        id="savedAddressOption"
                        label="Use Saved Address"
                        value="savedAddress"
                        checked={addressOption === "savedAddress"}
                        onChange={handleAddressOptionChange}
                      />
                    </Form.Group>

                    {addressOption === "savedAddress" && (
                      <Form.Group controlId="savedAddress">
                      
                        <Form.Label>List of Saved Addresses</Form.Label>
                        {savedDeliveryAddresses.map((address) => (
                         <Form.Check
                         key={address.id_adresse_livraison}
                         type="radio"
                         name="savedDeliveryAddress"
                         id={`savedDeliveryAddress-${address.id_adresse_livraison}`}
                         label={address.rue}
                         value={address.id_adresse_livraison}
                         onChange={() => setSelectedDeliveryAddressId(address.id_adresse_livraison)}
                         checked={selectedDeliveryAddressId === address.id_adresse_livraison}
                       />
                       
                        ))}
                      </Form.Group>
                    )}

                    <br />
                    <Button variant="outline-primary" onClick={handleProceedToDeliveryFacturation}>
                      Delivery 
                    </Button>
                    <Button variant="outline-secondary" onClick={handleBack}>
                     Retour
                   </Button>
                  </Form>
                </Col>
              </Row>
            </Container>
          </Col>
        </Row>
      )}

{currentStep === 3 && (
        <Row>
          <Col lg={20}>
            <br />
            <Container>
              <Row className="justify-content-center align-items-center">
                <Col xs={10} md={10}>
                  <Form>
                    <Form.Group>
                      <Form.Label>Select Address Facturation Option:</Form.Label>
                    
                      <Form.Check
                        type="radio"
                        name="addressOption"
                        id="savedAddressOption"
                        label="Use Saved Address"
                        value="savedAddress"
                        checked={addressOption === "savedAddress"}
                        onChange={handleAddressOptionChange}
                      />
                    </Form.Group>

                    {addressOption === "savedAddress" && (
                      <Form.Group controlId="savedAddress">                    
                        <Form.Label>List of Saved Addresses</Form.Label>
                        {savedBillingAddresses.map((address) => (
                        <Form.Check
                        key={address.id_adresse_facturation}
                        type="radio"
                        name="savedBillingAddress"
                        id={`savedBillingAddress-${address.id_adresse_facturation}`}
                        label={address.rue}
                        value={address.id_adresse_facturation}
                        onChange={() => setSelectedBillingAddressId(address.id_adresse_facturation)}
                        checked={selectedBillingAddressId === address.id_adresse_facturation}
                      />
                      
                        ))}
                      </Form.Group>
                    )}

                    <br />
                    <Button variant="outline-primary" onClick={handleProceedToPayment}>
                      Proceed to Payment
                    </Button>
                    <Button variant="outline-secondary" onClick={handleBack}>
                     Retour
                   </Button>
                  </Form>
                </Col>
              </Row>
            </Container>
          </Col>
        </Row>
      )}


      {currentStep === 4 && (
        <Row>
          <Col lg={8}>
          
          <Container className="d-flex justify-content-center align-items-center">
      <div className="p-4 border rounded" style={{ width: "50%", border: "1px solid #ccc" }}>
        <h6 className="mb-2 d-flex justify-content-center align-items-center">
          Payment Details
        </h6>
        <Modal show={isModalOpen} onHide={handleModalClose} centered backdrop="static">
          <Modal.Header closeButton>
            <Modal.Title>Votre paiement a été effectué avec succès.</Modal.Title>
          </Modal.Header>
          <Modal.Body>
            <p>
              Merci de votre achat !
              <br />
              Votre commande a bien été enregistrée sous le numéro XXXXXXX.
              Vous pouvez suivre son état depuis votre espace client.
            </p>
          </Modal.Body>
          <Modal.Footer>
            <Button variant="outline-primary" onClick={handleModalClose} as={Link} to="/products">
              Continuer les achats
            </Button>
            <Button variant="outline-primary" onClick={handleModalClose} as={Link} to="/commandes">
              Voir mes commandes
            </Button>
          </Modal.Footer>
        </Modal>

        <Row className="d-flex justify-content-center align-items-center">
          <Col xs={12} md={6}>
            <Form.Group className="mb-3">
              <Form.Label>Payment Method</Form.Label>
              <Form.Control as="select" value={paymentMethod} onChange={handlePaymentMethodChange}>
                <option value="card">Credit or Debit Card</option>
                <option value="paypal">PayPal</option>
              </Form.Control>
            </Form.Group>
            <Button variant="outline-primary" onClick={handlePaymentSubmit}>
              payer
            </Button>
            <Button variant="outline-secondary" onClick={handleBack}>
                     Retour
                   </Button>
          </Col>
        </Row>
      </div>
    </Container>

          </Col>
          
        </Row>
      )}

     
    </div>
  );
}

export default Cart;
