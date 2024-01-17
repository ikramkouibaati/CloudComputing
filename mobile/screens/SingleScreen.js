import * as React from 'react';
import { View, Text, Image, Stylesheet , Alert } from "react-native";
import axios from 'axios';
import { TouchableOpacity } from "react-native-gesture-handler";
import { useNavigation } from '@react-navigation/native';
import Styles from '../assets/Style';
import { onAuthStateChanged } from 'firebase/auth';
import { auth } from '../api/firebase';


export default function SingleScreen(props) {
    const { idProduit } = props.route.params;
    const [ produit, setProduit ] = React.useState([])
    const navigation = useNavigation(); 
    
    const [user, setUser] = React.useState(null); // Ajoutez un état pour stocker les informations de l'utilisateur connecté
    // on récupère l'user
    React.useEffect(() => {
      const unsubscribe = onAuthStateChanged(auth, user => {
        setUser(user); // Met à jour l'état de l'utilisateur avec les informations de l'utilisateur connecté ou null s'il n'y a pas d'utilisateur connecté
      });
  
      return unsubscribe;
    }, []);

    const handleAjoutPanier = () => {
      if (!user) {
        navigation.navigate("Authentification");
      } else {
        // alert("Produit ajouté au panier")
        Alert.alert(
          'Merci',
          'Produit ajouté au panier !',
          [
            {
              text: 'Ok',
              
              style: 'default',
            },
          ],
          {
            cancelable: true,
            
          },
        );
      }
    }


    React.useEffect(() => {    1
    
        if (idProduit) {
            axios({method:"get", url:`https://projet-e-commerce-temp-default-rtdb.europe-west1.firebasedatabase.app/Produit/${idProduit}.json`})
            .then(({data}) => {
                
                setProduit(data)
            //   const resultat = []
            //   for(const key in data) {
            //       (data[key]) && resultat.push({...data[key], id : key})
            //   }
            //   setProduits(resultat)
          }
            )
            .catch((err) => {
              console.log(err);
            });
        }
            
      }, []);
      const { img, nom_produit, description, prix } = produit;

    return (
        // <View >
        //     <View style={{flexDirection:'column', backgroundColor:'#555555'}}>
        //         <Text style={{fontSize:30,fontWeight:'700', margin:10}}>{produit.nom_produit}</Text>
        //         <Image 
        //             style={{ flex:1, borderTopLeftRadius:7, borderTopRightRadius:7, height: 300, flex: 1, width: null}}
        //             source={{uri:produit.img}}
        //             onError={() => console.log("Erreur de chargement de l'image")}
        //             />
        //     </View>
        // </View>
      <View style={Styles.container}>
        <Text style={Styles.title}>{nom_produit}</Text>
        <Image source={{ uri: img }} style={Styles.image} />
        
        <Text style={Styles.description}>{description}</Text>
        <Text style={Styles.price}>{prix} €</Text>
        <TouchableOpacity
            onPress={ handleAjoutPanier }
            style={ Styles.button }>
            <Text style={ Styles.buttonText }>Ajouter au panier</Text>
        </TouchableOpacity>
      </View>
    );
}