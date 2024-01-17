import * as React from 'react';
import SingleScreen from './SingleScreen';
import { Dimensions, View, Text, Image, StyleSheet, Button } from "react-native";
import { ScrollView } from 'react-native-gesture-handler';
import axios from 'axios'
import { TouchableOpacity } from "react-native-gesture-handler";


import ProduitCard from './ProduitCard';
import Footer from './Footer';
import { createDrawerNavigator } from '@react-navigation/drawer';
import { useNavigation } from '@react-navigation/native';
import Styles from '../assets/Style.js'; 



const ScreenHeight = Dimensions.get("window").height;



const logo = {
  uri: 'https://reactnative.dev/img/tiny_logo.png',
  width: 64,
  height: 64,
};



export default function HomeScreen() {

  const [produits, setProduits] = React.useState([])
  const [a, seta] = React.useState("nan")
  const navigation = useNavigation();  

  React.useEffect(() => {
    // fetch('https://projet-e-commerce-temp-default-rtdb.europe-west1.firebasedatabase.app/Produit.json') // Remplacez l'URL par l'URL réelle de votre API
    //   // .then(response => response.json())
    //   .then(Response => {
    //     setProduits(Response.data); // Mettre à jour l'état avec les articles récupérés depuis l'API
    //     seta("LALALALALALAL")
    //     var b = "B"
    //   })
    //   .catch(error => {
    //     console.error('Erreur lors de la récupération des articles depuis l\'API:', error);
    //   });


        axios({method:"get", url:"https://airneis-api-default-rtdb.europe-west1.firebasedatabase.app//Produit.json"})
        .then(({data}) => {
          const resultat = []
          for(const key in data) {
              (data[key]) && resultat.push({...data[key], id : key})
          }
          setProduits(resultat)
      }
        )
        .catch((err) => {
          console.log(err.message);
        });
  }, []);

   return (
    <ScrollView >
      {/* View HEADER */}
      <View style={{ alignItems: 'center', justifyContent: 'center' }}>
        <View style={{ height: ScreenHeight, flex:1, alignItems: 'center', justifyContent: 'center' }}>
          <Text style={{fontSize:30,fontWeight:'800'}}>AIRNES</Text>
          <Text style={{fontSize:15,fontWeight:'700', color:'#a9a9a9'}}>Boutique de mobilier</Text>
        </View>
      </View>

      {/* View titre */}
      <View style={Styles.titleCategory}>
        <Text style={{fontSize:25,fontWeight:'400', margin:10}}>Liste des produit</Text>
      </View>
      <View>
        {produits.map((produit) => {
          return(
            // {/* //Home made Card */}
            <View key={produit.nom_produit} style={Styles.card}>
              <Image style={[Styles.cardImage, {height: 300, flex: 1, width: null}]} source={{uri:produit.img[0]}}/>
              <View style={{alignItems: 'center', justifyContent: 'center', padding:5}}>
                <Text style={{fontSize:30,fontWeight:'700', margin:10}}>{produit.nom_produit}</Text>
                <Text style={{fontSize:15,fontWeight:'300', color:'black'}}>{produit.description}</Text>
              </View>
              <View style={{flexDirection:'row', justifyContent:'space-between'}}>
                <View style={{ margin:10, }}>
                  <Text style={{fontSize:20,fontWeight:'400',  padding:6,borderRadius:6, backgroundColor:'#f5f5f5'}}>{produit.prix} €</Text>
                </View>

                <View style={{ margin:10, flexDirection:'row'}}>
                <TouchableOpacity
                    onPress={ () => {navigation.navigate('SingleScreen', { idProduit : produit.id })} }
                    style={[ Styles.button , Styles.buttonOutLine]}>
                    <Text style={ [ Styles.buttonText , Styles.buttonOutLineText ] }>Voir</Text>
                </TouchableOpacity>   
                  <TouchableOpacity
                    onPress={ () => {} }
                    title="Ajouter au panier"
                    style={ Styles.button}
                  >
                    <Text style={ Styles.buttonText}>Ajouter au panier</Text>
                  </TouchableOpacity>
                </View>
              </View>
            </View>

            // {/* <ProduitCard key={produit.id} produit={produit} /> */}

          )          
        })}
      </View>

      <Footer/>

    </ScrollView>
   );
 }
