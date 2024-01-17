import WithTemplate from "./components/layouts/WithTemplate";
import LoginForm from "./pages/Logins";
import RegisterForm from "./pages/Register";
import Commande from "./pages/commande/Commande";
import ProductDetail from "./pages/ProductDetail";
import { Routes, Route } from "react-router-dom";
import Home from "./pages/Home";
import CGU from "./pages/CGU";
import AboutUs from "./pages/AboutUs";
import MentionsLegales from "./pages/MentionsLegales";
import ProductList from "./pages/ProductList";
import ListCommande from "./pages/commande/ListCommande";
import UserProfile from './pages/users/UserProfile';
import Index from "./pages/backoffice/Index";
import Products from "./pages/backoffice/Products";
import Categories from "./pages/backoffice/Categories";
import DetailProduct from "./pages/backoffice/DetailProduct";
import DetailCategory from "./pages/backoffice/DetailCategory";
import AddProduct from "./pages/backoffice/AddProduct";
import AddCategory from "./pages/backoffice/AddCategory";
import ListMessages from "./pages/backoffice/ListMessages";
import Login from "./pages/backoffice/Login";


function App() {
    return (
        <Routes>
            <Route path="/" element={WithTemplate(Home)} />
            <Route path="/products" element={WithTemplate(ProductList)} />
            <Route path="/products/:id" element={WithTemplate(ProductDetail)} />
            <Route path="/panier" element={WithTemplate(Commande)} />
            <Route path="/commandes" element={WithTemplate(ListCommande)} />
            <Route path="/profile" element={WithTemplate(UserProfile)}/>
            <Route path="/cgu" element={WithTemplate(CGU)}/>
            <Route path="/mentions-legales" element={WithTemplate(MentionsLegales)}/>
            <Route path="/about" element={WithTemplate(AboutUs)}/>

            <Route path="/profile" element={WithTemplate(UserProfile)} />
            <Route path="/cgu" element={WithTemplate(CGU)} />
            <Route path="/mentions-legales" element={WithTemplate(MentionsLegales)} />
            <Route path="/about" element={WithTemplate(AboutUs)} />

            <Route path="/login" element={<LoginForm />} />
            <Route path="/inscription" element={<RegisterForm />} />
            <Route path="/backoffice/login" element={<Login />} />
            <Route path="/backoffice" element={<Index />} />
            <Route path="/backoffice/products" element={<Products />} />
            <Route path="/backoffice/product/:id" element={<DetailProduct />} />
            <Route path="/backoffice/product/add" element={<AddProduct />} />
            <Route path="/backoffice/categories" element={<Categories />} />
            <Route path="/backoffice/category/:id" element={<DetailCategory />} />
            <Route path="/backoffice/category/add" element={<AddCategory />} />
            <Route path="/backoffice/messages" element={<ListMessages />} />
        </Routes>
    );
}

export default App;
