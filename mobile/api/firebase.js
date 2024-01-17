// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAuth } from "firebase/auth";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyA0pb-M1ZEVQYCzklqU63g5By-RDH3VQno",
  authDomain: "airneis-api.firebaseapp.com",
  projectId: "airneis-api",
  storageBucket: "airneis-api.appspot.com",
  messagingSenderId: "353153381388",
  appId: "1:353153381388:web:9fff9331b3c5b1215cea29"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Initialize Firebase Authentication and get a reference to the service
const auth = getAuth(app);

export { auth };