import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';
import { Carousel } from 'react-responsive-carousel';

const ImageWithCategory = () => {
  const [categories, setCategories] = useState([]);

  useEffect(() => {
    const fetchCategories = async () => {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/categories');
        setCategories(response.data);
      } catch (error) {
        console.error(error);
      }
    };

    fetchCategories();
  }, []);

  const handleMouseEnter = (categoryId) => {
    setCategories((prevCategories) =>
      prevCategories.map((category) =>
        category.id_categorie === categoryId ? { ...category, hovered: true } : category
      )
    );
  };

  const handleMouseLeave = (categoryId) => {
    setCategories((prevCategories) =>
      prevCategories.map((category) =>
        category.id_categorie === categoryId ? { ...category, hovered: false } : category
      )
    );
  };

  return (
    <div style={{ display: 'flex', justifyContent: 'center' }}>
      <Carousel showStatus={false} showThumbs={false} infiniteLoop autoPlay>
        {categories.map((categorie) => (
          <div
            key={categorie.id_categorie}
            onMouseEnter={() => handleMouseEnter(categorie.id_categorie)}
            onMouseLeave={() => handleMouseLeave(categorie.id_categorie)}
            style={{ position: 'relative', overflow: 'hidden' }}
          >
            <Link to={`/products`}>
              <img
                src="https://shop.static.ingka.ikea.com/category-images/Category_sofas-and-armchairs.jpg"
                alt="Image"
                style={{ width: '100%', borderRadius: '5px' }}
              />
              {categorie.hovered && (
                <div
                  style={{
                    position: 'absolute',
                    top: '0',
                    left: '0',
                    width: '100%',
                    height: '100%',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    backgroundColor: 'rgba(0, 0, 0, 0.3)',
                    color: 'white',
                    textShadow: '2px 2px 4px rgba(0, 0, 0, 0.5)',
                  }}
                >
                  <span style={{ fontWeight: 'bold', fontSize: '20px' }}>
                    {categorie['nom_categorie']}
                  </span>
                </div>
              )}
            </Link>
          </div>
        ))}
      </Carousel>
    </div>
  );
};
export default ImageWithCategory;
