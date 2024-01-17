import React, { useState, useEffect } from "react";
import Banner from "../components/home/Banner";
import ImageWithCategory from "../components/home/Category";
import ScrollToTopOnMount from "../lib/ScrollToTopOnMount";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { Link } from "react-router-dom";

function Home() {
  const [randomProducts, setRandomProducts] = useState([]);

  useEffect(() => {
    const fetchRandomProducts = async () => {
      try {
        const response = await fetch(
          "http://127.0.0.1:8000/api/produitsRandom" 
        );
        const data = await response.json();
        setRandomProducts(data); 
      } catch (error) {
        console.error(error);
      }
    };

    fetchRandomProducts();
  }, []);

  return (
    <>
      <ScrollToTopOnMount />

      <Banner />
      <div className="d-flex flex-column bg-white py-4">
        <p className="text-center px-5">
          The shop with the authentic furnitures that your place needs
        </p>
        <div className="d-flex justify-content-center">
          <Link to="/products" className="btn btn-primary" replace>
            Browse products
          </Link>
        </div>
      </div>
      <h2 className="text-muted text-center mt-4 mb-3">Catégories</h2>
      <br />
      <div className="container pb-5 px-lg-5">
        <div className="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 px-md-5 justify-content-center"> 
          <ImageWithCategory />
        </div>
      </div>
      <h2 className="text-muted text-center mt-4 mb-3">Random Products</h2>
      <div className="container pb-5 px-lg-5">
        <div className="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 px-md-5">
          {randomProducts.map((product) => (
            <div key={product.id} className="col">
              <div className="card h-100">
               
                <div className="card-body">
                <h5 className="card-title">{product.nom_categorie}</h5>
                    <h5 className="card-title">{product.nom_produit}</h5>
                    <p className="card-text">{product.prix} €</p>
                   

                  <Link to={`/products/${product.id_produit}`} className="btn btn-primary">
                    View Product
                  </Link>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>

      <div className="d-flex flex-column bg-white py-4">
        <h5 className="text-center mb-3">Follow us on</h5>
        <div className="d-flex justify-content-center">
          <a href="!#" className="me-3">
            <FontAwesomeIcon icon={["fab", "facebook"]} size="2x" />
          </a>
          <a href="!#">
            <FontAwesomeIcon icon={["fab", "instagram"]} size="2x" />
          </a>
          <a href="!#" className="ms-3">
            <FontAwesomeIcon icon={["fab", "twitter"]} size="2x" />
          </a>
        </div>
      </div>
    </>
  );
}

export default Home;
