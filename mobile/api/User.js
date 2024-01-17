import { useEffect, useState } from "react";
import { auth } from "./firebase";

const User = () => {

    const [uid, setUid] = useState("")

    const getUid = () => {return(uid)};

    useEffect(() => {
        onAuthStateChanged(auth, (user) => {
            if (user) {
              // User is signed in, see docs for a list of available properties
              // https://firebase.google.com/docs/reference/js/auth.user
              setUid(user.uid)
              // ...
            } else {
              setUid(null)
            }
          });
    })


}

export default User;