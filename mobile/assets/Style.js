import { StyleSheet } from "react-native"


const Styles = StyleSheet.create({
    // height:{height : ScreenHeight }, 
    container: {
      flex: 1,
      padding: 10,
    },

    centered : {
      justifyContent:'center',
      alignItems:'center',
    },

    inputContainer : {
      width:'80%'
    },

    buttonContainer : {
      marginTop:40,
      width:'70%',
      paddingBottom:50,
    },

    image: {
      width: '100%',
      height: 200,
      resizeMode: 'cover',
      borderRadius: 8,
    },

    title: {
      fontSize: 18,
      fontWeight: 'bold',
      marginTop: 10,
    },

    description: {
      fontSize: 16,
      marginTop: 10,
    },

    price: {
      fontSize: 18,
      fontWeight: 'bold',
      marginTop: 10,
      color: 'green',
    },

    card:{ flexDirection:'column', flex:3, backgroundColor: 'white', borderWidth: 1,borderColor:'grey', margin:10, borderRadius:7 , elevation : 3,},

    cardImage:{ flex:1, borderTopLeftRadius:7, borderTopRightRadius:7 },

    input:{

      borderRadius:10,

      marginTop:5,
      padding:10,
      backgroundColor:'white',
    },

    button : {
      backgroundColor:"black",
      borderWidth:0.5,
      borderRadius:6,
      padding:10,
      marginTop: 5,
      marginHorizontal : 5
    },

    buttonText : {
      textAlign:'center',
      fontSize:15,
      color : 'white',
    },

    buttonOutLine : {
      backgroundColor : 'white',
    },

    buttonOutLineText : {
      color : 'black',
    },

    titleCategory: {
      backgroundColor : "#f9f9fc",
      shadowOffset : { width : 10, height : 20},
      shadowColor : 'black',
      elevation : 3
      
    }

  })

export default Styles;