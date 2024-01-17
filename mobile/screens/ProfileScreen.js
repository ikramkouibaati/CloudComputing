import * as React from 'react';
import { View, Text, Button } from "react-native";
import { auth } from '../api/firebase';
import { useNavigation } from '@react-navigation/native';
import Styles from '../assets/Style';
import { signOut } from 'firebase/auth';
import { TouchableOpacity } from "react-native-gesture-handler";

export default function ProfileScreen() {
    const navigation = useNavigation();

    const handleSignOut = () => {
        signOut(auth)
            .then( () => {
                navigation.navigate("Home")
            })
            .catch(err => console.log(err.message))
    }

    return (
        <View style={{flex:1, alignItems: 'center', justifyContent: 'center'}}>
            <Text style={{fontSize: 16, fontWeight: '700'}}>Profile Screen</Text>
            <Text >{auth.currentUser?.email}</Text>
            <TouchableOpacity style={ Styles.button } onPress={ handleSignOut }>
                <Text style={ Styles.buttonText }> Sign out</Text>
            </TouchableOpacity>
        </View>
    );
}