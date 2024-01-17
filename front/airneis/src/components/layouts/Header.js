import React, { useState } from "react";
import { Link } from "react-router-dom";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faListUl } from '@fortawesome/free-solid-svg-icons';
const Header = () => {
  const [openedDrawer, setOpenedDrawer] = useState(false);

  function toggleDrawer() {
    setOpenedDrawer(!openedDrawer);
  }

  function changeNav(event) {
    if (openedDrawer) {
      setOpenedDrawer(false);
    }
  }

  const getCartItemCount = () => {
    const storedCartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
    return storedCartItems.reduce((total, item) => total + item.quantity, 0);
  };

  const isUserLoggedIn = () => {
    const token = localStorage.getItem('token');
    return !!token; 
  };

  const handleLogout = () => {
    localStorage.removeItem('token'); 
    window.location.href = "/"; 
  };

  const isLogged = isUserLoggedIn(); 

  return (
    <header>
      <nav className="navbar fixed-top navbar-expand-lg navbar-light bg-white border-bottom">
        <div className="container-fluid">
          <Link className="navbar-brand" to="/" onClick={changeNav}>
            <FontAwesomeIcon
              icon={["fab", "bootstrap"]}
              className="ms-1"
              size="lg"
            />
            <span className="ms-2 h5">ÀIRNEIS</span>
          </Link>

          <div className={"navbar-collapse offcanvas-collapse " + (openedDrawer ? "open" : "")}>
            <ul className="navbar-nav me-auto mb-lg-0">
              <li className="nav-item">
                <Link to="/products" className="nav-link" replace onClick={changeNav}>
                  Produits
                </Link>
              </li>
            </ul>
            <button type="button" className="btn btn-outline-dark me-3 d-none d-lg-inline">
              <a href="/panier">
                <FontAwesomeIcon icon={["fas", "shopping-cart"]} />
              </a>
              <span className="ms-3 badge rounded-pill bg-dark">{getCartItemCount()}</span>
            </button>
            <ul className="navbar-nav mb-2 mb-lg-0">
              {isLogged ? ( 
                <>
                  <li className="nav-item">
                    <Link to="/profile" className="nav-link" onClick={changeNav}>
                      Profile <FontAwesomeIcon icon={["far", "smile"]} />
                    </Link>
                  </li>
                  <li className="nav-item">
                    <Link to="/commandes" className="nav-link" onClick={changeNav}>
                      Commandes <FontAwesomeIcon icon={faListUl} />
                    </Link>
                  </li>
                  <li className="nav-item">
                  
                    <Link to="/" className="nav-link" onClick={handleLogout}>
                      Logout <FontAwesomeIcon icon={["fas", "sign-out-alt"]} />
                    </Link>
                  </li>
                </>
              ) : ( 
                <>
                  <li className="nav-item dropdown">
                    <a
                      href="/"
                      className="nav-link dropdown-toggle"
                      data-toggle="dropdown"
                      id="userDropdown"
                      role="button"
                      data-bs-toggle="dropdown"
                      aria-expanded="false"
                    >
                      <FontAwesomeIcon icon={["far", "smile"]} />
                    </a>
                    <ul
                      className="dropdown-menu dropdown-menu-end"
                      aria-labelledby="userDropdown"
                    >
                      <li>
                        <Link to="/login" className="dropdown-item" onClick={changeNav}>
                          Login <FontAwesomeIcon icon={["fas", "sign-in-alt"]} />
                        </Link>
                      </li>
                      <li>
                        <Link to="/inscription" className="dropdown-item" onClick={changeNav}>
                          Inscription <FontAwesomeIcon icon={["fas", "user-plus"]} />
                        </Link>
                      </li>
                    </ul>
                  </li>
                </>
              )}
            </ul>
          </div>

          <div className="d-inline-block d-lg-none">
            <button type="button" className="btn btn-outline-dark">
              <FontAwesomeIcon icon={["fas", "shopping-cart"]} />
              <span className="ms-3 badge rounded-pill bg-dark">{getCartItemCount()}</span>
            </button>
            <button className="navbar-toggler p-0 border-0 ms-3" type="button" onClick={toggleDrawer}>
              <span className="navbar-toggler-icon"></span>
            </button>
          </div>
        </div>
      </nav>

      <div className="mt-16" /> 
    </header>
  );
};

export default Header;
