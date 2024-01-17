import Image from "../assets/img/nillkin-case-1.jpg";
import RelatedProduct from "../components/products/RelatedProduct";
import Ratings from "react-ratings-declarative";
import ScrollToTopOnMount from "../lib/ScrollToTopOnMount";
import { useState, useEffect } from "react";
import axios from "axios";
import { Link, useParams } from "react-router-dom";

const iconPath =
    "M18.571 7.221c0 0.201-0.145 0.391-0.29 0.536l-4.051 3.951 0.96 5.58c0.011 0.078 0.011 0.145 0.011 0.223 0 0.29-0.134 0.558-0.458 0.558-0.156 0-0.313-0.056-0.446-0.134l-5.011-2.634-5.011 2.634c-0.145 0.078-0.29 0.134-0.446 0.134-0.324 0-0.469-0.268-0.469-0.558 0-0.078 0.011-0.145 0.022-0.223l0.96-5.58-4.063-3.951c-0.134-0.145-0.279-0.335-0.279-0.536 0-0.335 0.346-0.469 0.625-0.513l5.603-0.815 2.511-5.078c0.1-0.212 0.29-0.458 0.547-0.458s0.446 0.246 0.547 0.458l2.511 5.078 5.603 0.815c0.268 0.045 0.625 0.179 0.625 0.513z";

    function ProductDetail() {
        const params = useParams();
        const [product, setProduct] = useState(null);
        const [loading, setLoading] = useState(true);
      
        useEffect(() => {
          axios
            .get(`http://127.0.0.1:8000/api/produits/${params.id}`)
            .then((response) => {
              const productData = response.data;
              console.log(response.data)
              setProduct(productData);
            })
            .catch((error) => {
              console.error("Erreur lors de la récupération des données du produit :", error);
            });
        }, []);
      
        function changeRating(newRating) {}
      


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
          <div className="container mt-5 py-4 px-xl-5">
            <ScrollToTopOnMount />
            {product && (
              <nav aria-label="breadcrumb" className="bg-custom-light rounded mb-4">
                <ol className="breadcrumb p-3">
                  <li className="breadcrumb-item">
                    <Link className="text-decoration-none link-secondary" to="/products">
                      All Products
                    </Link>
                  </li>
                  
                  <li className="breadcrumb-item active" aria-current="page">
                    {product.nom_produit}
                  </li>
                </ol>
              </nav>
            )}
            <div className="row mb-4">
             
              <div className="col-lg-6">
                <div className="row">
                  <div className="col-12 mb-4">
                    <img className="border rounded ratio ratio-1x1" alt="" src={Image} />
                  </div>
                </div>
               
              </div>
              <div className="col-lg-5">
                <div className="d-flex flex-column h-100">
                  {product && (
                    <>
                      <h2 className="mb-1">{product.nom_produit}</h2>
                      <h4 className="text-muted mb-4">{product.prix} €</h4>
                      <div className="row g-3 mb-4">
                        <div className="col">
                        <button className="btn btn-outline-dark py-2 w-100" onClick={() => addToCart(product)}>
                          Add to cart
                        </button>

                        </div>
                        
                      </div>
                      <h4 className="mb-0">Details</h4>
                      <hr />
                      <dl className="row">
                      
                        <dt className="col-sm-4">Rating</dt>
                        <dd className="col-sm-8 mb-3">
                          <Ratings
                            rating={4.5}
                            widgetRatedColors="rgb(253, 204, 13)"
                            changeRating={changeRating}
                            widgetSpacings="2px"
                          >
                            {Array.from({ length: 5 }, (_, i) => {
                              return (
                                <Ratings.Widget
                                  key={i}
                                  widgetDimension="20px"
                                  svgIconViewBox="0 0 19 20"
                                  svgIconPath={iconPath}
                                  widgetHoverColor="rgb(253, 204, 13)"
                                />
                              );
                            })}
                          </Ratings>
                        </dd>
                      </dl>
                      <h4 className="mb-0">Description</h4>
                      <hr />
                      <p className="lead flex-shrink-0">
                        <small>{product.description}</small>
                      </p>
                    </>
                  )}
                </div>
              </div>
            </div>
           
          </div>
        );
      }
      
      export default ProductDetail;
      