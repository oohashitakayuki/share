// Import the functions you need from the SDKs you need
import firebase from "firebase/app"
import 'firebase/auth'
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyBjyU-et4NBzXoU01g4KnMYk2ymN9UkoOc",
  authDomain: "share-c9b86.firebaseapp.com",
  projectId: "share-c9b86",
  storageBucket: "share-c9b86.firebasestorage.app",
  messagingSenderId: "17260456478",
  appId: "1:17260456478:web:3d095d249e6444a195dc0f"
};

if (!firebase.apps.length) {
  firebase.initializeApp(firebaseConfig)
}

export const auth = firebase.auth()
export default firebase