import { Button, KeyboardAvoidingView, TextInput, View, Text } from "react-native"
import Styles from '../assets/Style.js'; 
import { TouchableOpacity } from "react-native-gesture-handler";
import { useState , useEffect } from "react";
import { useNavigation } from '@react-navigation/native';
import axios from "axios";
import { auth } from "../api/firebase.js";
import { signInWithEmailAndPassword , createUserWithEmailAndPassword , onAuthStateChanged, AuthErrorCodes  } from "firebase/auth";


const AuthenticationScreen = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const navigation = useNavigation(); 


    // useEffect(() => {
    //     const unsubsribe = onAuthStateChanged(auth, (user) => {
    //         if (user) {
    //           navigation.replace("Home")
    //         } else {
    //           // User is signed out
    //           // ...
    //         }
    //       });

    //       return unsubsribe;
    // }, [])


    const handleSignup = () => {
        createUserWithEmailAndPassword(auth, email, password)
            .then(userCredential => {
                // navigation.replace("Home")
                const user = userCredential.user;
                console.log("Registered with : "+user.email)

                axios.post("https://airneis-api-default-rtdb.europe-west1.firebasedatabase.app/User.json",
                    {
                        uid : user.uid,
                        email: email,
                        password: password,
                        returnSecureToken: true,
                    }
                  )
                    .then(() => {}
                    )
                    .catch((err) => {
                    alert(err.message);
                    })
            })
            .catch(error => alert(error.message))
    }

    const handleLogin = () => {
        signInWithEmailAndPassword(auth, email, password)
            .then(userCredential => {
                navigation.navigate("Home")
                const user = userCredential.user;
                // console.log("Logged with : "+user?.email)
            })
            .catch(error => {
                error.code == AuthErrorCodes.INVALID_PASSWORD ? alert("Mot de passe incorrect.")
                    : alert(error.message)})
    }


    return (
        <View
        style={[Styles.container, Styles.centered]}
        // behavior="padding"
        >
            <View style={ Styles.inputContainer}>
                <TextInput
                    placeholder="Email"
                    value={ email }
                    onChangeText={ text => setEmail(text)}
                    style={Styles.input}>
                    
                </TextInput>
                <TextInput
                    placeholder="Password"
                    value={ password}
                    onChangeText={ text => setPassword(text)}
                    style={Styles.input}
                    secureTextEntry>
                    
                </TextInput>
            </View>
            <View style={ Styles.buttonContainer }>
                <TouchableOpacity
                    onPress={ handleLogin }
                    style={ Styles.button }>
                    <Text style={ Styles.buttonText }>Login</Text>
                </TouchableOpacity>
                <TouchableOpacity
                    onPress={ handleSignup }
                    style={[ Styles.button , Styles.buttonOutLine]}>
                    <Text style={ [ Styles.buttonText , Styles.buttonOutLineText ] }>Register</Text>
                </TouchableOpacity>   
            </View>
    
        </View>
    )
}

export default AuthenticationScreen;