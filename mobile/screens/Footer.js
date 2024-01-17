import { View, Text } from "react-native"

export default function Footer () {
    return(
        <View style={{flex:1, backgroundColor:'white', alignItems:'center'}}>
            <Text style={{fontSize:30,fontWeight:'800', margin:15}}>AIRNES</Text>
            <View style={{ alignItems:'center',  backgroundColor: '#EEE', width: '100%' }}>
                <Text style={{ fontSize: 15, fontWeight: '300' }}>Copyright - Airnes</Text>
            </View>

        </View>
    )
}