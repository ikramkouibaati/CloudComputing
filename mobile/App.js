import * as React from 'react';

import ProfileScreen from './screens/ProfileScreen';
import SettingsScreen from './screens/SettingsRefer';
import HomeScreen from './screens/HomeScreen';
import SingleScreen from './screens/SingleScreen';
import AuthenticationScreen from './screens/AuthenticationScreen'
import DrawerItems from './constants/DrawerItems';
import { createNativeStackNavigator } from '@react-navigation/native-stack';

import {  StyleSheet } from 'react-native';
import { useEffect , useState } from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { MaterialCommunityIcons, FontAwesome5, Feather } from '@expo/vector-icons';
import {  createDrawerNavigator } from '@react-navigation/drawer';
import { auth } from './api/firebase';
import {  onAuthStateChanged } from "firebase/auth";




const Drawer = createDrawerNavigator()
const Stack = createNativeStackNavigator();

const HomeStack = (user) => {
  return (
    <Stack.Navigator screenOptions={{ headerShown: false }}>
      <Stack.Screen name="Home" component={HomeScreen} />
      <Stack.Screen name="SingleScreen"  component={SingleScreen}/>
      {/* Ajoutez d'autres écrans du StackNavigator ici si nécessaire */}
    </Stack.Navigator>
  );
};


export default function App() {


    const [user, setUser] = useState(null); // Ajoutez un état pour stocker les informations de l'utilisateur connecté
    // on récupère l'user
    useEffect(() => {
      const unsubscribe = onAuthStateChanged(auth, user => {
        setUser(user); // Met à jour l'état de l'utilisateur avec les informations de l'utilisateur connecté ou null s'il n'y a pas d'utilisateur connecté
      });
  
      return unsubscribe;
    }, []);

  return (
    <NavigationContainer>
      <Drawer.Navigator 
        drawerType="front"
        initialRouteName="Home"
        screenOptions={{
          activeTintColor:'#e91e63',
          itemStyle:{ marginVertical: 10}
        }}
      >
        {
          DrawerItems.map(drawer => <Drawer.Screen
            key={drawer.name}
            name={drawer.name}
            options={{
              drawerIcon:({focused})=>
              drawer.iconType==='Material' ?
                <MaterialCommunityIcons
                  name={drawer.iconName}
                  size={24}
                  color={focused ? "#e91e63" : "black"}
                />
              :
              drawer.iconType==='Feather' ?
                <Feather
                  name={drawer.iconName}
                  size={24}
                  color={focused ? "#e91e63" : "black"}
                />
              :
                <FontAwesome5
                  name={drawer.iconName}
                  size={24}
                  color={focused ? "#e91e63" : "black"}
                />
            }}
            component={
              
              drawer.name==='Settings' ? SettingsScreen
                : drawer.name==='Login' ? AuthenticationScreen
                : drawer.name==='Home' ? HomeStack
                    : HomeStack
            }
            />)
        }

            { user && (
            <Drawer.Screen
              name="Profile"
              component={ProfileScreen}
              options={{
                drawerIcon: ({focused})=><FontAwesome5
                name={'user'}
                size={24}
                color={focused ? "#e91e63" : "black"}
              />
              // drawerLabel: null, // Masque l'écran "Login" dans le menu latéral si l'utilisateur est connecté
                      
              }}
            />
            )}
 
            {!user && (
            <Drawer.Screen
              name="Authentification"
              component={AuthenticationScreen}
              options={{
                drawerIcon: ({focused})=><FontAwesome5
                name={'user'}
                size={24}
                color={focused ? "#e91e63" : "black"}
              />                      
              }}
            />
            )}
            {/* <Drawer.Screen name="SingleScreen" component={SingleScreen} options={{ drawerLabel: '' }} /> */}


      </Drawer.Navigator>
    </NavigationContainer>
    // <View style={styles.container}>
    //   <Text>Open up App.js to start working on your app!</Text>
    //   <StatusBar style="auto" />
    // </View>
  );
}
