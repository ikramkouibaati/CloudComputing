import React from 'react';
import { View, Text, Image, StyleSheet } from 'react-native';

const ProduitCard = ({ produit }) => {
  return (
    <View style={styles.container}>
      <Image source={{ uri: produit.img }} style={styles.image} />
      <Text style={styles.title}>{produit.nom_produit}</Text>
      <Text style={styles.price}>Price: {produit.prix} €</Text>
      <Text style={styles.description}>{produit.description}</Text>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    backgroundColor: '#fff',
    borderRadius: 8,
    padding: 16,
    marginBottom: 16,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 2,
  },
  image: {
    width: '100%',
    height: 200,
    marginBottom: 8,
    resizeMode: 'cover',
    borderRadius: 4,
  },
  title: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 4,
  },
  price: {
    fontSize: 16,
    color: '#888',
    marginBottom: 8,
  },
  description: {
    fontSize: 14,
    color: '#444',
  },
});

export default ProduitCard;
