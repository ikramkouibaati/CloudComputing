import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import axios from "axios";

function Product(props) {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchProducts = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/produits");
        setProducts(response.data);
        setLoading(false);
      } catch (error) {
        console.error(error);
      }
    };

    fetchProducts();
  }, []);

  if (loading) {
    return <div>Loading...</div>;
  }

  const addToCart = (product) => {
    
    const cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];

    
    const existingItem = cartItems.find((item) => item.id === product.id_produit);

    if (existingItem) {
    
      existingItem.quantity += 1;
    } else {
      cartItems.push({
        id: product.id_produit,
        name: product.nom_produit,
        price: product.prix,
        quantity: 1,
      });
    }
    localStorage.setItem("cartItems", JSON.stringify(cartItems));
  };


  return (
    <>
      {products.length === 0 ? (
        <div>No products found.</div>
      ) : (
        products.map((product) => (
          <div className="col" key={product.id_produit}>
            <div className="card shadow-sm">
              <Link to={`/products/${product.id_produit}`} href="!#" replace>
                <img
                  className="card-img-top bg-dark cover"
                  height="200"
                  alt=""
                  src={product.image}
                />
              </Link>
              <div className="card-body">
                <h5 className="card-title text-center text-dark text-truncate">
                  {product.nom_produit}
                </h5>
                <p className="card-text text-center text-muted mb-0">{product.prix}€</p>
                <div className="d-grid d-block">
                <button className="btn btn-outline-dark mt-3" onClick={() => addToCart(product)}>
        <FontAwesomeIcon icon={["fas", "cart-plus"]} /> Add to cart
      </button>
                  <Link
                    to={`/products/${product.id_produit}`}
                    className="btn btn-outline-primary mt-2"
                  >
                    View More
                  </Link>
                </div>
              </div>
            </div>
          </div>
        ))
      )}
    </>
  );
}

export default Product;
